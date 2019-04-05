import React, { Component } from 'react';
import {
    View,
    ScrollView,
    Button,
    Text,
    TextInput,
    TouchableOpacity,
    StyleSheet,
    ActivityIndicator
} from 'react-native';
import FormData from 'FormData';
import { Ionicons } from '@expo/vector-icons';
class ChangePassword extends Component {
    static navigationOptions = ({ navigation }) => {
        return {
            title: 'Change Password',
            headerLeft:
                (<Ionicons name='ios-arrow-back'
                    size={30} color='rgb(243,177,127)'
                    style={{ paddingLeft: 10 }}
                    onPress={() => {
                        return navigation.goBack();
                    }} />),
            headerStyle: {
                borderBottomWidth: 0,
                backgroundColor: 'rgb(47, 54, 61)',
            },
            headerTitleStyle: {
                textAlign: 'center',
                color: 'white',
                fontSize: 25,
            }
        }
    }

    constructor(props) {
        super();
        this.state = {
            oldPassword: '',
            newPassword: '',
            renewPassword: '',
            oldPasswordValid: ' ',
            newPasswordValid: ' ',
            renewPasswordValid: ' ',
        }
    }

    handleChange = (props, params) => {
        this.setState({ [props]: params });
        if (props === 'oldPassword') {
            if (this.state[props].length < 5) {
                this.setState({ oldPasswordValid: 'At least 6 character' });
            } else {
                this.setState({ oldPasswordValid: '' });
            }
        }
        if (props === 'newPassword') {
            if (this.state[props].length < 5) {
                this.setState({ newPasswordValid: 'At least 6 character' });
            } else {
                this.setState({ newPasswordValid: '' });
            }
        }
        if (props === 'renewPassword') {
            if (params !== this.state.newPassword) {
                this.setState({ renewPasswordValid: 'Not same new password' });
            } else {
                this.setState({ renewPasswordValid: '' });
            }
        }
    }

    onSave = () => {
        const { oldPassword, newPassword } = this.state;
        const { updatePassword } = this.props;
        updatePassword(oldPassword, newPassword);
    }
    render() {
        const { errorMsg, isLoading } = this.props;
        return (
            <ScrollView contentContainerStyle={{ flex: 1, backgroundColor: '#d6d7da', alignItems: 'stretch' }}>
                <View>
                    <View style={{ height: 50, marginTop: 10, backgroundColor: 'white', justifyContent: 'center', paddingLeft: 10 }}>
                        <TextInput
                            placeholder='Enter current password'
                            onChangeText={value => this.handleChange('oldPassword', value)}
                            secureTextEntry={true}>
                        </TextInput>
                    </View>
                    <View><Text style={{ color: 'red' }}>{this.state.oldPasswordValid}</Text></View>
                    <View style={{ height: 50, marginTop: 10, backgroundColor: 'white', justifyContent: 'center', paddingLeft: 10 }}>
                        <TextInput
                            placeholder='Enter new password'
                            onChangeText={value => this.handleChange('newPassword', value)}
                            secureTextEntry={true}>
                        </TextInput>
                    </View>
                    <View><Text style={{ color: 'red' }}>{this.state.newPasswordValid}</Text></View>
                    <View style={{ height: 50, marginTop: 10, backgroundColor: 'white', justifyContent: 'center', paddingLeft: 10 }}>

                        <TextInput
                            placeholder='Re-enter new password'
                            onChangeText={value => this.handleChange('renewPassword', value)}
                            secureTextEntry={true}>
                        </TextInput>

                    </View>
                    <View><Text style={{ color: 'red' }}>{this.state.renewPasswordValid}</Text></View>

                    <View style={{ alignItems: 'center' }}>
                        <View style={{
                            borderRadius: 15,
                            padding: 10,
                            borderRadius: 40, backgroundColor: 'rgb(243,177,127)', width: '80%',
                            marginTop: 10,

                        }}>
                            {this.state.renewPasswordValid === '' && this.state.newPasswordValid === '' && this.state.oldPasswordValid === ''
                                ?
                                <TouchableOpacity onPress={this.onSave}>
                                    {isLoading ?
                                        <ActivityIndicator size='small' color='white' />
                                        : <Text style={{
                                            textAlign: 'center',
                                            paddingVertical: 8,
                                            color: 'white',
                                            fontSize: 15,
                                            fontWeight: 'bold',
                                        }}>SAVE</Text>}
                                </TouchableOpacity>
                                :
                                <Text style={{
                                    textAlign: 'center',
                                    paddingVertical: 8,
                                    color: 'white',
                                    fontSize: 15,
                                    fontWeight: 'bold',
                                }}>SAVE</Text>
                            }

                        </View>
                    </View>
                </View>
                {errorMsg !== null ? alert(errorMsg) : <View></View>}
            </ScrollView>
        );
    }
}

export default ChangePassword;