import React from 'react';
import { View, Modal, Button, Text, ActivityIndicator } from 'react-native';

const PopupDiaLog = (props) => {
    const { visible} = props;
    return (

        <Modal
            animatedType='fade'
            visible={visible}
            onRequestClose={() => { }}
            transparent={true}
        >
            <View style={{
                flex: 1,
                borderWidth: 1,
                justifyContent: 'center',
                alignItems: 'center',
            }}>
                <View style={{
                    width: 275,
                    height: 130,
                    // borderWidth: 1,
                    // borderRadius: 9,
                    // borderColor: 'gray',
                    // backgroundColor: 'white',

                }} >
                    <View style={{ flex: 1 }}>
                            <ActivityIndicator  size='large' color='white'/>
                    </View>
                </View>
            </View>

        </Modal>


    )
}
export default PopupDiaLog;