import React, { Component } from 'react';
import {
    View,
    Text,
    Button,
    Alert,
    Image,
    TextInput,
    TouchableOpacity,
    ScrollView,
    ActivityIndicator,
} from 'react-native';
import {
    ButtonGroup,
    CheckBox,
} from 'react-native-elements';
import DateTimePicker from 'react-native-modal-datetime-picker';
import { ImagePicker, Permissions } from 'expo';
import { Octicons, AntDesign, Entypo } from '@expo/vector-icons';
import PopupDialog from './PopupDialog';
import moment from 'moment';
class EditInforUser extends Component {
    constructor(props) {
        super();
        this.state = {
            checkedMale: false,
            checkFemale: false,
            firstNameValid: ' ',
            lastNameValid: ' ',
            phoneValid: ' ',
            emailValid: ' ',
            addressValid: ' ',
            visibleSave: true,
            isDateTimePickerVisible: false,
            isLoading: false,
            dataUser: {},

        }
    }

    showDateTimePicker = () => this.setState({ isDateTimePickerVisible: true });

    hideDateTimePicker = () => this.setState({ isDateTimePickerVisible: false });

    handleDatePicked = (date) => {
        this.handleChange('date_of_birth', moment(date).format('YYYY-MM-DD'));
        this.hideDateTimePicker();
        // console.log('date:',moment(date).format('YYYY-MM-DD HH:mm:ss'));
    };

    pickImage = async () => {
        await Permissions.askAsync(Permissions.CAMERA_ROLL);
        let result = await ImagePicker.launchImageLibraryAsync({
            allowsEditing: true,
            aspect: [4, 3],
            base64: true,
        });
        if (!result.cancelled) {
            this.setState(prevState => ({
                dataUser: {
                    ...prevState.dataUser,
                    img_url: result.base64,
                }
            }));
        }
    };
    handleCheck = (gender) => {
        if (gender === 'Male') {
            this.setState(prevState => ({
                checkedMale: true,
                checkFemale: false,
                dataUser: {
                    ...prevState.dataUser,
                    gender,
                }
            }));
        } else {
            this.setState(prevState => ({
                checkedMale: false,
                checkFemale: true,
                dataUser: {
                    ...prevState.dataUser,
                    gender,
                }
            }));
        }
    };

    static navigationOptions = ({ navigation }) => {
        return {
            headerLeft: (
                <TouchableOpacity onPress={() => navigation.goBack()}>
                    <View style={{ backgroundColor: 'rgb(47, 54, 61)' }}>
                        <Text style={{ color: 'rgb(243,177,127)', paddingLeft: 9, fontSize: 18 }}>Cancel</Text>
                        {/* <Button title='Done' color='rgb(243,177,127)' onPress={() => navigation.navigate('Home')}> </Button> */}
                    </View>
                </TouchableOpacity>),
            title: 'EDIT INFORMATION',
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

    handleChange = (props, value) => {
        const name = /^[a-zA-Z0-9]+$/;
        const number = /^[0-9]+$/;
        const email = /^[a-z0-9][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/;
        if (props === 'first_name') {
            if (name.test(value)) {
                this.setState(prevState => ({
                    firstNameValid: ' ',
                    dataUser: {
                        ...prevState.dataUser,
                        [props]: value
                    },
                }));
            } else {
                this.setState({
                    firstNameValid: 'Input only letters and numbers',
                });
            }
        }
        if (props === 'last_name') {
            if (name.test(value)) {
                this.setState(prevState => ({
                    lastNameValid: ' ',
                    dataUser: {
                        ...prevState.dataUser,
                        [props]: value
                    },
                }));
            } else {
                this.setState({
                    lastNameValid: 'Input only alpha and number',
                });
            }
        }
        if (props === 'phone_number') {
            if (number.test(value)) {
                this.setState(prevState => ({
                    phoneValid: ' ',
                    dataUser: {
                        ...prevState.dataUser,
                        [props]: value
                    },
                }));
            } else {
                this.setState({
                    phoneValid: 'Input only number',

                });
            }
        }
        if (props === 'email') {
            if (email.test(value)) {
                this.setState(prevState => ({
                    emailValid: ' ',
                    dataUser: {
                        ...prevState.dataUser,
                        [props]: value
                    },
                }));
            } else {
                this.setState({
                    emailValid: 'must xxxx@xxx.xxx.xx',
                });
            }
        }
        if (props === 'date_of_birth') {
            this.setState(preveState => ({
                dataUser: {
                    ...preveState.dataUser,
                    [props]: value,
                }
            }));
        }
        if (props === 'address') {
            if (value !== '') {
                this.setState(prevState => ({
                    addressValid: ' ',
                    dataUser: {
                        ...prevState.dataUser,
                        [props]: value
                    },
                }));
            } else {
                this.setState({
                    addressValid: 'Can not empty',
                });
            }
        }
    }

    componentDidMount() {
        const { dataUser } = this.props;

        if (dataUser.gender === 'Male') {
            this.setState({
                checkedMale: true,
                checkFemale: false,
                dataUser,
                isLoading: true,
            });
        } else {
            this.setState({
                checkedMale: false,
                checkFemale: true,
                dataUser,
                isLoading: true,
            });
        }

    }

    onSave = () => {
        const { updateInfo } = this.props;
        const { dataUser } = this.state;
        updateInfo(dataUser);
        // this.props.navigation.navigate('InforUser');
    }

    render() {
        console.log('RENDER');
        const { dataUser, firstNameValid, lastNameValid, phoneValid, emailValid, isLoading, addressValid } = this.state;
        const { isLoadingStatus, errorMsg } = this.props;
        return (

            <ScrollView contentContainerStyle={{
                flex: 1,
                // backgroundColor: 'rgb(79,88,86)',
                backgroundColor: '#d6d7da',
            }}>
                {isLoading ?
                    <View style={{
                        flex: 1, justifyContent: 'flex-start'
                    }}>

                        <View style={{ height: 190, flexDirection: 'row', backgroundColor: 'white', paddingRight: 20, paddingLeft: 20 }}>
                            <TouchableOpacity
                                onPress={() => this.pickImage()}
                                style={{ flex: 3, alignItems: 'center', justifyContent: 'center' }}>
                                <View style={{ flex: 3, alignItems: 'center', justifyContent: 'center' }} >
                                    <Image source={{ uri: `data:image/png;base64,${dataUser.img_url}` }}
                                        style={{ width: 80, height: 80, borderRadius: 80 / 2, borderWidth: 0.5 }}>
                                    </Image>
                                </View>
                            </TouchableOpacity>


                            <View style={{ flex: 7, flexDirection: 'column', }}>
                                <View>
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
                                    <View><Text style={{ color: 'red' }}>{firstNameValid}</Text></View>
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
                                <View><Text style={{ color: 'red' }}>{lastNameValid}</Text></View>

                                <View style={{ flex: 1, height: 50, flexDirection: 'row', borderColor: '#d6d7da', justifyContent: 'flex-start' }}>
                                    <CheckBox
                                        title='Male'
                                        onPress={() => this.handleCheck('Male')}
                                        checked={this.state.checkedMale}
                                        containerStyle={{
                                            width: 100, height: 43,
                                            backgroundColor: 'white',
                                            borderWidth: 0,
                                        }}></CheckBox>

                                    <CheckBox title='FeMale'
                                        iconLeft
                                        onPress={() => this.handleCheck('FeMale')}
                                        checked={this.state.checkFemale}
                                        containerStyle={{
                                            width: 100, height: 43,
                                            backgroundColor: 'white',
                                            borderWidth: 0,
                                            alignItems: 'flex-start'
                                        }}></CheckBox>

                                </View>

                            </View>
                        </View>
                        <View><Text style={{ color: 'red' }}></Text></View>
                        <View style={{ height: 50, flexDirection: 'row', backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15 }}>
                            <View style={{ flex: 30, }}>
                                <Text style={{ fontWeight: 'bold' }}>Date of birth</Text>
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
                        <View><Text style={{ color: 'red' }}></Text></View>
                        <View style={{ height: 50, flexDirection: 'row', backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15 }}>
                            <View style={{ flex: 30, justifyContent: 'flex-end', fontWeight: 'bold' }}>
                                <Text style={{ fontWeight: 'bold' }}>Email</Text>
                            </View>
                            <View style={{ flex: 60, justifyContent: 'flex-end', textAlign: 'right' }}>
                                <TextInput style={{ textAlign: 'left' }} placeholder='Email'
                                    onChangeText={value => this.handleChange('email', value)}>{dataUser.email}</TextInput>
                            </View>
                            <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>
                                <Octicons name='pencil' size={12} color='black' />
                            </View>
                        </View>
                        <View><Text style={{ color: 'red' }}>{emailValid}</Text></View>

                        <View style={{ height: 50, flexDirection: 'row', backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15 }}>
                            <View style={{ flex: 30, justifyContent: 'flex-end', fontWeight: 'bold' }}>
                                <Text style={{ fontWeight: 'bold' }}>Address</Text>
                            </View>
                            <View style={{ flex: 60, justifyContent: 'flex-end', textAlign: 'right' }}>
                                <TextInput style={{ textAlign: 'left' }} placeholder='Email'
                                    onChangeText={value => this.handleChange('address', value)}>{dataUser.address}</TextInput>
                            </View>
                            <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>
                                <Octicons name='pencil' size={12} color='black' />
                            </View>
                        </View>
                        <View><Text style={{ color: 'red' }}>{addressValid}</Text></View>
                        <View style={{ height: 50, flexDirection: 'row', backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15 }}>
                            <View style={{ flex: 30, justifyContent: 'flex-end', fontWeight: 'bold' }}>
                                <Text style={{ fontWeight: 'bold' }}>Phone Number</Text>
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
                        <View><Text style={{ color: 'red' }}>{phoneValid}</Text></View>

                        <TouchableOpacity onPress={() => this.props.navigation.navigate('ChangePassword', { password: dataUser.password_hash, user_id: dataUser.user_id })}>
                            <View style={{ height: 50, flexDirection: 'row', backgroundColor: 'white', paddingRight: 20, paddingLeft: 20, marginTop: 5, paddingVertical: 15 }}>
                                <View style={{ flex: 30, justifyContent: 'flex-start', fontWeight: 'bold' }}>
                                    <Text style={{ fontWeight: 'bold' }}>Password</Text>
                                </View>

                                <View style={{ flex: 60, justifyContent: 'flex-end', marginTop: 5, }}>
                                    <Text style={{ textAlign: 'left' }}>*********</Text>
                                </View>
                                <View style={{ flex: 10, flexDirection: 'row', justifyContent: 'flex-end' }}>

                                    <AntDesign name='caretright' size={15} color='black' />

                                </View>
                            </View>
                        </TouchableOpacity>
                        <View style={{
                            alignItems: 'center', width: '100%'
                        }}>

                            <View style={{
                                borderRadius: 15,
                                padding: 10,
                                borderRadius: 40, backgroundColor: 'rgb(243,177,127)', width: '80%',
                                marginTop: 10,

                            }}>
                                {firstNameValid === ' ' && lastNameValid === ' ' && phoneValid === ' ' && emailValid === ' ' && addressValid === ' '
                                    ?
                                    <TouchableOpacity onPress={this.onSave}>
                                        {isLoadingStatus
                                            ?
                                            <ActivityIndicator style={{ paddingVertical: 8, }} size="small" color="white" />
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
                                {/* <PopupDialog visible={isLoadingStatus}/> */}
                            </View>
                        </View>

                    </View> : <View></View>
                }
                {errorMsg === null ? <View></View> : alert(errorMsg)}
            </ScrollView >
        );
    }

}
export default EditInforUser;