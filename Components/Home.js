import React, { Component } from 'react';
import {
    View,
    StyleSheet,
    Image,
    Text,
    TextInput,
    FlatList,
    Alert,
    TouchableOpacity
} from 'react-native';
import styles from './Styles';
import { AntDesign } from '@expo/vector-icons';
import CarItem from './CarItem';

class Home extends Component {
    constructor(props) {
        super();
        this.state = {
            search: '',
            dataUser: props.navigation.state.params.data,
            dataOfCars: [],
            searchData: null,
            componentCrashed: false,
        }
        this.timeId = null;
    }

    componentDidCatch(error, info) {
        console.log(error);
        console.log(info);
        console.log('_______DID CATCH____________');
        this.setState({ componentCrashed: true });
    }
    componentDidMount() {
        this.timeId = setInterval(this.getAllCar.bind(this), 3000);
    }
    componentUnmount (){
        this.clearInterval();
    }
     getAllCar() {
        fetch('http://vwms.gourl.pro/api/vehicle/get-vehicles?userId=' + this.state.dataUser.user_id)
            .then((response) => response.json())
            .then((dataOfCars) => {
                console.log('aaa', dataOfCars);
                this.setState({ dataOfCars });
            })
            .catch((error) => {
                console.error(error);
            });
    }
    clearInterval = () => {
        const { timeId } = this;
        clearInterval(timeId);
    }

    componentWillUnmount() {
      clearInterval(this.timeId);
    }

    // async getHistory() {
    //     fetch('http://vwms.gourl.pro/api/transaction/get-transactions?', { method: "POST" })
    //         .then((response) => response.json())
    //         .then((responseData) => {

    //         })
    //         .catch((error) => {
    //             console.error(error);
    //         });
    // }

    static navigationOptions = {
        header: null
    };

    handleSearch = (text) => {
        const searchData = this.state.data.filter(date => date.name.indexOf(text) > -1);
        this.setState({ searchData });
    }

    _onPress = (item) => {
        this.props.navigation.navigate('HistoryList', { item });
        console.log('item',item);
        // this.clearInterval();
    }

    _onPress1 = () => {
        const { dataUser } = this.state;
        this.props.navigation.navigate('InforUser', { dataUser });
        // this.clearInterval();
    }

    _headerComponet = () => (<View style={styles.search_contain} >
        <View style={styles.icon_flex}>
            <AntDesign name='search1' size={20} color='white' />
        </View>
        <TextInput style={styles.search_text} onChangeText={value => this.handleSearch(value)} placeholder='Searching'></TextInput>
    </View>)

    render() {
        let { dataUser } = this.state;
        return (
            <View style={styles.container}>
                <View style={styles.header} >
                    <TouchableOpacity style={styles.circle} onPress={this._onPress1}>
                        <Image
                            source={{ uri: `data:image/png;base64,${dataUser.img_url}` }}
                            style={{ width: 60, height: 60, borderRadius: 60 / 2, borderWidth: 0.5 }}>
                        </Image>

                    </TouchableOpacity>
                    <View style={styles.header_contain}>
                        <Text style={styles.header_text}>{dataUser.first_name} {dataUser.last_name}</Text>
                    </View>
                </View>

                <View style={styles.item_contain} >
                    <FlatList
                        data={this.state.searchData === null ? this.state.dataOfCars : this.state.dataOfCars}
                        ListHeaderComponent={this._headerComponet}
                        keyExtractor={(item, index) => index.toString()}
                        renderItem={({ item }) =>
                            (<CarItem item={item} onPress={this._onPress} id={item.id} />)
                        }
                    >
                    </FlatList>
                </View>

            </View>
        );
    }

}
export default Home;