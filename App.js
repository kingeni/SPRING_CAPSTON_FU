import React from 'react';
import {
  Alert,
  Platform,
  StatusBar,
  StyleSheet,
  View,
  TextInput,
  Text, Button,
  Linking
} from 'react-native';
import Login from './Components/Login.js';
import Home from './Components/Home';
import CarDetail from './Components/CarDetail';
import App1 from './Config/routes';
import ChangePassword from './Components/ChangePassword';
import Router from './navigation/Router'

export default class App extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      check: true,
      login: false
    }
  }

  handleCheck = (check) => {
    this.setState({check : !check})
  }
  render() {
    return (

    
        <Router/>
        // <ChangePassword/>
    )

  }
}
