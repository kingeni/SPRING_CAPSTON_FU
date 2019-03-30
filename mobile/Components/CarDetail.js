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
    ActivityIndicator,
} from 'react-native';
import { AntDesign } from '@expo/vector-icons';
import styles from '../Components/Styles';
// import ImageModal from './ImageModal';
import ImageItem from '../Components/ImageItem';
// let check = false;
class CarDetail extends Component {

    constructor(props) {
        super();
        this.state = {
            visibleStatus: false,
            detail: props.navigation.state.params.item
        };
    }

    static navigationOptions = ({ navigation }) => {
        // let title = navigation.state.params.item.name;
        const title = 'DETAIL VEHICLE';
        return {
            title,
            headerStyle: {
                borderBottomWidth: 0,
                backgroundColor: '#d6d7da',
            },
        }
    }
    // componentDidMount() {
    //     const { getDetailVehicle } = this.props;
    // }
    changeVisibleStatus = (bool) => {
        this.setState({
            visibleStatus: bool
        });
    }
    render() {
        let { visibleStatus } = this.state;
        const { getDetailVehicle, getListImage, isLoading } = this.props;
        return (
            <ScrollView style={{ flex: 1, backgroundColor: '#d6d7da' }}>
                <View style={{ alignItems: 'stretch' }}>
                    <View style={{ ...styles.flex_row, padding: 15, marginTop: 25, backgroundColor: 'white' }}>
                        <Text style={styles.flex_50}>License plates</Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{getDetailVehicle.license_plates}</Text>
                    </View>
                    <View style={{ ...styles.flex_row, padding: 15, backgroundColor: 'white' }}>
                        <Text style={styles.flex_50}>Name</Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{getDetailVehicle.name}</Text>
                    </View>
                    <View style={{ ...styles.flex_row, padding: 15, backgroundColor: 'white' }}>
                        <Text style={styles.flex_50}>Expiration date</Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{getDetailVehicle.expiration_date}</Text>
                    </View>
                    <View style={{ ...styles.flex_row, padding: 15, backgroundColor: 'white' }}>
                        <Text style={styles.flex_50}>Max load</Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{getDetailVehicle.vehicle_maxload}</Text>
                    </View>
                    <View style={{ ...styles.flex_row, padding: 15,borderBottomWidth: 0, marginBottom: 5, backgroundColor: 'white' }}>
                        <Text style={styles.flex_50}>Breaking Law's number  </Text>
                        <Text style={{ ...styles.flex_50, textAlign: 'right' }}>{getDetailVehicle.number_of_violations}</Text>
                    </View>
                </View>

                <View style={{ alignItems: 'stretch', paddingTop: 10, paddingLeft:10 }}>
                    <Text style={{ fontSize: 15, color: 'blue' }}>Image</Text>
                </View>

                <View style={{
                    flexDirection: 'row',
                    justifyContent: 'space-between',
                    flexWrap: 'wrap',
                    width: '100%',
                    backgroundColor: 'white'
                }}>
                    {isLoading ?
                        <FlatList
                            data={getListImage}
                            keyExtractor={(item, index) => index.toString()}
                            horizontal={false}
                            extraData={this.state}
                            numColumns={3}
                            renderItem={({ item }) =>
                                (<ImageItem visibleStatus={visibleStatus} item={item} onChangeVisible={this.changeVisibleStatus} />)
                            }
                        >
                        </FlatList> :
                         <ActivityIndicator size="small" color="#0000ff"/>
                    }


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