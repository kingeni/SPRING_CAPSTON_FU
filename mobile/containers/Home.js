import { connect } from 'react-redux';
import {
  selectUser
} from '../reducers/user';
import {
  getListVehicle
} from '../reducers/vehicle';
import Home from '../Components/Home';

const mapStateToProps = state => ({
  dataUser: selectUser(state),
  listVehicle :getListVehicle(state),
});

export default connect(mapStateToProps)(Home);
