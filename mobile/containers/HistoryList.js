import {
    actions,
    getVehicleID,
    getTransactions,
    getTransactionErr,
} from '../reducers/transactions';
import HistoryList from '../Components/HistoryList';
import { connect } from 'react-redux';

const mapStateToProps = state => ({
    vehicleId: getVehicleID(state),
    dataTrans: getTransactions(state),
    dataTransErr: getTransactionErr(state),
});

const mapDispatchToProps = {
    getStart: actions.startTransaction,
    getEnd: actions.stopTransaction,
    getStartErr: actions.startTransactionErr,
};

export default connect(mapStateToProps, mapDispatchToProps)(HistoryList);