import { connect } from 'react-redux';
import {
  getUser
} from '../reducers/user';
import {
  getListVehicle,
  getVehiStatus,
  getError,
} from '../reducers/vehicle';
import {
  actions
} from '../reducers/transactions';
import Home from '../Components/Home';

const mapStateToProps = state => ({
  dataUser: getUser(state),
  listVehicle: getListVehicle(state),
  isLoading: getVehiStatus(state),
  errorMsg : getError(state),
});

const mapDispatchToState ={
  getStart: actions.startTransaction,
  getEnd: actions.stopTransaction,
  updateStatusReading: actions.updateStatusReading,
}
export default connect(mapStateToProps,mapDispatchToState)(Home);
