import { StyleSheet } from 'react-native';

const styles = StyleSheet.create({
    container: {
        flex: 1,
        alignItems: 'stretch',
        backgroundColor:'#d6d7da',
        marginTop: 5
    },
    container1: {
        flex: 1,
        marginLeft: 10,
        marginRight: 10,
        marginBottom: 20,
        alignItems: 'stretch'
    },
    circle: {
        height: 60,
        flex: 20
    },
    header: {
        flexDirection: 'row',
        flex: 12,
        alignItems: 'center',

        backgroundColor: 'white'
    },
    header_contain: {
        flex: 80,
        height: 60,
        justifyContent: 'center'
    },
    header_text: {
        fontSize: 20,
        fontWeight: 'bold',


    },
    search_contain: {
        flexDirection: 'row',
        borderRadius: 12,
        backgroundColor: 'white',
        borderWidth: 0.5,
        borderColor: '#d6d7da',
        height: 40,
        alignItems: 'center'
    },
    item_contain: {
        flex: 88,
        marginTop: 2,

        // backgroundColor: '#d6d7da'
    },
    search_text: {
        fontSize: 20,
        flex: 90,
        borderColor: 'white'
    },
    icon_flex: {
        flex: 10,
        paddingLeft: 5
    },
    flex_row: {
        flexDirection: 'row',
        borderBottomWidth: 0.5
    },
    flex_50: {
        flex: 50,
        fontSize: 15
    }
});
export default styles;