import { connect } from 'react-redux';
import {
  selectUser
} from '../reducers/user';
import {
  getListVehicle,
  isLoading,
} from '../reducers/vehicle';
import {
  actions
} from '../reducers/transactions';
import Home from '../Components/Home';

const mapStateToProps = state => ({
  dataUser: selectUser(state),
  listVehicle: getListVehicle(state),
  isLoading: isLoading(state),
});

const mapDispatchToState ={
  getStart: actions.startTransaction,
  getEnd: actions.stopTransaction,
  updateStatusReading: actions.updateStatusReading,
}
export default connect(mapStateToProps,mapDispatchToState)(Home);
