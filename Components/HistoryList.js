import React, { Component } from 'react';
import {
    View,
    StyleSheet,
    Image,
    Text,
    TextInput,
    FlatList,
    Alert,
    SectionList,
    ScrollView,
    Button
} from 'react-native';
import { ButtonGroup } from 'react-native-elements';
// import data from './HistoryDB';
import { AntDesign } from '@expo/vector-icons';
import styles from './Styles';
import HistoryItem from './HistoryItem';

let _headerComponet = ({ section }) =>
    (<View style={{ alignItems: 'flex-start', backgroundColor: '#d6d7da' }}>
        <Text style={{ fontSize: 30, }}>{section}</Text>
    </View>)

class HistoryList extends Component {
    constructor(props) {
        super();
        this.state = {
            selectedIndex: 0,
            data: [{
                data: [
                    {
                        time: '10: AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 PM',
                        station: '1',
                        weight: 100,
                        error: true
                    }
                ],
                title: '20-1-2012'
            },
            {
                data: [
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: true
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: false
                    },
                    {
                        time: '10:01 AM',
                        station: '1',
                        weight: 100,
                        error: true
                    }
                ],
                title: '19-1-2012'
            }],
            componentCrashed: false,
            rawData: null,

        }
        this.getData = null;
    }
    componentDidCatch(error, info) {
        console.log(error);
        console.log(info);
        console.log('_______DID CATCH____________');
        this.setState({ componentCrashed: true });
    }
    test = (data) => {
        var handle = [];
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            //Do something
            var createDate = item.created_at;
            var title = createDate.split(' ')[0];
            var time = createDate.split(' ')[1];
            var newData = {
                time: time,
                station_id: item.station_id,
                vehicle_weight: item.vehicle_weight,
                status: item.status
            };
            var subData = this.findData(title, handle);
            if (subData != null) {//trung
                subData.data.push(newData);
            } else {
                newItem = {
                    title: title,
                    data: [newData]
                };
                handle.push(newItem);
            };
        }
        return handle;
    }

    findData = (title, handle) => {
        for (var i = 0; i < handle.length; i++) {
            item = handle[i];
            if (item.title.toLowerCase().localeCompare(title.toLowerCase()) == 0) {
                return item;
            }
        }
        return null;
    }

    static navigationOptions = ({ navigation }) => {
        const { selectedIndex } = navigation.state.params;
        const buttons = ['all', 'error'];
        return {
            headerBackTitle: null,
            headerTitle: (
                <ButtonGroup
                    onPress={navigation.state.params.handleChangeIndex}
                    selectedIndex={selectedIndex === undefined ? 0 : selectedIndex}
                    buttons={buttons}
                    containerBorderRadius={1}
                    containerStyle={{ width: 170, height: 35 }}
                    buttonStyle={{ backgroundColor: 'white' }}
                    selectedButtonStyle={{ backgroundColor: '#0068ff' }}
                    textStyle={{ color: '#0068ff' }}
                    selectedTextStyle={{ color: 'white' }}
                />
            ),
            headerRight: (<AntDesign name='infocirlceo'
                size={25} color='gray'
                style={{ paddingRight: 5 }}
                onPress={() => navigation.state.params.showInfor()} />),
        };
    };

    _handleChangeIndex = (selectedIndex) => {
        let subData = [];
        if (selectedIndex === 1) {
            for (let i = 0; i < data.length; i++) {
                let title = data[i].title;
                let filterData = data[i].data.filter((item) => item.error === true);
                subData.push({
                    title,
                    data: filterData
                });
            }
        }
        this.setState({
            selectedIndex,
            data: subData
        });
        this.props.navigation.setParams({
            selectedIndex
        });
    }
    _showInfor = () => {
        let { item } = this.props.navigation.state.params;
        this.props.navigation.navigate('CarDetail', { item });
    }
    getHistory = () => {
        fetch('http://vwms.gourl.pro/api/transaction/get-transactions?vehicleId=' + this.props.navigation.state.params.item.id)
            .then((response) => response.json())
            .then((responseJSON) => {
                this.setState({ rawData: responseJSON })
            })
            .catch((error) => {
                console.log(error);
            })
    }
    // async getHistory() {
    //     try {
    //         let response = await fetch(
    //             'http://vwms.gourl.pro/api/transaction/get-transactions?vehicleId=' + this.props.navigation.state.params.item.id
    //         );
    //         let responseJson = await response.json();
    //         return responseJson;
    //     } catch (error) {
    //         console.error(error);
    //     }
    // }
    componentDidMount() {
        fetch('http://vwms.gourl.pro/api/transaction/get-transactions?vehicleId=' + this.props.navigation.state.params.item.id)
            .then((response) => response.json())
            .then((responseJSON) => {
                this.setState({ rawData: responseJSON })
            })
            .catch((error) => {
                console.log(error);
            })



        let { selectedIndex, rawData } = this.state;
        this.props.navigation.setParams({
            handleChangeIndex: (index) => this._handleChangeIndex(index),
            showInfor: () => this._showInfor(),
            selectedIndex
        });
    }

    render() {
        console.log('aaa', this.state.rawData);
        return (
            <ScrollView contentContainerStyle={styles.container1} >
                <SectionList
                    sections={this.state.selectedIndex === 0 ? this.state.data : this.state.data}
                    renderSectionHeader={({ section: { title } }) =>
                        (<_headerComponet section={title} />)}

                    keyExtractor={(item, index) => index.toString()}
                    renderItem={(props) =>
                        (<HistoryItem item={props.item} id={props.index} />)
                    }

                    stickySectionHeadersEnabled={true}
                >
                </SectionList>
            </ScrollView>
        );
    }
}


export default HistoryList;