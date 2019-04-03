import moment from 'moment';

export const LOGIN_START = 'auth/LOGIN_START';
export const LOGIN_SUCCESS = 'auth/LOGIN_SUCCESS';
export const LOGIN_FAILED = 'auth/LOGIN_FAILED';
export const LOGOUT = 'auth/LOGOUT';
export const initialState = {
  username: null,
  token: null,
  authenticated: null,
  timestamp: null,
  isLoading: null,
  error: null,
};

// action creators
const login = (username, password) => ({
  type: LOGIN_START,
  payload: {
    username,
    password,
  },
});

const loginFailed = error => ({
  type: LOGIN_FAILED,
  payload: {
    error,
  },
});

const loginSuccess = token => ({
  type: LOGIN_SUCCESS,
  payload: {
    timestamp: moment().utc().format(),
    token,
  },
});

// ============ misc
const logout = () => ({
  type: LOGOUT,
});

export default function reducer(state = initialState, action) {

  switch (action.type) {
    case LOGIN_START: {
      const { username } = action.payload;
      console.log('state:', username);
      return {
        ...state,
        username,
        isLoading: true,
        authenticated: false,
        error: null,
      };
    }
    case LOGIN_FAILED: {
      const { error } = action.payload;
      return {
        ...state,
        isLoading: false,
        authenticated: false,
        error,
        username: null,
      };
    }
    case LOGIN_SUCCESS: {
      const { token, timestamp } = action.payload;
      return {
        ...state,
        token,
        timestamp,
        isLoading: false,
        authenticated: true,
        error: null,
      };
    }
    case LOGOUT: {
      return initialState;
    }
    default: return state;
  }
}

export const actions = {
  login,
  loginFailed,
  loginSuccess,
  logout,
};

// Selectors
export const getUsername = state => state.auth.username;
export const getToken = state => state.auth.token;
export const getAuth = ({ auth }) => auth.authenticated;
export const getAuthError = ({ auth }) => auth.error;
export const getAuthStatus = ({ auth }) => auth.isLoading;
