const $modal = $('#removalModal');
const $modalTitle = $modal.find('.modal-title');
const $modalBody = $modal.find('.modal-body');
const $btnConfirm = $modal.find('.btn-confirm');
const $btnPlaceholder = $modal.find('.btn-placeholder');

export default {
    getModal: () => $modal,
    showModal: () => $modal.modal('show'),
    hideModal: () => $modal.modal('hide'),
    setTitle: title => $modalTitle.html(title),
    setContent: content => $modalBody.find('b').html(content),
    setupConfirm: callback => {
        $btnConfirm.unbind();
        $btnConfirm.click(callback);
    },
    showSpinner: () => {
        $modalBody.addClass('loading')
        $btnConfirm.prop('disabled', true);
    },
    hideSpinner: () => {
        $modalBody.removeClass('loading');
        $btnConfirm.prop('disabled', false);
    },
    showModalWithSpinner: function () {
        this.showSpinner();
        this.showModal();
    },
    freezeModal: function () {
        $modal.find('button, input').prop('disabled', true);
        $btnConfirm.hide();
        $btnPlaceholder.show();
    },
    resumeModal: () => {
        $modal.find('button, input').prop('disabled', false);
        $btnPlaceholder.hide();
        $btnConfirm.show();
    },
};
