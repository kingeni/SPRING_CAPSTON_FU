import {
    call, put, take, delay, all, select, race, takeLatest
} from 'redux-saga/effects';
import {
    TRANSACTION_START,
    TRANSACTION_START_ERROR,
    TRANSACTION_UPDATE_READ,
    getStatus,
    getStatusErr,
    actions as TransActions,
    getVehicleID,
} from '../reducers/transactions';
import Api from '../common/api'

export function* getTransactions() {
    while (true) {
        const status = yield select(getStatus);
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
        yield delay(3000);
    }
}
export function* updateStatusRead() {
    while (true) {
        const { payload } = yield take(TRANSACTION_UPDATE_READ);

        // console.log('aaa', payload.vehicle_id);
        try {
            const { updateStatus, timeout } = yield race({
                updateStatus: call(Api.updateStatusReading, payload.vehicle_id),
                timeout: delay(15000),
            });
            if (timeout) {
                yield put(TransActions.getTransactionFail('Time Out server\n Restart app'));
                continue;
            }
            const { error } = updateStatus;
            if (error) {
                yield put(TransActions.getTransactionFail(error));
                console.log('Error2 : ', error);
                continue;
            }

        } catch (error) {
            yield put(TransActions.getTransactionFail(error));
            console.log('Error1 : ', error);
        }

    }
}

export function* watchTrans() {
    yield takeLatest(TRANSACTION_START, getTransactions);
    yield takeLatest(TRANSACTION_START_ERROR, getErrTransactions);
}

export default function* getTransacstion() {
    yield all([
        watchTrans(),
        updateStatusRead(),
    ]);
}