import React, { Component } from 'react';
import {
    View,
    StyleSheet,
    Image,
    TouchableOpacity,
    Text
} from 'react-native';
import { AntDesign } from '@expo/vector-icons';
import { Divider } from 'react-native-elements';
class HistoryItem extends Component {
    render() {
        var { id, item } = this.props;
        const finalStyle = item.status == 1 ? styles.text1: styles.text2;
        return (
            <View style={styles.container}>
                
                <Text style={finalStyle}>Time: {item.time}</Text>
                <Text style={finalStyle}>Station : {item.station_id}- Weight: {item.vehicle_weight}KG</Text>
                <Divider style={{ backgroundColor: 'gray' }} />
            </View>
        );
    }
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'flex-start',
    },
    text: {
        fontSize: 30,
        fontWeight: "500",
        paddingBottom: 5
    },
    text1: {
        fontSize: 20,
        fontWeight: "300",
        paddingLeft: 7,
        paddingTop: 5,

    },
    text2: {
        fontSize: 20,
        fontWeight: "300",
        paddingLeft: 7,
        paddingTop: 5,
        color: 'red'
    }
});
export default HistoryItem;