import { LOGOUT } from './auth';

export const GET_LIST_VEHICLE_SUCCESS = 'list/GET_VEHICLE';
export const GET_LIST_FAIL = 'list/GET_VEHICLE_FAIL';
export const UPDATE_NEWST = 'list/UPDATE_NEWST';

export const initialState = {
    listVehicle: null,
    error: null,
    isLoading: false,
    newDate: '2019-02-01 12:02:11',
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

export const updateDate = newDate => ({
    type: UPDATE_NEWST,
    payload: {
        newDate
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
        case UPDATE_NEWST:
            const { newDate } = action.payload;
            return {
                ...state,
                newDate,
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
export const getNew = ({ vehicle }) =>vehicle.newDate;