import { LOGOUT } from './auth';

export const GET_LIST_VEHICLE_SUCCESS = 'list/GET_VEHICLE';
export const GET_LIST_FAIL = 'list/GET_VEHICLE_FAIL';

export const initialState = {
    listVehicle: null,
    error: null,
    isLoading: false,
};

//actions 
export const getList = listVehicle => ({
    type: GET_LIST_VEHICLE_SUCCESS,
    payload: {
        listVehicle,
    }
});

export const getListFail = error => ({
    type: GET_LIST_FAIL,
    payload: {
        error,
    }
});

export default function reducer(state = initialState, action) {
    switch (action.type) {
        case GET_LIST_VEHICLE_SUCCESS:
            const { listVehicle } = action.payload;
            return {
                ...state,
                listVehicle,
                error: null,
                isLoading: true,
            }

        case GET_LIST_FAIL:
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

export const actions = {
    getList,
    getListFail,
};

export const getListVehicle = ({ vehicle }) => vehicle.listVehicle;
export const getError = ({ vehicle }) => vehicle.error;
export const getOneDetail = ({ vehicle, transactions }) => vehicle.listVehicle.find((item) => item.id === transactions.vehicle_id ? item : null);
export const isLoading = ({ vehicle }) => vehicle.isLoading;