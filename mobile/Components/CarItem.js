import React, { Component } from 'react';
import {
    View,
    StyleSheet,
    Image,
    TouchableOpacity,
    Text
} from 'react-native';
import { AntDesign } from '@expo/vector-icons';

class CarItem extends Component {
    onPressItem = (item) => {
        this.props.onPress(item);
    }
    
    render() {
        var { id, item} = this.props;
        return (
            <TouchableOpacity onPress={() => this.onPressItem(item)}>
                <View style={styles.container}>
                    <View style={styles.circle}>
                        <Image
                            source={item.img != null ? {uri: `data:image/png;base64,${item.img}`} : {uri : 'http://www.riversidefestival.charlbury.com/pictures/car%20button.jpg'} }
                            style={{ width: 70, height: 70, borderRadius: 70 / 2, borderWidth: 0.5 }}>
                        </Image>
                    </View>
                    <View style={styles.header_contain}>
                        {item.number_of_unread > 0 ?
                            <View style={{ flex: 90 }} >
                                <Text style={{ fontSize: 18, fontWeight: '900' }} >{item.name} {`(${item.number_of_unread})`} </Text>
                                <Text style={{ fontSize: 13, color: 'gray',fontWeight: 'bold' }} >{item.newest_transaction.created_at}</Text>
                            </View> :
                            <View style={{ flex: 90 }} >
                                <Text style={{ fontSize: 18, fontWeight: 'normal' }} >{item.name} </Text>
                                <Text style={{ fontSize: 13, color: 'gray', fontWeight: 'normal' }} >{item.create_at}</Text>
                            </View>}

                        <View style={{ flex: 10 }}>
                            <AntDesign name='caretright' size={15} color='gray' />
                        </View>
                    </View>

                </View>
            </TouchableOpacity>
        );
    }
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        marginTop: 5,
        justifyContent: 'flex-start',
        flexDirection: 'row',
        backgroundColor: 'white',
        padding : 5
    },
    circle: {
        flex: 20
    },
    header_contain: {
        flexDirection: 'row',
        flex: 80,
        justifyContent: 'center',
        alignItems: 'center'

    },
    header_text: {
        fontSize: 25,
        flex: 80,
    }
});
export default CarItem;