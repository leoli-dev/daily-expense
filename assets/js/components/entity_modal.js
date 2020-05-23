export const entityModalHelper = (() => {
    const $entityModal = $('#entityModal');
    const $form = $entityModal.find('form');
    const $title = $entityModal.find('.modal-title');
    const $submitButton = $entityModal.find('[type="submit"]');
    const $submitLoadingPlaceholder = $entityModal.find('#submitLoadingPlaceholder');

    return {
        getModal: () => $entityModal,
        showSpinner: () => {
            $entityModal.addClass('loading')
            $submitButton.prop('disabled', true);
        },
        hideSpinner: () => {
            $entityModal.removeClass('loading');
            $submitButton.prop('disabled', false);
        },
        showModal: () => $entityModal.modal('show'),
        hideModal: () => $entityModal.modal('hide'),
        showModalWithSpinner: function () {
            this.showSpinner();
            this.showModal();
        },
        freezeModal: () => {
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
        setTitle: title => $title.html(title),
    };
})();
