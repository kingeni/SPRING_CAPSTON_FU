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
    while (true) {
        // hiện tại đang lấy hoài luôn. Muốn nso chờ thì dùng hàm delay
        try {
            // lấy access_token, nếu có = user đang login
            // dùng yield select để lấy thông tin từ state
            // dùng như mapstateToprops
            // mà được cái không cần phải truyền state
            // nó tự truyền luôn
            const token = yield select(getToken); // đây <<<<

            // user logout ko chơi nữa
            if (!token) return;
            const { user_id } = (yield select(selectUser))// giờ phải lấy cái id của user bỏ vào đây // cai nayf chon casi nao
            // race là để chạy 2 task, task nào xong trước hủy task kia
            const { getVehicleList, timeout } = yield race({
                getVehicleList: call(Api.getVehicleList, user_id), //qua api di 
                timeout: delay(15000), //15s timeout, server ko trả về trong 15s -> tạch lấy xong nó tự push lên ak
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
            console.log('dataAPI: ', data.length);
            yield put(getList(data.map(({img,...rest})=> rest)));

        } catch (error) {
            console.log('222:',error.message || error)
        }

        yield delay(4000);
    }
}

export function* watchLogin() {
    // chờ khi nào login success mới bắt đầu
    // takeLatest = nh khi 1 action dispatch nh lần, chỉ lấy cái cuối cùng
    yield takeLatest(LOGIN_SUCCESS, getListVehicle);
}

export default function* vehicleSaga() {
    // chỗ này để khởi động toàn bộ saga cùng lúc
    // Vì cái getListVehicle đc gọi bở watchLogin rồi nên khỏi cần nhét vào đây
    yield all([
        watchLogin(),
    ])
}
