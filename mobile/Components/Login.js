import React, { Component } from 'react';
import {
  Alert,
  StyleSheet,
  View,
  TextInput,
  Text,
  Linking,
  TouchableHighlight,
} from 'react-native';
import { Feather } from '@expo/vector-icons';
import { CheckBox, FormValidationMessage , Button} from 'react-native-elements';

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      username: '',
      password: '',
    };
  }

  handleChange = (props, value) => {
    this.setState({ [props]: value })
  }

  login = () => {
    const { username, password } = this.state;
    const { login, errorMsg } = this.props;
    login(username, password);
    if (errorMsg) {
      alert(errorMsg);
    }
  }

  render() {
    return (
      <View style={styles.container}>
        <View style={{ height: '50%', width: '100%', alignItems: 'center', justifyContent: 'flex-start' }}>
          <View style={styles.text}>
            <Text style={styles.text}> VEHICLE MONITORING</Text>
          </View>

          <View style={{ width: '80%' }}>
            <View style={{ ...styles.view_input, marginBottom: 10 }}>
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

          <TouchableHighlight onPress={() => this.login()} style={{ width: '80%', marginTop: 20, borderRadius: 15, }}>
            <View style={styles.btn}>
              <Text style={{
                fontSize: 20,
                fontWeight: 'bold',
                color: 'white', 
                textAlign:'center',
                paddingVertical: 10,
              }}>LOGIN</Text>
            </View>
          </TouchableHighlight>
       
          {/* <View>
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
          </View> */}
        </View>

        {/* <View style={styles.container2}>
          <Text style={styles.fooder}>Forgot the password? </Text>
          <Text style={styles.text_fooder}
            onPress={() => Linking.openURL('http://google.com')}>
            Get password
              </Text>
        </View> */}
      </View>
    );
  }
}
const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: 'rgb(66,73,79)',
    justifyContent: 'center',
    alignItems: 'center',
  },
  container1: {
    flex: 90,
    justifyContent: 'center',
    borderWidth: 1,
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
    marginBottom: 10,
    color: 'white'
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
    borderRadius: 7,
    backgroundColor: 'white',

  },
  padding_font: {
    paddingLeft: 5
  },
  btn: {
    borderRadius: 15,
    padding: 10,
    backgroundColor: 'rgb(243,177,127)',
    width: '100%',
    // fontSize: 15,
    // fontWeight: 'bold',
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