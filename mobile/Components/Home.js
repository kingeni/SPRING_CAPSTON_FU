import React, { Component } from 'react';
import {
  View,
  StyleSheet,
  Image,
  Text,
  TextInput,
  FlatList,
  Alert,
  TouchableOpacity,
  ImageBackground
} from 'react-native';
import styles from '../Components/Styles';
import { AntDesign } from '@expo/vector-icons';
import CarItem from '../Components/CarItem';
import NavigationService from '../common/NavigationService';

class Home extends Component {
  constructor(props) {
    super();
    this.state = {
      search: '',
      dataOfCars: [],
      searchData: null,
      componentCrashed: false,
      isLoading: false
    }
    this.timeId = null;
  }

  static navigationOptions = {
    header: null
  };


  handleSearch = () => {
    // fetch rồi phải lấy data ra từ state
    // đổi tên data thành gì đó ngữ nghĩa chút
    const { search } = this.state;
    const { listVehicle } = this.props;
    const searchData = listVehicle.filter(date => date.name.includes(search));
    return searchData; // can not find text
  }

  handleSearchText = (text) => {
    this.setState({
      search: text,
    })
  }

  navigateToHistoryList = (item) => {
    NavigationService.navigate('HistoryList', { item });
  }

  naviagateToInfoUser = () => {
    const { dataUser } = this.props;
    NavigationService.navigate('InforUser', { dataUser });
  }

  renderHeader = () => (
    <View style={styles.search_contain} >
      <View style={styles.icon_flex}>
        <AntDesign name='search1' size={20} color='gray' />
      </View>
      <TextInput 
        style={styles.search_text}
        onChangeText={this.handleSearchText}
        placeholder='Searching'
      />
    </View>
  )

  render() {
    let { dataUser,listVehicle } = this.props;
    const searchData = this.handleSearch();
    return (
      <View style={styles.container}>
        <View style={styles.header}>
          <View style={{ flex: 1 }}>
            <View style={{ flex: 0.8, paddingLeft: 5, flexDirection: 'row', alignItems: 'center' }}>
              <TouchableOpacity style={styles.circle} onPress={this.naviagateToInfoUser}>
                <Image
                  source={{ uri: `data:image/png;base64,${dataUser.img_url}` }}
                  style={{ width: 60, height: 60, borderRadius: 60 / 2, borderWidth: 0.5 }}>
                </Image>
              </TouchableOpacity>
              <View style={styles.header_contain}>
                <Text style={styles.header_text}>{dataUser.first_name} {dataUser.last_name}</Text>
              </View>
            </View>
          </View>
        </View>

        <View style={styles.item_contain} >
          <FlatList
            // data={this.state.searchData === null ? this.state.dataOfCars : this.state.dataOfCars}
            data = {listVehicle}
            ListHeaderComponent={this.renderHeader}
            keyExtractor={(item, index) => index.toString()}
            renderItem={({ item }) =>
              (<CarItem item={item} onPress={this.navigateToHistoryList} id={item.id} />)
            }
          >
          </FlatList>
        </View>
      </View>
    );
  }

}
export default Home;