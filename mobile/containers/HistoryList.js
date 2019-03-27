import {
    actions as TransActions,
    getVehicleID,
    getTransactions,
    getTransactionErr,
    isLoading,
} from '../reducers/transactions';
import { action as ImageActions } from '../reducers/image';
import HistoryList from '../Components/HistoryList';
import { connect } from 'react-redux';

const mapStateToProps = state => ({
    vehicleId: getVehicleID(state),
    dataTrans: getTransactions(state),
    dataTransErr: getTransactionErr(state),
    isLoading: isLoading(state),
});

const mapDispatchToProps = {
    getStart: TransActions.startTransaction,
    getEnd: TransActions.stopTransaction,
    getStartErr: TransActions.startTransactionErr,
    getStartImage: ImageActions.startListImage,
};

export default connect(mapStateToProps, mapDispatchToProps)(HistoryList);