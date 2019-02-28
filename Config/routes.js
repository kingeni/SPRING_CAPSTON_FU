import { createStackNavigator, createSwitchNavigator, createAppContainer } from 'react-navigation';
import Login from '../Components/Login';
import Home from '../Components/Home';
import HistoryList from '../Components/HistoryList';
import CarDetail from '../Components/CarDetail';
const iTemStack = createStackNavigator(
    {
        Home,
        HistoryList,
        CarDetail
        
    },
    {
        initialRouteName: 'Home'
    }
);
const carDetailStack = createStackNavigator(
    {
        HistoryList,
        CarDetail
        
    },
    {
        initialRouteName: 'HistoryList'
    }
);

const LoginStack = createStackNavigator(
    {
        Login
    },
    {
        initialRouteName: 'Login',
        headerMode :'none'
    }
);

const totalStack = createSwitchNavigator(
    {
        LoginStack,
        iTemStack
    }
);
const App1 = createAppContainer(totalStack);
export default App1;