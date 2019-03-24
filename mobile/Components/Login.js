import React, { Component } from 'react';
import {
  Alert,
  StyleSheet,
  View,
  TextInput,
  Text,
  Button,
  Linking
} from 'react-native';
import { Feather } from '@expo/vector-icons';
import { CheckBox, FormValidationMessage } from 'react-native-elements';
import PopupDiaLog from '../Components/PopupDialog';
import FormData from 'FormData';
class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      username: '',
      password: '',
      popUpStatus: false
    };
  }
  handleChange = (props, value) => {
    this.setState({ [props]: value })
  }
  login = () => {
    const { username, password } = this.state;
    const { login } = this.props;
    login(username, password);
  }

  onChangeStatus = () => {
    this.setState({
      popUpStatus: false
    });
  }
  render() {
    const { popUpStatus } = this.state;
    return (
      <View style={styles.container}>
        <View style={styles.container1}>
          <View style={styles.text}>
            <Text style={styles.text}> VEHICLE MONITORING</Text>
          </View>

          <View style={{ borderWidth: 0.5, borderRadius: 7, borderColor: '#d6d7da' }}>
            <View style={{ ...styles.view_input, ...styles.border_content }}>
              <View style={{ justifyContent: 'center', flex: 10, paddingLeft: 5 }}>
                <Feather name="user" size={30} color="gray" />
              </View>

              <TextInput style={{ ...styles.input, ...styles.padding_font }}
                placeholder='Username'
                onChangeText={value => this.handleChange('username', value)}
              >
              </TextInput>
            </View>
            <View style={{ ...styles.view_input }}>
              <View style={{ justifyContent: 'center', flex: 10, paddingLeft: 5 }}>
                <Feather name="lock" size={30} color="gray" />
              </View>
              <TextInput style={{ ...styles.input, ...styles.padding_font }}
                placeholder='Password'
                onChangeText={value => this.handleChange('password', value)}
                secureTextEntry={true}>
              </TextInput>
            </View>
          </View>

          <View style={styles.btn}>
            <Button onPress={() => this.login()}
              title='Login' color='white'></Button>
          </View>
          <View>
            <CheckBox
              containerStyle={{
                backgroundColor: 'white',
                borderWidth: 0,
              }}
              textStyle={{ color: 'black' }}
              title='Remember account'
              center
              iconRight
              checked={this.props.checkValue}
            />
          </View>
        </View>
        {popUpStatus ? <PopupDiaLog msgErr={'cannot Login'} visible={popUpStatus} onChangeStatus={this.onChangeStatus} /> : null}
        <View style={styles.container2}>
          <Text style={styles.fooder}>Forgot the password? </Text>
          <Text style={styles.text_fooder}
            onPress={() => Linking.openURL('http://google.com')}>
            Get password
              </Text>
        </View>
      </View>
    );
  }
}
const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    justifyContent: 'center',
    alignItems: 'stretch',
    marginTop: 20,
    marginLeft: 35,
    marginRight: 35,
    marginBottom: 20
  },
  container1: {
    flex: 90,
    justifyContent: 'center',

  },
  container2: {
    flex: 10,
    flexDirection: 'row',
    justifyContent: 'center'
  },
  textLogin: {
    height: 50,
    borderRadius: 4,
    borderWidth: 0.5,
    borderColor: '#d6d7da',
  },
  searchIcon: {
    padding: 10,
  },
  text: {
    textAlign: 'center',
    fontWeight: 'bold',
    fontSize: 25,
    padding: 5,
    marginBottom: 10
  },
  border_content: {
    borderBottomWidth: 0.5,
    borderColor: '#d6d7da'
  },
  input: {
    height: 65,
    fontSize: 20,
    flex: 90
  },
  view_input: {
    flexDirection: 'row',
  },
  padding_font: {
    paddingLeft: 5
  },
  btn: {
    borderRadius: 15,
    padding: 10,
    backgroundColor: '#0068ff',
    marginTop: 20
  },
  fooder: {
    textAlign: 'center'
  },
  text_fooder: {
    color: 'blue',
    fontStyle: 'italic',
    textAlign: 'center'
  }
});

export default Login;