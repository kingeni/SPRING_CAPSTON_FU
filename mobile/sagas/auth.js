import {
  call, put, select, all, take, race, delay
} from 'redux-saga/effects';
import decode from 'jwt-decode';
import Api from '../common/api';
import NavigationService from '../common/NavigationService';
import {
  LOGIN_START,
  actions as AuthActions,
  getToken,
} from '../reducers/auth';
import {
  actions as UserActions,
} from '../reducers/user';
import FormData from 'FormData';

export function* handleUserLogin() { // eslint-disablae-line no-underscore-dangle
  while (true) {
    const { payload } = yield take(LOGIN_START);
    let formData = new FormData();
    // formData.append('username','huytd');
    // formData.append('password','123456');
    formData.append('username',payload.username);
    formData.append('password',payload.password);
    try {
      const { login, timeout } = yield race({
        login: call(Api.login, formData),
        timeout: delay(15000),
      });
    
      if (timeout) {
        yield put(AuthActions.loginFailed('Unable to login.\nPlease try again later!'));
        continue;
      }

      const { error, response } = login;
      if (error) {
        yield put(AuthActions.loginFailed(Api.getNiceErrorMsg(error.response)));
        continue;
      }

      const { data } = response;
      // yield call(Api.setToken, data.token);

      const userData = data[0] || {};

      yield put(AuthActions.loginSuccess(userData.access_token));
      yield put(UserActions.downloadUserInfoSuccess(userData));
      yield call(NavigationService.goToHome);
    } catch (error) {
      yield put(AuthActions.loginFailed(error));
    }
  }
}

export function* verifyUser() { // eslint-disable-line no-underscore-dangle
  const token = yield select(getToken);
  console.log(token);
  if (token) {
    yield call(NavigationService.goToHome);
  } else {
    yield call(NavigationService.gotoLogin);
  }
}

export function* handleRegistration() {
  while (true) {
    const { payload } = yield take(SIGNUP_START);
    try {
      const { register, timeout } = yield race({
        register: call(Api.register, payload),
        timeout: call(delay, 15000),
      });
      if (timeout) {
        yield put(AuthActions.registerFailed('Unable to connect to server.\nPlease try again later!'));
        continue;
      }
      const { error, response } = register;
      if (error) {
        yield put(AuthActions.registerFailed(Api.getNiceErrorMsg(error.response)));
        continue;
      }
      const { data } = response;
      const { username, token } = data;
      yield call(Api.setToken, data.token);
      yield put(AuthActions.registerSuccess(username, token));
    } catch (error) {
      yield put(AuthActions.registerFailed(error));
      console.log(error);
    }
  }
}

export default function* authFlow() {
  yield all([
    handleUserLogin(),
    // handleRegistration(),
    verifyUser(),
  ]);
}
