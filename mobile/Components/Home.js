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
  ActivityIndicator,
} from 'react-native';
import styles from '../Components/Styles';
import { AntDesign } from '@expo/vector-icons';
import CarItem from '../Components/CarItem';
import NavigationService from '../common/NavigationService';
import dataDB from '../dataDB';
class Home extends Component {
  constructor(props) {
    super();
    this.state = {
      search: '',
      searchData: null,
    }
  }

  static navigationOptions = {
    header: null
  };

  handleSearch = () => {
    const { search } = this.state;
    const { listVehicle } = this.props;
    if (listVehicle !== null) {
      const searchData = listVehicle.filter(date => date.name.includes(search));
      return searchData;
    }

  }

  handleSearchText = (text) => {
    this.setState({
      search: text,
    });
  }

  navigateToHistoryList = (item) => {
    const { getStart, updateStatusReading } = this.props;
    NavigationService.navigate('HistoryList', { item: item.id });
    getStart(item.id, false);
    updateStatusReading(item.id);
  }

  naviagateToInfoUser = () => {
    NavigationService.navigate('InforUser');
  }

  renderHeader = () => (
    <View style={styles.search_contain} >
      <View style={styles.icon_flex}>
        <AntDesign name='search1' size={20} color='blue' />
      </View>
      <TextInput
        style={styles.search_text}
        onChangeText={this.handleSearchText}
        placeholder='Searching'
      />
    </View>
  )

  render() {
    let { dataUser, listVehicle, isLoading } = this.props;
    const searchData = this.handleSearch();
    // listVehicle.map(({ img, ...rest }) => rest);
    console.log('dataget:',listVehicle);
    return (
      <View style={styles.container}>
        <View style={styles.header}>
          <View style={{ flex: 1, backgroundColor: '#d6d7da', paddingTop: 12 }}>
            <View style={{ flex: 0.8, paddingLeft: 5, flexDirection: 'row', alignItems: 'center', backgroundColor: '#d6d7da' }}>
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
          {(listVehicle !== null) && (listVehicle.length > 0) ?
            <FlatList
              // data={searchData === null ? listVehicle : searchData}
              data={listVehicle}
              ListHeaderComponent={this.renderHeader}
              keyExtractor={(item, index) => index.toString()}
              renderItem={({ item }) =>
                (<CarItem item={item} onPress={this.navigateToHistoryList} id={item.id} />)
              }
            >
            </FlatList> : <ActivityIndicator size="large" color="blue" />
          }
        </View>

      </View>
    );
  }

}
export default Home;