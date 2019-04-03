import {
    GET_IMAGE_START,
    action as ImagaAction
} from '../reducers/image';
import {
    take, race, put, all, delay, call
} from 'redux-saga/effects';

import Api from '../common/api';
export function* getImageList() {
    while (true) {
        const { payload } = yield take(GET_IMAGE_START);
        try {
            const { imageList, timeout } = yield race({
                imageList: call(Api.getListImage, payload.vehicle_id),
                timeout: delay(15000),
            });

            if (timeout) {
                yield put(ImagaAction.downladListImageFail('Request timeout'));
                continue;
            }

            const { error, response } = imageList;
            if (error) {
                yield put(ImagaAction.downladListImageFail(Api.getNiceErrorMsg(error.response)));
                continue;
            }
            const dataImage = response.data || {};
            // if (dataImage.img0 === undefined) {
            //     yield put(ImagaAction.downladListImageFail('Image is emty'));
            //     continue;
            // }

            yield put(ImagaAction.downloadListImage(dataImage));
        } catch (error) {
            yield put(ImagaAction.downladListImageFail(error));
        }

    }
}

export default function* ImageSaga() {
    yield all([
        getImageList(),
    ]);
}
