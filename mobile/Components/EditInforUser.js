import React, { Component } from 'react';
import {
    View,
    Text,
    Button,
    Alert,
    Image,
    TextInput,
    TouchableOpacity,
    ScrollView
} from 'react-native';
import {
    ButtonGroup,
    CheckBox
} from 'react-native-elements';
import DateTimePicker from 'react-native-modal-datetime-picker';
import { Octicons, AntDesign } from '@expo/vector-icons';
import FormData from 'FormData';
class EditInforUser extends Component {
    constructor(props) {
        super();
        this.state = {
            dataUser: props.navigation.state.params.dataUser,
            checked: true,
            isDateTimePickerVisible: false,
            first_name: '',
            last_name: '',
            date_of_birth: '',
            email: '',
        }
    }

    showDateTimePicker = () => this.setState({ isDateTimePickerVisible: true });

    hideDateTimePicker = () => this.setState({ isDateTimePickerVisible: false });

    handleDatePicked = (date) => {
        this.handleChange('date_of_birth', date);
        this.hideDateTimePicker();
    };

    handleCheck = (checked, gender) => {
        this.setState({
            checked: !checked,
        })
    };

    static navigationOptions = ({ navigation }) => {
        return {
            headerLeft: <Button title='Cancel' onPress={() => navigation.goBack()}></Button>,
            title: 'Change Information',
            headerStyle: {
                borderBottomWidth: 0,
                backgroundColor: '#d6d7da'
            }
        }
    }
    handleChange(props, value) {
        this.setState({ [props]: value });
    }
    handleChange = (props, params) => {
        this.setState(prevState => ({
            dataUser: {
                ...prevState.dataUser,
                [props]: params
            }
        }));
    }

    onSave = () => {
        const { dataUser, email, first_name, last_name, date_of_birth } = this.state
        let formData = new FormData();
        formData.append('first_name', dataUser.first_name);
        formData.append('last_name', dataUser.last_name);
        formData.append('gender', userData.gender);
        formData.append('date_of_birth', userData.date_of_birth);
        formData.append('email', userData.email);
        formData.append('img', userData.img_url);
        fetch('http://vwms.gourl.pro/api/user-profile/update-user-profile?userId=' + this.state.dataUser.user_id, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: formData
        })
            .then((response)=> response.json())
            .then((responseJSON)=> {
                this.props.navigation.navigate('Home');
            })
            .catch((error) => {
                console.error(error);
            })
    }

    render() {
        const { dataUser } = this.state;
        return (
            <ScrollView contentContainerStyle={{ flex: 1, backgroundColor: '#d6d7da' }}>
                <View style={{
                    flex: 1, justifyContent: 'flex-start'
                }}>

                    <View style={{ height: 150, flexDirection: 'row',backgroundColor: 'white', paddingRight: 20, paddingLeft: 20 }}>
                        <View style={{ flex: 3, alignItems: 'center', justifyContent: 'center' }}>
                            <Image source={{ uri: `data:image/png;base64,${dataUser.img_url}` }}
                                style={{ width: 80, height: 80, borderRadius: 80 / 2, borderWidth: 0.5 }}>
                            </Image>
                        </View>

                        <View style={{ flex: 7, flexDirection: 'column', }}>
                            <View style={{ height: 50, borderBottomWidth: 0.5, borderColor: '#d6d7da', justifyContent: 'center', alignItems: 'center', flexDirection: 'row' }}>
                                <View style={{ flex: 90 }}>
                                    <TextInput placeholder='First Name'
                                        onChangeText={value => this.handleChange('first_name', value)}>
                                        {dataUser.first_name}
                                    </TextInput>

                                </View>
                                <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>
                                    <Octicons name='pencil' size={12} color='black' />
                                </View>
                            </View>
                            <View style={{ height: 50, borderBottomWidth: 0.5, borderColor: '#d6d7da', justifyContent: 'center', flexDirection: 'row', alignItems: 'center' }}>
                                <View style={{ flex: 90 }}>
                                    <TextInput placeholder='Last Name'
                                        onChangeText={value => this.handleChange('last_name', value)}>{dataUser.last_name}
                                    </TextInput>
                                </View>
                                <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>
                                    <Octicons name='pencil' size={12} color='black' />
                                </View>
                            </View>

                            <View style={{ flex: 1, height: 50, flexDirection: 'row', borderColor: '#d6d7da', justifyContent: 'flex-start' }}>
                                <CheckBox
                                    title='Male'
                                    onPress={() => this.handleCheck(this.state.checked, 'Male')}
                                    checked={this.state.checked}
                                    containerStyle={{
                                        width: 100, height: 43,
                                        backgroundColor: 'white',
                                        borderWidth: 0,
                                    }}></CheckBox>

                                <CheckBox title='FeMale'
                                    iconLeft
                                    onPress={() => this.handleCheck(this.state.checked, 'Female')}
                                    checked={!this.state.checked}
                                    containerStyle={{
                                        width: 100, height: 43,
                                        backgroundColor: 'white',
                                        borderWidth: 0,
                                        alignItems: 'flex-start'
                                    }}></CheckBox>

                            </View>

                        </View>
                    </View>

                    <View style={{ height: 50, flexDirection: 'row',backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15 }}>
                        <View style={{ flex: 30, justifyContent: 'flex-end' }}>
                            <Text>Date of birth</Text>
                        </View>
                        <View style={{ flex: 60, justifyContent: 'flex-end', textAlign: 'right' }}>
                            <TouchableOpacity onPress={this.showDateTimePicker}>
                                <Text>{dataUser.date_of_birth}</Text>
                            </TouchableOpacity>
                            <DateTimePicker
                                isVisible={this.state.isDateTimePickerVisible}
                                onConfirm={this.handleDatePicked}
                                onCancel={this.hideDateTimePicker}
                            />
                        </View>
                        <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>
                            <Octicons name='pencil' size={12} color='black' />
                        </View>
                    </View>

                    <View style={{  height: 50, flexDirection: 'row',backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15 }}>
                        <View style={{ flex: 30, justifyContent: 'flex-end' }}>
                            <Text>Phone Number</Text>
                        </View>
                        <View style={{ flex: 60, justifyContent: 'flex-end', textAlign: 'right' }}>
                            <TextInput style={{ textAlign: 'left' }} placeholder='Phone number'
                                onChangeText={value => this.handleChange('phone_number', value)} >{dataUser.phone_number}
                            </TextInput>
                        </View>
                        <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>
                            <Octicons name='pencil' size={12} color='black' />
                        </View>
                    </View>

                    <View style={{  height: 50, flexDirection: 'row',backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15 }}>
                        <View style={{ flex: 30, justifyContent: 'flex-end' }}>
                            <Text>Email</Text>
                        </View>
                        <View style={{ flex: 60, justifyContent: 'flex-end', textAlign: 'right' }}>
                            <TextInput style={{ textAlign: 'left' }} placeholder='Email'
                                onChangeText={value => this.handleChange('email', value)}>{dataUser.email}</TextInput>
                        </View>
                        <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>
                            <Octicons name='pencil' size={12} color='black' />
                        </View>
                    </View>
                    <TouchableOpacity onPress={() => this.props.navigation.navigate('ChangePassword', { password: dataUser.password_hash, user_id: dataUser.user_id })}>
                        <View style={{  height: 50, flexDirection: 'row',backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15  }}>
                            <View style={{ flex: 30, justifyContent: 'flex-end' }}>
                                <Text>Password</Text>
                            </View>

                            <View style={{ flex: 70, justifyContent: 'flex-end', marginTop: 5, }}>
                                <Text style={{ textAlign: 'left' }}>*********</Text>
                            </View>
                            <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>

                                <AntDesign name='caretright' size={15} color='black' />

                            </View>
                        </View>
                    </TouchableOpacity>
                    <View style={{
                        borderRadius: 15,
                        padding: 10,
                        backgroundColor: '#0068ff',
                        marginTop: 20
                    }}>

                        <Button onPress={this.onSave}
                            title='Save' color='white'></Button>
                    </View>


                </View>
            </ScrollView >
        );
    }

}
export default EditInforUser;