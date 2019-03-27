import { GET_IMAGE_START, action as ImagaAction } from '../reducers/image';
import {
    take, race, put, all, delay, call
} from 'redux-saga/effects';
import Api from '../common/api';
export function* getImageList() {
    while (true) {
        const { payload } = yield take(GET_IMAGE_START);

        console.log('aaa', payload.vehicle_id);
        try {
            const { imageList, timeout } = yield race({
                imageList: call(Api.getListImage, payload.vehicle_id),
                timeout: delay(15000),
            });

            if (timeout) {
                // yield put(TransActions.getTransactionFail('Time Out server\n Restart app'));
                continue;
            }

            const { error, response } = imageList;
            if (error) {
                // yield put(TransActions.getTransactionFail(error));
                console.log('Error2 : ', error);
                continue;
            }
            const dataImage = response.data || {};
            yield put(ImagaAction.downloadListImage(dataImage));
        } catch (error) {
            // yield put(TransActions.getTransactionFail(error));
            console.log('Error1 : ', error);
        }

    }
}

export default function* ImageSaga() {
    yield all([
        getImageList(),
    ]);
}
