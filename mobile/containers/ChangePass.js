import { connect } from 'react-redux';
import {
    actions,
    getError,
    getUserStatus,
} from '../reducers/user';
import ChangePassword from '../Components/ChangePassword';
const mapStateToProps = state => ({
    errorMsg: getError(state),
    isLoading: getUserStatus(state),
});
const mapDispatchToProps = {
    updatePassword: actions.updatePassword,
};
export default connect(mapStateToProps, mapDispatchToProps)(ChangePassword);