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
  UPDATE_PASSWORD,
  getUser,
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
        yield put(AuthActions.loginFailed(null));
        continue;
      }

      const { error, response } = login;
      if (error) {
        yield put(AuthActions.loginFailed(Api.getNiceErrorMsg(error.response)));
        yield put(AuthActions.loginFailed(null));
        continue;
      }

      const { data } = response;
      // yield call(Api.setToken, data.token);

      const userData = data[0] || null;

      if (userData === null) {

        yield put(AuthActions.loginFailed('Wrong Username or password'));
        yield put(AuthActions.loginFailed(null));
        continue;
      }

      yield put(AuthActions.loginSuccess(userData.access_token));
      yield put(UserActions.downloadUserInfoSuccess(userData));
      yield call(NavigationService.goToHome);
    } catch (error) {
      yield put(AuthActions.loginFailed(error));
      yield put(AuthActions.loginFailed(null));
    }
  }
}

export function* verifyUser() { // eslint-disable-line no-underscore-dangle

  const token = yield select(getToken);
  console.log('VerifyUser');
  if (token) {
    yield put(TransActions.stopTransaction());
    yield put(AuthActions.loginSuccess(token));
    yield call(NavigationService.goToHome);
  } else {
    yield put(TransActions.stopTransaction());
    yield call(NavigationService.gotoLogin);
  }
}
export function* updateUsersInfor() {
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
        yield put(UserActions.updateUserInfoFailed('Request Timeout.\nPlease try again later!'));
        yield put(UserActions.updateUserInfoFailed(null));
        continue;
      }
      const { response, error } = updateStatus;

      if (error) {
        yield put(UserActions.updateUserInfoFailed(Api.getNiceErrorMsg(error.response)));
        yield put(UserActions.updateUserInfoFailed(null));
        continue;
      }

      const { data } = response;
      yield put(UserActions.updateUserInfoSuccess(user));
      yield call(NavigationService.gotoInfo);
    } catch (error) {
      yield put(UserActions.updateUserInfoFailed(error));
      yield put(UserActions.updateUserInfoFailed(null));
    }
  }
}
export function* changePass() {
  while (true) {
    const { payload } = yield take(UPDATE_PASSWORD);
    const user = yield select(getUser);
    let formData = new FormData();
    formData.append('old_password', payload.oldPassword);
    formData.append('new_password', payload.newPassword);
    try {
      const { changePass, timeout } = yield race({
        changePass: call(Api.changePassword, formData, user.user_id),
        timeout: delay(15000),
      });
      if (timeout) {
        yield put(UserActions.updatePasswordFail('Check Internet\nPlease try again later!'));
        yield put(UserActions.updatePasswordFail(null));
        continue;
      }
      const { response, error } = changePass;
      if (error) {
        yield put(UserActions.updatePasswordFail(error));
        yield put(UserActions.updatePasswordFail(null));
       
        continue;
      }
      const { data } = response;
      if (data.status) {
        yield call(NavigationService.gotoLogin);
      } else {
        yield put(UserActions.updatePasswordFail('Please check current password'));
      }

    } catch (error) {
      yield put(UserActions.updatePasswordFail(error));
      yield put(UserActions.updatePasswordFail(null));
     
    }
  }
}
export default function* authFlow() {
  yield all([
    handleUserLogin(),
    verifyUser(),
    updateUsersInfor(),
    changePass(),
  ]);
}
