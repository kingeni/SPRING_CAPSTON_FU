
import axios from 'axios';

const apiUrl = 'http://vwms.gourl.pro/api';
const LOGIN_PATH = '/site/login';
const LIST_VEHICLE = '/vehicle/get-vehicles';

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

const getConfig = (optionalConfig = {}) => (
  axios({
    ...optionalConfig,
    method: 'get',
    baseURL: getApiUrlBase(),
    url: API_CONFIG_PATH,
  }).then(response => ({ response }))
    .catch(error => ({ error }))
);

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
    // const request = await axios.post(`${apiUrl}${LOGIN_PATH}`, formData);
    // const response = await axios({
    //   ...optionalConfig,
    //   method: 'POST',
    //   baseURL: apiUrl,
    //   url: LOGIN_PATH,
    //   headers: {
    //     ...(axios.defaults.headers || {}),
    //     'Content-Type': 'application/json',
    //   },
    //   data: formData,
    // });
    const res = await fetch(apiUrl + LOGIN_PATH, {
      method: 'POST',
      headers: {
        Accept: 'application/json,',
        'Content-Type': 'application/json',
      },
      body: formData
    });
    let response = await res.json();
      
    return  response.pop() ;
  } catch (error) {
      return {error};
  }
};

const listVehicel = async (formData, optionalConfig= {}) =>{
  try{
    const res = await fetch(apiUrl+LIST_VEHICLE,{
      method: 'GET',
      headers: {
        Accept: 'application/json,',
        'Content-Type': 'application/json',
      },
      body: formData
    });
    let response = await res.json();
    return {response};
  }catch(error){
    return {error};
  }
}

const Api = {
  setDefaults,
  setToken,
  getConfig,
  getNiceErrorMsg,
  login,
  listVehicel,
};

export default Api;