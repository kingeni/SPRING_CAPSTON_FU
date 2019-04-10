import { connect } from 'react-redux';
import { 
    getUser,
    actions,
    getError,
    getUserStatus
} from '../reducers/user';
import EditInforUser from '../Components/EditInforUser';

const mapStateToProps = state => ({
    dataUser : getUser(state),
    isLoadingStatus : getUserStatus(state),
    errorMsg : getError(state),
});
const mapDispatchToProps = {
    updateInfo: actions.updateUserInfo,
}
export default connect(mapStateToProps,mapDispatchToProps)(EditInforUser);