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
    selectUser
} from '../reducers/user';
import {
    getList
} from '../reducers/vehicle';

export function* getListVehicle() {
    let timeDelay = 1000;
    while (true) {
        try {
            const token = yield select(getToken);

            if (!token) return;
            const { user_id } = (yield select(selectUser));
            const { getVehicleList, timeout } = yield race({
                getVehicleList: call(Api.getVehicleList, user_id), 
                timeout: delay(15000), 
            });

            if (timeout) {
                console.log('Server chết mẹ rồi');
                continue;
            }

            const { error, response } = getVehicleList;
            if (error) {
                console.log('111:',error);
                continue;
            }

            const { data } = response;
            data.length > 0 ? timeDelay = 4000 : timeDelay = 1000;
            // yield put(getList(data.map(({img,...rest})=> rest)));
            yield put(getList(data));

        } catch (error) {
            console.log('222:',error.message || error)
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
