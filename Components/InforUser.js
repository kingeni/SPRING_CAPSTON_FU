import React, { Component } from 'react';
import {
    View,
    Text,
    Button,
    StyleSheet,
    Image,
    ScrollView
} from 'react-native';
import { AntDesign } from '@expo/vector-icons';
class InforUser extends Component {
    constructor(props) {
        super();
        this.state = {
            dataUser: props.navigation.state.params.dataUser
        }
    }

    static navigationOptions = ({ navigation }) => {
        return {
            headerRight: (
                <Button title='Done' onPress={() => navigation.navigate('Home')}></Button>
            ),
            headerLeft: <Button title='Edit' onPress={() => navigation.navigate('EditInforUser', { dataUser: navigation.state.params.dataUser })}></Button>,
            headerStyle: {
                borderBottomWidth: 0,
            }
        }
    }

    render() {
        const { dataUser } = this.state;
        return (
            < ScrollView style={styles.main}>
                <View style={{ flex: 1 }}>
                    <View style={{ flex: 30, justifyContent: 'center', alignItems: 'center' }}>
                        <View style={{ flex: 80, justifyContent: 'center', alignItems: 'center' }}>
                            <Image source={{ uri: `data:image/png;base64,${dataUser.img_url}` }}
                                style={{ width: 120, height: 120, borderRadius: 120 / 2, borderWidth: 0.5 }}>
                            </Image>
                        </View>

                        <Text style={{ flex: 20, fontWeight: 'bold', fontSize: 35 }}>{dataUser.first_name} {dataUser.last_name}</Text>
                    </View>
                    <View style={{ flex: 70, alignItems: 'stretch', paddingTop: 25 }}>
                        <View style={{ flex: 14, borderBottomWidth: 0.5, flexDirection: 'row', borderColor: '#d6d7da', paddingVertical: 15 }}>
                            <View style={{ flex: 30, justifyContent: 'flex-start' }}>
                                <Text>Username</Text>
                            </View>
                            <View style={{ flex: 70, justifyContent: 'flex-end' }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.username}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, borderColor: '#d6d7da', flexDirection: 'row', paddingVertical: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text>Gender</Text>
                            </View>
                            <View style={{ flex: 70, justifyContent: 'flex-end', textAlign: 'right' }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.gender}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, borderColor: '#d6d7da', flexDirection: 'row', paddingVertical: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text>Phone Number</Text>
                            </View>
                            <View style={{ flex: 70, justifyContent: 'flex-end', textAlign: 'right' }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.phone_number}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, borderColor: '#d6d7da', flexDirection: 'row', paddingVertical: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text>CMND</Text>
                            </View>
                            <View style={{ flex: 70, justifyContent: 'flex-end', textAlign: 'right' }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.identity_number}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, flexDirection: 'row', borderColor: '#d6d7da', paddingVertical: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text>Email</Text>
                            </View>
                            <View style={{ flex: 70, justifyContent: 'center', textAlign: 'right' }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.email}</Text>
                            </View>
                        </View>

                        <View style={{ flex: 14, borderBottomWidth: 0.5, flexDirection: 'row', borderColor: '#d6d7da', paddingVertical: 15 }}>
                            <View style={{ flex: 30 }}>
                                <Text>Day of Birth</Text>
                            </View>
                            <View style={{ flex: 70, justifyContent: 'center', textAlign: 'right' }}>
                                <Text style={{ textAlign: 'right' }}>{dataUser.date_of_birth}</Text>
                            </View>
                        </View>

                        <View style={{ flexDirection: 'row', paddingVertical: 15, }}>
                            <View style={{ flex: 30 }}>
                                <Text>Password</Text>
                            </View>

                            <View style={{ flex: 70, justifyContent: 'center', marginTop: 5, flexDirection: 'row' }}>
                                <View style={{ flex: 0.89 }}>
                                    <Text style={{ textAlign: 'right' }}>*********</Text>
                                </View>
                                <View style={{ flex: 0.11, alignItems:'flex-end',justifyContent: 'center' }}>
                                    <AntDesign name='caretright' size={20} color='gray' />
                                </View>
                            </View>
                        </View>
                        <View style={{
                            height: 120,
                            justifyContent: 'space-between'
                        }}>
                            {/* <View style={{ borderRadius: 12, height: '45%', borderWidth: 0.5, padding: 5, backgroundColor: 'blue' }}>
                                <Button title='Change Password' color='white' onPress={() => this.props.navigation.navigate('ChangePassword')}></Button>
                            </View> */}

                            <View style={{ borderRadius: 12, height: '45%', borderWidth: 0.5, padding: 5, backgroundColor: '#0068ff' }}>
                                <Button title='Log out' color='white' onPress={() => this.props.navigation.navigate('Login')}></Button>
                            </View>

                        </View>
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
            paddingRight: 20,
            paddingLeft: 20
        }
    }
);
export default InforUser;