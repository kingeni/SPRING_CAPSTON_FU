import { connect } from 'react-redux';
import {
  selectUser
} from '../reducers/user';
import Home from '../Components/Home';

const mapStateToProps = state => ({
  dataUser: selectUser(state),
});

export default connect(mapStateToProps)(Home);
