import React from 'react';
import { Modal, View, Image, TouchableHighlight, DatePickerIOS } from 'react-native';
import { AntDesign } from '@expo/vector-icons';
import DateTimePicker from 'react-native-modal-datetime-picker'; 
class DatePicker extends React.Component {
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
                    <DataPickerIOS></DataPickerIOS>
                </View>

            </Modal>
        );
    }
}
export default DatePicker;