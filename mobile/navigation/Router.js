import { createStackNavigator, createAppContainer, createSwitchNavigator } from 'react-navigation';
import CarDetail from '../screens/CarDetail';
import HistoryList from '../screens/HistoryList';
import Home from '../screens/Home';
import Login from '../screens/Login';
import InforUser from '../screens/InforUser';
import EditInforUser from '../Components/EditInforUser';
import ChangePassword from '../screens/ChangePassword';
const IndexStack = createStackNavigator(
    {
        Home,
        HistoryList,
        CarDetail
    });

const Infro = createStackNavigator(
    {

        InforUser,
        EditInforUser,
        ChangePassword,
    }
);

const LogOut = createSwitchNavigator({
    InforUser,
    Login
},
    // {
    //     initialRouteName: 'InforUser'
    // }
);

const homeScreen = createStackNavigator(
    {
        IndexStack,
        Infro,
    },
    {
        mode: 'modal',
        headerMode: 'none'
    }
);
const mainScreen = createSwitchNavigator(
    {
        Login,
        homeScreen,
        LogOut
    },
    {
        initialRouteName: 'Login',
    });

const Router = createAppContainer(mainScreen);
export default Router;