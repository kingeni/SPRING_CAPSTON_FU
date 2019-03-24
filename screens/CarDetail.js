import React, { Component } from 'react';
import {
    View,
    StyleSheet,
    Image,
    Text,
    TextInput,
    FlatList,
    Alert,
    ScrollView,
} from 'react-native';
import { AntDesign } from '@expo/vector-icons';
import styles from '../Components/Styles';
// import ImageModal from './ImageModal';
import ImageItem from '../Components/ImageItem';
let check = false;
class CarDetail extends Component {

    constructor(props) {
        super();
        this.state = {
            visibleStatus: false,
            detail: props.navigation.state.params.item
        };
    }

    static navigationOptions = ({ navigation}) => {
           let title = navigation.state.params.item.name;
        return {
            title 
        }
    }

    changeVisibleStatus = (bool) => {
        this.setState({
            visibleStatus: bool
        });
    }
    render() {
        let { visibleStatus, detail } = this.state;
        
        return (
            <ScrollView style={{ flex: 1, marginTop: 20, marginLeft: 20, marginRight: 20 }}>
                <View style={{ alignItems: 'stretch' }}>
                    <View style={{ ...styles.flex_row, paddingVertical: 15, borderColor: '#d6d7da' }}>
                        <Text style={styles.flex_50}>License plates</Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{detail.license_plates}</Text>
                    </View>
                    <View style={{ ...styles.flex_row, paddingVertical: 15, borderColor: '#d6d7da' }}>
                        <Text style={styles.flex_50}>Name</Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{detail.name}</Text>
                    </View>
                    <View style={{ ...styles.flex_row, paddingVertical: 15, borderColor: '#d6d7da' }}>
                        <Text style={styles.flex_50}>Expiration date</Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{detail.expiration_date}</Text>
                    </View>
                    <View style={{ ...styles.flex_row, paddingVertical: 15, borderColor: '#d6d7da' }}>
                        <Text style={styles.flex_50}>Max load</Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{detail.vehicle_weight_id}</Text>
                    </View>
                    <View style={{ ...styles.flex_row, paddingVertical: 15, borderBottomWidth: 0 }}>
                        <Text style={styles.flex_50}>Breaking Law's number  </Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{detail.number_of_violations}</Text>
                    </View>
                </View>

                <View style={{ alignItems: 'stretch', paddingTop: 10 }}>
                    <Text style={{ fontSize: 15, color: 'blue' }}>Image</Text>
                </View>

                <View style={{
                    flexDirection: 'row',
                    justifyContent: 'space-between',
                    flexWrap: 'wrap',
                    width: '100%'
                }}>
                    <FlatList
                        data={[{ aaa: '11' }]}
                        ListHeaderComponent={this._headerComponet}
                        keyExtractor={(item, index) => index.toString()}
                        horizontal={false}
                        extraData={this.state}
                        numColumns={3}
                        renderItem={({ item }) =>
                            (<ImageItem visibleStatus={visibleStatus}  onChangeVisible={this.changeVisibleStatus} />)
                        }
                    >
                    </FlatList>


                </View>

            </ScrollView>

        );
    }
}
const styles1 = StyleSheet.create({
    image: {
        flex: 1,
        width: null,
        height: null,
        resizeMode: 'contain',

    }
});
export default CarDetail;