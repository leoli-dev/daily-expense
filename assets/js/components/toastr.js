const toastr = require('toastr');
toastr.options.positionClass = 'toast-bottom-right';
const ToastHelper = {
    displaySuccess: message => {
        toastr.success(message, 'Notification');
    },
    displayError: message => {
        toastr.error(message, 'Error');
    }
}

export default ToastHelper;
