import { connect } from 'react-redux';
import { getUser , } from '../reducers/user';
import { actions as AuthActions } from '../reducers/auth';
import InforUser from '../Components/InforUser';
const mapStateToProps = state => ({
    dataUser: getUser(state),
});
const mapDispatchToProps = {
    logout : AuthActions.logout,
}
export default connect(mapStateToProps,mapDispatchToProps)(InforUser);