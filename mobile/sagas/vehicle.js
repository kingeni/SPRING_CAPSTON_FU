import {
    call, put, select, all, take, race, delay,
    takeLatest,
} from 'redux-saga/effects';
import Api from '../common/api';
import {
    LOGIN_SUCCESS,
    getToken,
} from '../reducers/auth';
import {
    getUser
} from '../reducers/user';
import {
    getList,
    getListFail,
    updateDate,
    getNew,
} from '../reducers/vehicle';
import moment from 'moment';
// const convertData = (listVehicle, newestTran) => {
//     if (listVehicle.length === 0) return {
//         listVehicle,
//         newestTran,
//     };
//     var temp = newestTran;
//     var position = 0;
//     for (let i = 0; i < listVehicle.length; i++) {
//         if (listVehicle[i].newest_transaction.is_read === 0) {
//             const time = moment(listVehicle[i].newest_transaction.created_at, 'YYYY-MM-DD HH:mm:ss');
//             const time1 = moment(temp, 'YYYY-MM-DD HH:mm:ss');

//             if (time > time1) {
//                 temp = listVehicle[i].newest_transaction.created_at;
//                 position = i;
//             }
//         }
//     }

//     if (position != 0) {
//         listVehicle.splice(0, 0, ...listVehicle.splice(position, 1));

//     }

//     return {
//         listVehicle,
//         newestTran: temp,
//     };
// }
export function* getListVehicle() {
    let timeDelay = 1000;
    while (true) {
        try {
            const token = yield select(getToken);
            const newestTrans = yield select(getNew);

            if (!token) return;
            const { user_id } = (yield select(getUser));
            const { getVehicleList, timeout } = yield race({
                getVehicleList: call(Api.getVehicleList, user_id),
                timeout: delay(15000),
            });

            if (timeout) {
                yield put(getListFail('Request Timeout'));
                // yield put(getListFail(null));
                continue;
            }

            const { error, response } = getVehicleList;
            if (error) {
                yield put(getListFail(Api.getNiceErrorMsg(error.response)));
                // yield put(getListFail(null));
                continue;
            }

            const { data } = response || [];
            data.length > 0 ? timeDelay = 4000 : timeDelay = 1000;
            // console.log(data.map(({img,...rest})=> rest));
            // yield put(getList(data.map(({img,...rest})=> rest)));
            // const { listVehicle, newestTran } = convertData(data, newestTrans);
        //     if (moment(newestTrans, 'YYYY-MM-DD HH:mm:ss') < moment(newestTran, 'YYYY-MM-DD HH:mm:ss')) {
                yield put(getList(data));
                // yield put(updateDate(newestTran));
            // }

        } catch (error) {
            // yield put(getListFail(error));
            console.log(error);
            // yield put(getListFail(null));
            continue;
        }

        yield delay(timeDelay);
    }
}

export function* watchLogin() {
    yield takeLatest(LOGIN_SUCCESS, getListVehicle);
}

export default function* vehicleSaga() {
    yield all([
        watchLogin(),
    ])
}
