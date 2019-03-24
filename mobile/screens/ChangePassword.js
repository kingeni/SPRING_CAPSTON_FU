import React, { Component } from 'react';
import {
    View,
    ScrollView,
    Button,
    Text,
    TextInput
} from 'react-native';
import FormData from 'FormData';
class ChangePassword extends Component {
    static navigationOptions = {
        title: 'Change Password',
        headerBackTitle: null
    }

    constructor(props) {
        super();
        this.state = {
            password: '',
            newPassword: ''
        }
    }
    
    handleChange = (props, params) => {
        this.setState({ [props]: params });
    }

    // checkValidation = (props, paramsCheck) => {
    //     if (props === 'password') {

    //         if (this.state[props] === '') return alert('Cannot emty password');
    //         if (this.state[props] !== paramsCheck) return alert('Re-password not same');

    //     }
    // }

    handleSave = () => {
        const { password, newPassword } = this.state;
        const { user_id } = this.props.navigation.state.params;
        let formData = new FormData();
        formData.append('old_password', password);
        formData.append('new_password', newPassword);
        console.log(formData);

        fetch('http://vwms.gourl.pro/api/user/update-password?userId=' + user_id, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: formData
        })
            .then((response) => response.json())
            .then((responseJSON) => {
                // console.log('status', responseJSON);
                   return this.props.navigation.navigate('Login');
            }).catch((error) => {
                console.log(error);
            })
    }
    render() {
        const { password } = this.props.navigation.state.params;
        return (
            <ScrollView contentContainerStyle={{ flex: 1, backgroundColor: '#d6d7da', alignItems: 'stretch' }}>
                <View>
                    <View style={{ height: 50, marginTop: 10, backgroundColor: 'white', justifyContent: 'center', alignItems: 'center', flexDirection: 'row' }}>
                        <View>
                            <TextInput
                                placeholder='Enter current password'
                                onChangeText={value => this.handleChange('password', value)}
                                // onBlur={() => this.checkValidation('password', password)}
                                secureTextEntry={true}>
                            </TextInput>
                        </View>
                    </View>
                    <View style={{ height: 50, marginTop: 10, backgroundColor: 'white', justifyContent: 'center', alignItems: 'center', flexDirection: 'row' }}>

                        <TextInput
                            placeholder='Enter new password'
                            onChangeText={value => this.handleChange('newPassword', value)}
                            secureTextEntry={true}>
                        </TextInput>

                    </View>
                    <View style={{ height: 50, marginTop: 10, backgroundColor: 'white', justifyContent: 'center', alignItems: 'center', flexDirection: 'row' }}>

                        <TextInput
                            placeholder='Re-enter new password'
                            secureTextEntry={true}>
                        </TextInput>

                    </View>
                    <View style={{
                        borderRadius: 15,
                        padding: 10,
                        backgroundColor: '#0068ff',
                        marginTop: 20
                    }}>
                        <Button title='save' color='white' onPress={() => this.handleSave()}></Button>
                    </View>
                </View>
            </ScrollView>
        );
    }
}
export default ChangePassword;