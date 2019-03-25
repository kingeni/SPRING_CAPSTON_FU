
import { all, take } from 'redux-saga/effects';
import { REHYDRATION_COMPLETE } from '../reducers';
import authSagas from './auth';
import vehicleSagas from './vehicle';

export default function* rootSaga() {
  yield take(REHYDRATION_COMPLETE);
  yield all([
    authSagas(),
    vehicleSagas(), // làm xong nhớ đăng ký vào đây để saga middleware chạy
  ]);
}