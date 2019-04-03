import { LOGOUT } from './auth';

export const TRANSACTION_START = 'transaction/START';
export const TRANSACTION_START_ERROR = 'transaction/START_ERROR';
export const TRANSACTION_STOP = 'transaction/STOP';
export const TRANSACTION_SUCCESS = 'transaction/SUCCESS';
export const TRANSACTION_FAIL = 'transaction/FAIL';
export const TRANSACTION_SUCCESS_ERROR = 'transaction/VIOLATE';
export const TRANSACTION_UPDATE_READ = 'transaction/UPDATE_READING';

export const initialState = {
    vehicle_id: null,
    transactions: {},
    error: null,
    status: false,
    transactionsErr: {},
    statusErr: false,
    isLoading: false,
}

//action
const startTransaction = (vehicle_id,isLoading) => ({
    type: TRANSACTION_START,
    payload: {
        vehicle_id,
        status: true,
        isLoading,
    }
});

const startTransactionErr = vehicle_id => ({
    type: TRANSACTION_START_ERROR,
    payload: {
        vehicle_id,
        statusErr: true,
    }
});

const stopTransaction = () => ({
    type: TRANSACTION_STOP,
    payload: {
        status: false,
        statusErr: false,
    }
});

const getTransactionSuccess = transactions => ({
    type: TRANSACTION_SUCCESS,
    payload: {
        transactions,
    }
});

const getTransactionFail = error => ({
    type: TRANSACTION_FAIL,
    payload: {
        error,
    }
});

const getTransactionSuccessErr = transactionsErr => ({
    type: TRANSACTION_SUCCESS_ERROR,
    payload: {
        transactionsErr
    }
});

const updateStatusReading = vehicle_id => ({
    type: TRANSACTION_UPDATE_READ,
    payload: {
        vehicle_id
    }
});



export default function Reducer(state = initialState, action) {
    switch (action.type) {
        case TRANSACTION_START: {
            const { vehicle_id, status,isLoading } = action.payload;
            return {
                ...state,
                vehicle_id,
                status,
                error: null,
                statusErr: false,
                isLoading,
            };
        }
        case TRANSACTION_START_ERROR: {
            const { vehicle_id, statusErr} = action.payload;
            return {
                ...state,
                vehicle_id,
                statusErr,
                status: false,
            };
        }
        case TRANSACTION_SUCCESS_ERROR: {
            const { transactionsErr } = action.payload;

            return {
                ...state,
                transactionsErr,
                isLoading: true,
            };
        }
        case TRANSACTION_SUCCESS: {
            const { transactions } = action.payload;
           
            return {
                ...state,
                transactions,
                isLoading: true,
            };
        }
        case TRANSACTION_FAIL:
            const { error } = action.payload;
            return {
                ...state,
                error,
            };
        case TRANSACTION_STOP: {
            const { status, statusErr } = action.payload;
            return {
                ...state,
                status,
                statusErr,
                isLoading: false,
            };
        }
        case TRANSACTION_UPDATE_READ: {
            const { vehicle_id } = action.payload;
            return {
                ...state,
                vehicle_id,
            }
        }
        
        default: return state;
    }
}

export const actions = {
    startTransaction,
    stopTransaction,
    getTransactionSuccess,
    getTransactionFail,
    startTransactionErr,
    getTransactionSuccessErr,
    updateStatusReading,
}

export const getError = ({ transactions }) => transactions.error;
export const getTransactions = ({ transactions }) => transactions.transactions;
export const getTransactionErr = ({ transactions }) => transactions.transactionsErr;
export const getStatus = ({ transactions }) => transactions.status;
export const getVehicleID = ({ transactions }) => transactions.vehicle_id;
export const getStatusErr = ({ transactions }) => transactions.statusErr;
export const isLoading = ({ transactions }) => transactions.isLoading;

