import React, { Component } from 'react';
import {
    View,
    Text,
    Button,
    StyleSheet,
    Image,
    ScrollView,
    TouchableOpacity,
} from 'react-native';
import { AntDesign, FontAwesome } from '@expo/vector-icons';
class InforUser extends Component {
    constructor(props) {
        super();
    }
    static navigationOptions = ({ navigation }) => {
        return {
            headerRight: (
                <TouchableOpacity onPress={() => navigation.navigate('Home')}>
                    <View style={{ backgroundColor: 'rgb(47, 54, 61)' }}>
                        <Text style={{ color: 'rgb(243,177,127)', paddingRight: 9, fontSize: 18 }}>Done</Text>

                    </View>
                </TouchableOpacity>),
            headerLeft: (
                <TouchableOpacity onPress={() => navigation.navigate('EditInforUser')}>
                    <View style={{ backgroundColor: 'rgb(47, 54, 61)' }}>
                        <Text style={{ color: 'rgb(243,177,127)', paddingLeft: 9, fontSize: 18 }}>Edit</Text>

                    </View>
                </TouchableOpacity>),

            // (<View style={{ backgroundColor: 'rgb(47, 54, 61)' }}>
            //     <Button title='Edit' color='rgb(243,177,127)' onPress={() => navigation.navigate('EditInforUser')}></Button>
            // </View>),
            title: 'DETAIL',
            headerStyle: {
                borderBottomWidth: 0,
                backgroundColor: 'rgb(47, 54, 61)',
            },
            swipeEnabled: false,
            headerTitleStyle: {
                textAlign: "center",
                flex: 1,
                color: 'white',
                fontSize: 25,
            },
        }
    }

    render() {
        const { dataUser, logout } = this.props;
        return (
            < ScrollView style={styles.main}>
                <View style={{ flex: 1, }}>
                    <View style={{ flex: 30, justifyContent: 'center', alignItems: 'center' }}>
                        <View style={{ flex: 80, justifyContent: 'center', alignItems: 'center' }}>
                            <Image source={{ uri: `data:image/png;base64,${dataUser.img_url}` }}
                                style={{ width: 120, height: 120, borderRadius: 120 / 2, borderWidth: 0.5 }}>
                            </Image>
                        </View>

                        <Text style={{ flex: 20, fontWeight: 'bold', color: 'black', fontSize: 35 }}>{dataUser.first_name} {dataUser.last_name}</Text>
                    </View>
                    <View style={{ flex: 70, alignItems: 'stretch', marginTop: 15, backgroundColor: 'white' }}>
                        <View style={{ flex: 14, borderBottomWidth: 0.5, flexDirection: 'row', borderColor: '#d6d7da', padding: 15 }}>
                            <View style={{ flex: 30, justifyContent: 'flex-start', flexDirection: 'row', alignItems: 'center' }}>
                                <Text style={{ fontWeight: 'bold' }}> Username</Text>
                            </View>
                            <View style={{ flex: 70 }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.username}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, borderColor: '#d6d7da', flexDirection: 'row', padding: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text style={{ fontWeight: 'bold' }}>Gender</Text>
                            </View>
                            <View style={{ flex: 70 }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.gender}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, borderColor: '#d6d7da', flexDirection: 'row', padding: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text style={{ fontWeight: 'bold' }}>Phone Number</Text>
                            </View>
                            <View style={{ flex: 70 }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.phone_number}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, borderColor: '#d6d7da', flexDirection: 'row', padding: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text style={{ fontWeight: 'bold' }}>Address</Text>
                            </View>
                            <View style={{ flex: 70 }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.address}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, flexDirection: 'row', borderColor: '#d6d7da', padding: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text style={{ fontWeight: 'bold' }}>Email</Text>
                            </View>
                            <View style={{ flex: 70 }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.email}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, flexDirection: 'row', borderColor: '#d6d7da', padding: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text style={{ fontWeight: 'bold' }}>Day of Birth</Text>
                            </View>
                            <View style={{ flex: 70 }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.date_of_birth}</Text>
                            </View>
                        </View>

                        <TouchableOpacity onPress={()=> this.props.navigation.navigate('ChangePassword')}>
                            <View style={{ flexDirection: 'row', padding: 15, }}>
                                <View style={{ flex: 30, }}>
                                    <Text style={{ fontWeight: 'bold' }}>Password</Text>
                                </View>

                                <View style={{ flex: 70, justifyContent: 'center', marginTop: 5, flexDirection: 'row' }}>
                                    <View style={{ flex: 0.89 }}>
                                        <Text style={{ textAlign: 'right' }}>*********</Text>
                                    </View>
                                    <View style={{ flex: 0.11, alignItems: 'flex-end', justifyContent: 'center' }}>
                                        <AntDesign name='caretright' size={18} color='gray' />
                                    </View>
                                </View>
                            </View>
                        </TouchableOpacity>
                    </View>
                </View>
                <View style={{
                    height: 120,

                    marginTop: 5,
                    alignItems: 'center'
                }}>

                    <View style={{
                        height: '45%',
                        padding: 5,
                        borderRadius: 40,
                        backgroundColor: 'rgb(243,177,127)',
                        width: '70%'
                    }}>
                        <TouchableOpacity onPress={() => {
                            logout();
                            return this.props.navigation.navigate('Login');
                        }}>
                            <Text style={{
                                textAlign: 'center',
                                paddingTop: 10,
                                fontSize: 15,
                                color: 'white',
                                fontWeight: 'bold',
                            }}>SIGN OUT</Text>
                        </TouchableOpacity>
                        {/* <Button title='SIGN OUT' color='white' onPress={() => {
                            logout();
                            return this.props.navigation.navigate('Login');
                        }}></Button> */}
                    </View>

                </View>
            </ScrollView>
        );
    }
}
const styles = StyleSheet.create(
    {
        main: {
            // marginLeft: 10,
            // marginRight: 10,
            flex: 1,
            // paddingRight: 20,
            // paddingLeft: 20,
            // backgroundColor: 'rgb(79,88,86)',
            backgroundColor: '#d6d7da',
        }
    }
);
export default InforUser;