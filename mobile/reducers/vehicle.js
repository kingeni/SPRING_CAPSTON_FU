export const GET_LIST_VEHICLE_SUCCESS = 'list/GET_VEHICLE';
export const GET_LIST_FAIL = 'list/GET_VEHICLE_FAIL';
export const initialState = {
    listVehicle: null,
    error: null
};

//actions 
const getList = listVehicle => ({
    type: GET_LIST_VEHICLE_SUCCESS,
    payload: {
        listVehicle,
    }
});

const getListFail = error =>({
    type: GET_LIST_FAIL,
    payload: {
        error,
    }
});

export default function reducer(state = initialState, action){
    switch(action.type){
        case GET_LIST_VEHICLE_SUCCESS: 
            const {listVehicle}  = action.payload;
            return {
                ...state,
                listVehicle,
                error: null
            }
        case GET_LIST_FAIL:
            const {error} = action.payload;
            return{
                ...state,
                error
            }
        default : return state;
    }
}

export const actions = {
    getList,
    getListFail,
  };