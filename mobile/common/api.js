
import axios from 'axios';

const apiUrl = 'http://vwms.gourl.pro/api';
const LOGIN_PATH = '/site/login';
const LIST_VEHICLE = '/vehicle/get-vehicles';
const LIST_TRANSACTION ='/transaction/get-transactions';
const LIST_TRANSACTION_ERROR = '/transaction/get-v-transactions';

const setDefaults = (defaults) => {
  Object.keys(defaults).forEach((key) => {
    axios.defaults[key] = defaults[key];
  });
};

const setToken = (token) => {
  const { headers } = axios.defaults;
  axios.defaults.headers = {
    ...headers,
    Authorization: `Token ${token}`,
  };
};

/* eslint-disable camelcase */

const getNiceErrorMsg = (response) => {
  const { status, data } = response || {};

  if (!status) return 'Unknown error occurred!';

  if (status >= 500) {
    return 'Server is unreachable';
  }

  if (status === 401) return 'Unauthorized';
  if (status >= 400) {
    if (data.message) return data.message;
    if (!data.token) return 'Wrong password';
  }
  return 'Unknown error';
};

const login = async (formData, optionalConfig = {}) => {
  try {
    const response = await axios({
      ...optionalConfig,
      method: 'POST',
      baseURL: apiUrl,
      url: LOGIN_PATH,
      headers: {
        ...(axios.defaults.headers || {}),
        'Content-Type': 'application/json',
      },
      data: formData,
    });

    return { response };
  } catch (error) {
    return { error };
  }
};

const getVehicleList = async (user_id, optionalConfig = {}) => {
  try {
    const response = await axios({
      ...optionalConfig,
      method: 'GET',
      baseURL: apiUrl,
      url: `${LIST_VEHICLE}?userId=${user_id}`,
      headers: {
        ...(axios.defaults.headers || {}),
        'Content-Type': 'application/json',
      },
    });
    return { response };
  } catch (error) {
    return { error };
  }
}
const getAllTransactions = async (vehicle_id, optionalConfig= {})=>{
  try{
  
    const response = await axios({
      ...optionalConfig,
      method : 'GET',
      baseURL: apiUrl,
      url : `${LIST_TRANSACTION}?vehicleId=${vehicle_id}`,
      header : {
        ...(axios.defaults.headers|| {}),
        'Content-type': 'application/json'
      },
    });
    return {response};
  }catch(error){
    return {error};
  }
}
const getErrTransactions= async (vehicle_id, optionalConfig= {})=>{
  try{
    const response = await axios({
      ...optionalConfig,
      method:'GET',
      baseURL: apiUrl,
      url: `${LIST_TRANSACTION_ERROR}?vehicleId=${vehicle_id}`,
      header: {
        ...(axios.defaults.headers|| {}),
        'Content-type': 'application/json'
      },
    });
    return {response};
  }catch(error){
    return {error};
  }
}
const Api = {
  setDefaults,
  setToken,
  getNiceErrorMsg,
  login,
  getVehicleList,
  getAllTransactions,
  getErrTransactions,
};

export default Api;