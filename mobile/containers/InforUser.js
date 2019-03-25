import { connect } from 'react-redux';
import { selectUser } from '../reducers/user';
import InforUser from '../Components/InforUser';
const mapStateToProps = state => ({
    dataUser: selectUser(state),
});

export default connect(mapStateToProps)(InforUser);