import { connect } from 'react-redux';
import {
    getOneDetail
} from '../reducers/vehicle';
import {
    getListImage,
    action,
    getIsLoading,
} from '../reducers/image';
import CarDetail from '../Components/CarDetail';
const mapStateToProps = state => ({
    getDetailVehicle: getOneDetail(state),
    getListImage: getListImage(state),
    isLoading : getIsLoading(state),
});
const mapDispatchToProps = {
    startListImage: action.startListImage,
}
export default connect(mapStateToProps,mapDispatchToProps)(CarDetail);