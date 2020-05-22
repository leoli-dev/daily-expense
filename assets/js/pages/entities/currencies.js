import { entityModalHelper } from '@js/components/entity_modal';

$('document').ready(() => {
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

    $('.dataTable').on(
        'click',
        'tr > td > button.btn-edit-model-toggle',
        e => {
            const $button = $(e.target);
            const $row = $button.parents('tr');
            const entityId = $row.data('entity-id');

            entityModalHelper.setTitle('Edit Currency');
            entityModalHelper.showModalWithSpinner();

            const apiGetCurrency = Routing.generate('app_api_get_currency', {id: entityId});
            $.getJSON(apiGetCurrency, data => {
                setupFormFields(data.currency);
                entityModalHelper.hideSpinner();
                entityModalHelper.setupFormSubmit(() => {
                    const data = getFormFieldsData();

                    // TODO: add submit code
                    console.log({data});
                });
            }).fail((jqxhr, textStatus, error) => {
                console.error({
                    jqxhr,
                    textStatus,
                    error,
                })
            });
        }
    )
});
