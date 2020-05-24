import { entityModalHelper } from '@js/components/entity_modal';

$('document').ready(() => {
    const $dataTable = $('.data-table');
    const dataTableObject = $dataTable.DataTable()
    const $entityModal = entityModalHelper.getModal();
    const $inputId = $entityModal.find('[name="id"]');
    const $inputName = $entityModal.find('[name="name"]');
    const $inputCode = $entityModal.find('[name="code"]');
    const $inputSymbol = $entityModal.find('[name="symbol"]');
    const setupFormFields = ({id, name, code, symbol}) => {
        $inputId.val(id);
        $inputName.val(name);
        $inputCode.val(code);
        $inputSymbol.val(symbol);
    };
    const getFormFieldsData = () => {
        return {
            id: '' === $inputId.val() ? null : parseInt($inputId.val()),
            name: $inputName.val(),
            code: $inputCode.val(),
            symbol: $inputSymbol.val(),
        };
    }
    const editModalSubmitCallback = id => {
        return () => {
            entityModalHelper.freezeModal();
            const data = getFormFieldsData();
            $.ajax({
                url: Routing.generate('app_api_update_currency', {id}),
                method: 'PUT',
                data: JSON.stringify(data),
            }).done(() => {
                const $row = $dataTable.find(`tr[data-entity-id="${id}"]`);
                $row.find('.cell-currency-name').html(data.name);
                $row.find('.cell-currency-code').html(data.code);
                $row.find('.cell-currency-symbol').html(data.symbol);
                entityModalHelper.hideModal();
            }).fail((jqxhr, textStatus, error) => {
                if (400 !== jqxhr.status) {
                    console.error({
                        jqxhr,
                        textStatus,
                        error,
                    });
                }
                entityModalHelper.handleErrorResponse(jqxhr.responseJSON);
            }).always(() => {
                entityModalHelper.resumeModal();
            });
        }
    }

    $('.dataTable').on(
        'click',
        'tr > td > button.btn-show-edit-modal',
        e => {
            const $button = $(e.target);
            const $row = $button.parents('tr');
            const id = $row.data('entity-id');
            entityModalHelper.setTitle('Edit Currency');
            entityModalHelper.showModalWithSpinner();
            $.getJSON(Routing.generate('app_api_get_currency', {id}), data => {
                setupFormFields(data.currency);
                entityModalHelper.hideSpinner();
                entityModalHelper.setupFormSubmit(editModalSubmitCallback(id));
            }).fail((jqxhr, textStatus, error) => {
                console.error({
                    jqxhr,
                    textStatus,
                    error,
                });
            });
        }
    )
});
