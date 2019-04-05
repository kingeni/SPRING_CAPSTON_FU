import { LOGOUT } from './auth';

export const GET_IMAGE_START = 'image/IMAGE_START';
export const GET_LIST_IMAGE = 'image/GET_IMAGE';
export const GET_LIST_IMAGE_FAIL = 'image/GET_FAIL';
const initialState = {
    vehicle_id: null,
    imageVehicle: null,
    isLoading: false,
    error: null,
}
const startListImage = vehicle_id => ({
    type: GET_IMAGE_START,
    payload: {
        vehicle_id,
    }
});
const downloadListImage = imageVehicle => ({
    type: GET_LIST_IMAGE,
    payload: {
        imageVehicle,
    }
});
const downladListImageFail = error => ({
    type: GET_LIST_IMAGE_FAIL,
    payload: {
        error
    }
});

export default function Reducer(state = initialState, action) {
    switch (action.type) {
        case GET_LIST_IMAGE: {
            const { imageVehicle } = action.payload;
            return {
                ...state,
                imageVehicle,
                isLoading: true,
            }
        }

        case GET_IMAGE_START:
            const { vehicle_id } = action.payload;
            return {
                ...state,
                vehicle_id,
                isLoading: false,
            }

        case GET_LIST_IMAGE_FAIL:
            const { error } = action.payload;
            return {
                ...state,
                error,
            }

        case LOGOUT: {
            return initialState;

        }
        default: return state;
    }
}

export const action = {
    startListImage,
    downloadListImage,
    downladListImageFail,
};

export const getListImage = ({ image }) => image.imageVehicle;
export const getImgStatus = ({ image }) => image.isLoading;
export const getListImageError = ({image})=> image.error;