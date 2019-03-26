import { connect } from 'react-redux';
import {
  selectUser
} from '../reducers/user';
import {
  getListVehicle
} from '../reducers/vehicle';
import {
  actions
} from '../reducers/transactions';
import Home from '../Components/Home';

const mapStateToProps = state => ({
  dataUser: selectUser(state),
  listVehicle: getListVehicle(state),
});

const mapDispatchToState ={
  getStart: actions.startTransaction,
  getEnd: actions.stopTransaction,
}
export default connect(mapStateToProps,mapDispatchToState)(Home);
