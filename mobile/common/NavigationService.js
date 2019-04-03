import { NavigationActions, StackActions } from 'react-navigation';

let navigator = null;
const setTopLevelNavigator = (navigatorRef) => {
  navigator = navigatorRef;
};

const getNavigator = () => navigator;

const isNavigating = () => !!navigator.state.nav.isTransitioning;

// ========== Stack Action ============

const pop = (n = 1) => {
  navigator.dispatch(StackActions.pop({ n }));
};

const replace = (routeName, params) => {
  navigator.dispatch(StackActions.replace({
    routeName,
    params,
  }));
};

const reset = (index, actions) => {
  navigator.dispatch(StackActions.reset({
    index,
    actions,
  }));
};

// ======================

const goBack = (n = 1) => {
  pop(n);
};

const navigate = (routeName, params) => {
  navigator.dispatch(NavigationActions.navigate({
    routeName,
    params,
  }));
};

const push = (routeName, params) => {
  navigator.dispatch(StackActions.push({
    routeName,
    params,
  }));
};

const goToHome = () => {
  navigate('homeScreen');
};

const gotoLogin = () => {
  navigate('Login');
};
const gotoInfo = () => {
  navigate('InforUser');
};

const navigationServices = {
  setTopLevelNavigator,
  isNavigating,
  navigate,
  replace,
  reset,
  pop,
  push,
  goToHome,
  gotoLogin,
  goBack,
  getNavigator,
  gotoInfo,
};
export default navigationServices;