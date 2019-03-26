import AppNavigator from './navigation/Router';
import React from 'react';
import NavigationService from './common/NavigationService';
import {connect } from 'react-redux';
import {NAVIGATION_FINISH} from './reducers';
const RootApp = ({dispatch}) => (
    <AppNavigator
        ref={(navigatorRef) => {
            NavigationService.setTopLevelNavigator(navigatorRef);
            dispatch({
                type: NAVIGATION_FINISH,
            });
            console.log('NAVIGATION IS READY!');
        }}
    />
    
);
export default connect() (RootApp);