import {
    call, put, take, delay, all, select, race, takeLatest
} from 'redux-saga/effects';
import {
    TRANSACTION_START,
    TRANSACTION_START_ERROR,
    getStatus,
    getStatusErr,
    actions as TransActions,
    getVehicleID,
} from '../reducers/transactions';
import Api from '../common/api';

export function* getTransactions() {
    while (true) {
        const status = yield select(getStatus);
        console.log('get:',status);
        if (!status) return;
        const vehicle_id = yield select(getVehicleID);
        try {
                const { transactions, timeout } = yield race({
                    transactions: call(Api.getAllTransactions, vehicle_id),
                    timeout: delay(15000),
                });
                if (timeout) {
                    yield put(TransActions.getTransactionFail('Unable to get transactions.\nPlease try again later!'));
                    continue;
                }

                const { error, response } = transactions;
                if (error) {
                    console.log('Error : ', error);
                    continue;
                }
                const { data } = response;
                yield put(TransActions.getTransactionSuccess(data));

        } catch (error) {
            console.log('Error1 : ', error);
        }
        yield delay(5000);
    }
}
export function* getErrTransactions() {
    while (true) {
        const status = yield select(getStatusErr);
        console.log('getError:',status);
        if (!status) return;
        const vehicle_id = yield select(getVehicleID);

        try {

                const { transactions, timeout } = yield race({
                    transactions: call(Api.getErrTransactions, vehicle_id),
                    timeout: delay(15000),
                });
                if (timeout) {
                    yield put(TransActions.getTransactionFail('Unable to get transactions.\nPlease try again later!'));
                    continue;
                }

                const { error, response } = transactions;
                if (error) {
                    console.log('Error : ', error);
                    continue;
                }
                const { data } = response;
                
                yield put(TransActions.getTransactionSuccessErr(data));
           

        } catch (error) {
            console.log('Error1: ', error);
        }
        yield delay(5000);
    }
}

export function* watchTrans() {
    yield takeLatest(TRANSACTION_START, getTransactions);
    yield takeLatest(TRANSACTION_START_ERROR, getErrTransactions);
}

export default function* getTransacstion() {
    yield all([
        watchTrans(),
    ]);
}