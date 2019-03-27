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
    Button,
    ActivityIndicator,
} from 'react-native';
import { ButtonGroup } from 'react-native-elements';
import FormData from 'FormData';
import { AntDesign } from '@expo/vector-icons';
import styles from '../Components/Styles';
import HistoryItem from '../Components/HistoryItem';

let _headerComponet = ({ section }) =>
    (<View style={{ alignItems: 'flex-start', backgroundColor: '#d6d7da' }}>
        <Text style={{ fontSize: 30, }}>{section}</Text>
    </View>)

class HistoryList extends Component {
    constructor(props) {
        super();
        this.state = {
            selectedIndex: 0,
        }
    }

    static navigationOptions = ({ navigation }) => {
        const { selectedIndex } = navigation.state.params;
        const buttons = ['all', 'overWeight'];
        return {
            headerBackTitle: null,
            headerTitle: (
                <ButtonGroup
                    onPress={navigation.state.params.handleChangeIndex}
                    selectedIndex={selectedIndex === undefined ? 0 : selectedIndex}
                    buttons={buttons}
                    containerBorderRadius={1}
                    containerStyle={{ width: 180, height: 35 }}
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
            headerLeft: <Button
                title='Cancel'
                onPress={() => {
                    navigation.state.params.getEnd();
                    return navigation.goBack();
                }}></Button>,
            headerStyle: {
                borderBottomWidth: 0,
                backgroundColor: '#d6d7da',
            },
        };
    };

    _handleChangeIndex = (selectedIndex) => {
        let { getEnd, getStart, getStartErr, vehicleId, dataTransErr } = this.props;
        if (selectedIndex === 1) {
            getEnd();
            getStartErr(vehicleId);
        }

        if (selectedIndex === 0) {
            getEnd();
            getStart(vehicleId, true);
        }

        this.setState({
            selectedIndex,
        });

        this.props.navigation.setParams({
            selectedIndex
        });
    }

    _showInfor = () => {
        let { item } = this.props.navigation.state.params;
        const { getStartImage, vehicleId } = this.props;
        this.props.navigation.navigate('CarDetail', { item });
        getStartImage(vehicleId);
    }

    componentDidMount() {
        let { selectedIndex } = this.state;

        this.props.navigation.setParams({
            handleChangeIndex: (index) => this._handleChangeIndex(index),
            showInfor: () => this._showInfor(),
            selectedIndex,
            getEnd: () => this.props.getEnd(),
        });
    }

    render() {
        const { dataTrans, dataTransErr, isLoading } = this.props;

        return (

            <ScrollView contentContainerStyle={styles.container1} >
                {isLoading ?

                    <SectionList
                        sections={this.state.selectedIndex === 0 ? dataTrans : dataTransErr}

                        renderSectionHeader={({ section: { title } }) => {
                            return (<_headerComponet section={title} />);
                        }}

                        keyExtractor={(item, index) => index.toString()}
                        renderItem={(props) =>
                            (<HistoryItem item={props.item} id={props.index} />)
                        }

                        stickySectionHeadersEnabled={true}
                    >
                    </SectionList>
                    :
                    <View style={{marginTop: 5}}><ActivityIndicator size="large" color="white" /></View>
                }
            </ScrollView>

        );
    }
}


export default HistoryList;