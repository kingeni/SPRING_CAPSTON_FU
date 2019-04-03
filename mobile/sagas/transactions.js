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
            console.log('1111');
            if (timeout) {
                yield put(TransActions.getTransactionFail('Unable to get transactions.\nPlease try again later!'));
                continue;
            }

            const { error, response } = transactions;
            if (error) {
                yield put(TransActions.getTransactionFail(error.response));
                continue;
            }
            const { data } = response;
            const dataConvert = convertData(data);
      
            yield put(TransActions.getTransactionSuccess(dataConvert));

        } catch (error) {
            yield put(TransActions.getTransactionFail(error));
        }
        yield delay(5000);
    }
}

let convertData = (data) => {
    var handle = [];
    for (var i = 0; i < data.length; i++) {
        var item = data[i];

        var createDate = item.created_at;
        var title = createDate.split(' ')[0];
        var time = createDate.split(' ')[1];
        var newData = {
            time: time,
            station_id: item.station_id,
            vehicle_weight: item.vehicle_weight,
            status: item.status
        };
        var subData = findData(title, handle);
        if (subData != null) {
            subData.data.push(newData);
        } else {
            newItem = {
                title: title,
                data: [newData]
            };
            handle.push(newItem);
        };
    }
    return handle;
}

let findData = (title, handle) => {
    for (var i = 0; i < handle.length; i++) {
        item = handle[i];
        if (item.title.toLowerCase().localeCompare(title.toLowerCase()) == 0) {
            return item;
        }
    }
    return null;
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
                yield put(TransActions.getTransactionFail(error.response));
                continue;
            }
            const { data } = response;
            const dataConvert = convertData(data);
      
            yield put(TransActions.getTransactionSuccessErr(dataConvert));

        } catch (error) {
            yield put(TransActions.getTransactionFail(error));
        }
        yield delay(3000);
    }
}
export function* updateStatusRead() {
    while (true) {
        const { payload } = yield take(TRANSACTION_UPDATE_READ);
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
                yield put(TransActions.getTransactionFail(error.response));
                continue;
            }

        } catch (error) {
            yield put(TransActions.getTransactionFail(error));

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