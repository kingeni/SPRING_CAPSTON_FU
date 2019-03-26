import { combineReducers } from 'redux';
import auth from './auth';
import user from './user';
import vehicle from './vehicle';
import transactions from './transactions';
export const REHYDRATION_COMPLETE = 'REHYDRATION_COMPLETE';
export const NAVIGATION_FINISH = 'NAVIGATION_FINISH';

export default combineReducers({
  auth,
  user,
  vehicle,
  transactions,
});