
import { all, take } from 'redux-saga/effects';
import { REHYDRATION_COMPLETE } from '../reducers';
import authSagas from './auth';

export default function* rootSaga() {
  yield take(REHYDRATION_COMPLETE);
  yield all([
    authSagas(),
  ]);
}