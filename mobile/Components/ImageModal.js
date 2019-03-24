import React from 'react';
import { Modal, View, Image, TouchableHighlight  } from 'react-native';
import { AntDesign } from '@expo/vector-icons';
class ImageModal extends React.Component {
    closeVisible = () => {
        this.props.onChangeVisible(false);

    }
    render() {
        return (
            <Modal
                animationType='slide'
                visible={this.props.visibleStatus}
            >
                <View style={{ flex: 1, backgroundColor: 'black' }}>
                <TouchableHighlight>
                    <AntDesign name='close'
                size={30} color='white'
                style={{ marginTop: 10,}}
                onPress={()=>this.closeVisible(false)}/>
                </TouchableHighlight>
                    <Image
                    source={require('../assets/images/robot-dev.png')}
                    style={{
                        flex: 1,
                        width: null,
                        height: null,
                        resizeMode: 'contain',

                    }}></Image>
                </View>

            </Modal>
        );
    }
}
export default ImageModal;