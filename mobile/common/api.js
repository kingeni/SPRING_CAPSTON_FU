
import axios from 'axios';


const apiUrl = 'http://vwms.gourl.pro';
const LOGIN_PATH = '/api/site/login';
const REGISTER_PATH = '/api/auth/register';
const STAGE_PATH = '/api/stage';
const LEVEL_PATH = '/api/level';
const USER_PATH = '/api/user';
const SUBMISSION_PATH = '/api/submit';

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
  console.log('2');
  try {
    // const request = await axios.post(`${apiUrl}${LOGIN_PATH}`, formData);
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
    console.log('3', response);
    return { response };
  } catch (error) {
    return { error };
  }
};

const register = async (formData, optionalConfig = {}) => {
  try {
    const response = await axios({
      ...optionalConfig,
      method: 'POST',
      baseURL: apiUrl,
      url: REGISTER_PATH,
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

const Api = {
  setDefaults,
  setToken,
  getConfig,
  getNiceErrorMsg,
  login,
  register,
};

export default Api;