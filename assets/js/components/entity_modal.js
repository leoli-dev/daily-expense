export const entityModalHelper = (() => {
    const $entityModal = $('#entityModal');
    const $form = $entityModal.find('form');
    const $modalTitle = $entityModal.find('.modal-title');
    const $modalBody = $entityModal.find('.modal-body');
    const $generalError = $modalBody.find('p.text-danger');
    const $submitButton = $entityModal.find('[type="submit"]');
    const $submitLoadingPlaceholder = $entityModal.find('#submitLoadingPlaceholder');

    return {
        getModal: () => $entityModal,
        showSpinner: () => {
            $modalBody.addClass('loading')
            $submitButton.prop('disabled', true);
        },
        hideSpinner: () => {
            $modalBody.removeClass('loading');
            $submitButton.prop('disabled', false);
        },
        showModal: () => $entityModal.modal('show'),
        hideModal: () => $entityModal.modal('hide'),
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
            $entityModal.find('button, input').prop('disabled', true);
            $submitButton.hide();
            $submitLoadingPlaceholder.show();
        },
        resumeModal: () => {
            $entityModal.find('button, input').prop('disabled', false);
            $submitLoadingPlaceholder.hide();
            $submitButton.show();
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
                console.error({
                    log: 'Can not parser response',
                    response,
                });
            }
        }
    };
})();
