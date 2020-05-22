export const entityModalHelper = (() => {
    const $entityModal = $('#entityModal');
    const $form = $entityModal.find('form');
    const $title = $entityModal.find('.modal-title');
    const $submitButton = $entityModal.find('[type="submit"]');

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
        showModalWithSpinner: function () {
            this.showSpinner();
            this.showModal();
        },
        freezeModal: () => $entityModal.find('button, input').prop('disabled', true),
        resumeModal: () => $entityModal.find('button, input').prop('disabled', false),
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
