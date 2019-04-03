import { connect } from 'react-redux';
import { 
    getUser,
    actions,
    getError,
    getStatus
} from '../reducers/user';
import EditInforUser from '../Components/EditInforUser';

const mapStateToProps = state => ({
    dataUser : getUser(state),
    isLoadingStatus : getStatus(state),
    errorMsg : getError(state),
});
const mapDispatchToProps = {
    updateInfo: actions.updateUserInfo,
}
export default connect(mapStateToProps,mapDispatchToProps)(EditInforUser);