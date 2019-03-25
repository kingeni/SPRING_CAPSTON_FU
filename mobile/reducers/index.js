import { combineReducers } from 'redux';
import auth from './auth';
import user from './user';
import vehicle from './vehicle';
export const REHYDRATION_COMPLETE = 'REHYDRATION_COMPLETE';
export const SET_TOP_NAVIGATION_COMPLETE = 'SET_TOP_NAVIGATION_COMPLETE';

export default combineReducers({
  auth,
  user,
  vehicle,
});