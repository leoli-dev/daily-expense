import ToastHelper from '@js/components/toastr';

const $modal = $('#entityModal');
const $form = $modal.find('form');
const $modalTitle = $modal.find('.modal-title');
const $modalBody = $modal.find('.modal-body');
const $generalError = $modalBody.find('p.text-danger');
const $submitButton = $modal.find('[type="submit"]');
const $submitLoadingPlaceholder = $modal.find('#submitLoadingPlaceholder');

export default {
    getModal: () => $modal,
    showSpinner: () => {
        $modalBody.addClass('loading')
        $submitButton.prop('disabled', true);
    },
    hideSpinner: () => {
        $modalBody.removeClass('loading');
        $submitButton.prop('disabled', false);
    },
    showModal: () => $modal.modal('show'),
    hideModal: () => $modal.modal('hide'),
    hideGeneralError: () => $generalError.removeClass('shown'),
    hideAllInvalidError: () => {
        $modalBody.find('.is-invalid').removeClass('is-invalid');
        $modalBody.find('label.text-danger').removeClass('text-danger');
    },
    showModalWithSpinner: function () {
        this.hideGeneralError();
        this.hideAllInvalidError();
        this.showSpinner();
        this.showModal();
    },
    freezeModal: function () {
        this.hideGeneralError();
        this.hideAllInvalidError();
        $modal.find('button, input').prop('disabled', true);
        $submitButton.hide();
        $submitLoadingPlaceholder.show();
    },
    resumeModal: () => {
        $modal.find('button, input').prop('disabled', false);
        $submitLoadingPlaceholder.hide();
        $submitButton.show();
    },
    setupFormFields: data => {
        for (const [name, value] of Object.entries(data)) {
            const $field = $modal.find(`[name="${name}"]`);
            if (!$field.length) {
                continue;
            }
            if ($field.is('input')) {
                $field.val(value);
            }
            // TODO: For other type of field, do something else
        }
    },
    setupFormSubmit: callback => {
        $form.unbind();
        $form.submit(e => {
            e.preventDefault();
            callback();
        });
    },
    setTitle: title => $modalTitle.html(title),
    showGeneralError: message => {
        $generalError.html(`Error: ${message}`);
        $generalError.addClass('shown');
    },
    showFieldsError: error => {
        for (const [name, message] of Object.entries(error)) {
            const $field = $modalBody.find(`[name="${name}"]`);
            if (!$field.length) {
                continue;
            }
            const $fieldLabel = $modalBody.find(`label[for="${$field.prop('id')}"]`);
            const $fieldError = $field.siblings('small.text-danger');
            $fieldLabel.addClass('text-danger');
            $fieldError.html(message);
            $field.addClass('is-invalid');
        }
    },
    handleErrorResponse: function (response) {
        if (undefined !== response.message) {
            this.showGeneralError(response.message);
        } else if (undefined !== response.error) {
            this.showFieldsError(response.error);
        } else {
            ToastHelper.displayError('Can not parse response!');
            console.error({
                log: 'Can not parse response',
                response,
            });
        }
    }
};
