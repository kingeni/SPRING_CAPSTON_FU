
import { all, take } from 'redux-saga/effects';
import { REHYDRATION_COMPLETE, NAVIGATION_FINISH } from '../reducers';
import authSagas from './auth';
import vehicleSagas from './vehicle';
import transactionsSaga from './transactions';

export default function* rootSaga() {
  console.log('WAITING FOR REHYDRATION_COMPLETE AND NAVIGATION_FINISH');
  yield all([
    take(REHYDRATION_COMPLETE),
    take(NAVIGATION_FINISH)
  ]);
  console.log('MAH, I\'M READY');

  yield all([
    authSagas(),
    vehicleSagas(), 
    transactionsSaga(),
  ]);
}
