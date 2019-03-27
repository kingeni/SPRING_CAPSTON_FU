import { connect } from 'react-redux';
import { selectUser , } from '../reducers/user';
import { actions as AuthActions } from '../reducers/auth';
import InforUser from '../Components/InforUser';
const mapStateToProps = state => ({
    dataUser: selectUser(state),
});
const mapDispatchToProps = {
    logout : AuthActions.logout,
}
export default connect(mapStateToProps,mapDispatchToProps)(InforUser);