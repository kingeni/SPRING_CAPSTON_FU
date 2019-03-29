import React from 'react';
import { Modal, View, Image, TouchableHighlight  } from 'react-native';
import { AntDesign } from '@expo/vector-icons';
class ImageModal extends React.Component {
    closeVisible = () => {
        this.props.onChangeVisible(false);

    }
    render() {
        const {img} = this.props;
        return (
            <Modal
                animationType='slide'
                visible={this.props.visibleStatus}
                onRequestClose={()=>{}}
            >
                <View style={{ flex: 1, backgroundColor: 'black' }}>
                <TouchableHighlight>
                    <AntDesign name='close'
                size={30} color='white'
                style={{ marginTop: 10,}}
                onPress={()=>this.closeVisible(false)}/>
                </TouchableHighlight>
                    <Image
                    source={{uri : `data:image/png;base64,${img}`}}
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