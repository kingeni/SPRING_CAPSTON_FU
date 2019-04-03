import React, { Component } from 'react';
import {
    View,
    StyleSheet,
    Image,
    TouchableOpacity,
    Text
} from 'react-native';
import { MaterialCommunityIcons } from '@expo/vector-icons';
import { Divider } from 'react-native-elements';
class HistoryItem extends Component {
    render() {
        var { id, item } = this.props;
        const finalStyle = item.status === 1 ? styles.text1 : (item.status === 2 ? styles.text2 : styles.text3);
        const icon = item.status === 1 ? 'checkbox-marked-circle-outline' :
            (item.status === 2 ? 'alert-circle-outline' : 'autorenew');
        const color = item.status === 2 ? 'red' : 'gray';
        return (
            <View style={{ ...styles.container, backgroundColor: 'white', justifyContent: 'center' }}>
           
                    <View style={{ flex: 10, alignItems: 'center', justifyContent: 'center' }}>
                        <MaterialCommunityIcons name={icon} color={color} size={25} />
                    </View>
                    <View style={{ flex: 85 }}>
                        <View style={{ ...styles.container, flexDirection: 'column', }}>
                            <Text style={finalStyle}>Time: {item.time} - Weight: {item.vehicle_weight} T</Text>
                            <Text style={finalStyle}>Station : {item.station_id}</Text>
                        </View>
                        <Divider style={{ backgroundColor: 'gray' }} />
                </View>
                <View style={{ flex: 5}}>
                       
                    </View>
            </View>
        );
    }
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        flexDirection: 'row',
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
    },
    text3: {
        fontSize: 20,
        fontWeight: "300",
        paddingLeft: 7,
        paddingTop: 5,
        color: 'gray'
    }
});
export default HistoryItem;