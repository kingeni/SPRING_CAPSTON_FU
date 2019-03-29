import React from 'react';
import { Provider } from 'react-redux';
import { PersistGate } from 'redux-persist/integration/react';
import NavigationService from './common/NavigationService';
import AppNavigator from './navigation/Router';
import configureStore from './store';
import RootApp from './Rootapp';
const { store, persistor } = configureStore();

export default class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      check: true,
      login: false
    }
  }
  
  render() {
    return (
      <Provider store={store}>
        <PersistGate loading={null} persistor={persistor}>
         <RootApp/>
        </PersistGate>
      </Provider>

    );
  }
}
