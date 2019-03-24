import React from 'react';
import { View, Modal, Button, Text } from 'react-native';

const PopupDiaLog = (props) => {
    const { visible, msgErr, onChangeStatus } = props
    return (

        <Modal
            animatedType='fade'
            visible={visible}
        >
            <View style={{
                flex: 1,
                borderWidth: 1,
                justifyContent: 'center',
                alignItems: 'center',
                backgroundColor: 'gray'
            }}>
                <View style={{
                    width: 275,
                    height: 130,
                    borderWidth: 1,
                    borderRadius: 9,
                    borderColor: 'gray',
                    backgroundColor: 'white',
                    
                }} >
                <View style={{flex: 1}}>
                    <View style={{ flex: 6, borderBottomWidth: 1, justifyContent: 'center', borderColor: '#d6d7da' }}>
                        <Text style={{ textAlign: 'center', fontWeight:'bold', fontSize: 17 }}>Alert</Text>
                        <Text style={{ textAlign: 'center' }}>{msgErr}</Text>
                    </View>
                    <View style={{ flex: 4, justifyContent: 'center' }}>
                        <Button  title='OK' onPress={() => onChangeStatus()}></Button> 
                    </View>
                </View>
                </View>
            </View>

        </Modal>


    )
}
export default PopupDiaLog;