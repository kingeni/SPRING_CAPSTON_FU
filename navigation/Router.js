import { createStackNavigator, createAppContainer, createSwitchNavigator } from 'react-navigation';
import CarDetail from '../Components/CarDetail';
import HistoryList from '../Components/HistoryList';
import Home from '../Components/Home';
import Login from '../Components/Login';
import InforUser from '../Components/InforUser';
import EditInforUser from '../Components/EditInforUser';
import ChangePassword from '../Components/ChangePassword';
const loginStack = createStackNavigator(
    {
        Home,
        HistoryList,
        CarDetail
    }, {
        initialRouteName: 'Home',
    });

const Infro = createStackNavigator(
    {
        InforUser,
        EditInforUser,
        ChangePassword
    },
    {
        initialRouteName: 'InforUser'
    }
)

const LogOut = createSwitchNavigator({
    InforUser,
    Login
},
    {
        mode: 'card',
        initialRouteName: 'InforUser'
    });

const homeScreen = createStackNavigator(
    {
        loginStack,
        Infro,
        LogOut
    },
    {
        mode: 'modal',
        headerMode: 'none'
    }
);
const mainScreen = createSwitchNavigator(
    {
        Login,
        homeScreen
    },
    {
        initialRouteName: 'Login',
    });
const edit = createStackNavigator(
    {
        EditInforUser
    },
    {
        initialRouteName: 'EditInforUser'
    });
const Router = createAppContainer(mainScreen);
export default Router;