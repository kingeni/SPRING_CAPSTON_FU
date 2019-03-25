import { connect } from 'react-redux';
import { 
    selectUser
} from '../reducers/user';
import EditInforUser from '../Components/EditInforUser';

const mapStateToProps = state => ({
    dataUser : selectUser(state),
});
export default connect(mapStateToProps)(EditInforUser);