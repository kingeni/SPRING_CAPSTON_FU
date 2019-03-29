import { connect } from 'react-redux';
import { 
    selectUser,
    actions,
} from '../reducers/user';
import EditInforUser from '../Components/EditInforUser';

const mapStateToProps = state => ({
    dataUser : selectUser(state),
});
const mapDispatchToProps = {
    updateInfo: actions.updateUserInfo,
}
export default connect(mapStateToProps,mapDispatchToProps)(EditInforUser);