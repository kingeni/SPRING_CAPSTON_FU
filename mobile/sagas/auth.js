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
  UPDATE_USER_INFO_START,
  actions as UserActions,
} from '../reducers/user';
import {
  actions as TransActions,
} from '../reducers/transactions';
import FormData from 'FormData';


export function* handleUserLogin() { // eslint-disablae-line no-underscore-dangle
  while (true) {

    const { payload } = yield take(LOGIN_START);
    let formData = new FormData();
    console.log('login');
    // formData.append('username','huytd');
    // formData.append('password','123456');
    formData.append('username', payload.username);
    formData.append('password', payload.password);

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

  if (token) {
    yield put(TransActions.stopTransaction());
    yield put(AuthActions.loginSuccess(token));
    yield call(NavigationService.goToHome);
  } else {
    yield put(TransActions.stopTransaction());
    yield call(NavigationService.gotoLogin);
  }
}
function* updateUsersInfor() {
  while (true) {
    const { payload } = yield take(UPDATE_USER_INFO_START);
    const { user } = payload;
    let formData = new FormData();
    formData.append('first_name', user.first_name);
    formData.append('last_name', user.last_name);
    formData.append('gender', user.gender);
    formData.append('date_of_birth', user.date_of_birth);
    formData.append('email', user.email);
    formData.append('img', user.img_url);

    try {
      const { updateStatus, timeout } = yield race({
        updateStatus: call(Api.updateUserInfor, formData, user.user_id),
        timeout: delay(15000),
      });
      if (timeout) {
        console.log('Unable to update.\nPlease try again later!')
        continue;
      }
      const { response, error } = updateStatus;

      if (error) {
        console.log('error Response:', error);
        continue;
      }

      const { data } = response;
      console.log('data:', data);
      yield put(UserActions.updateUserInfoSuccess(user));

    } catch (error) {
      console.log('errorUpdate: ', error);
    }
  }
}
export default function* authFlow() {
  yield all([
    handleUserLogin(),
    verifyUser(),
    updateUsersInfor(),
  ]);
}
