import { entityModalHelper } from '@js/components/entity_modal';
import ToastHelper from '@js/components/toastr';

$('document').ready(() => {
    const $dataTable = $('.data-table');
    const dataTableObject = $dataTable.DataTable()
    const $entityModal = entityModalHelper.getModal();
    const $inputId = $entityModal.find('[name="id"]');
    const $inputName = $entityModal.find('[name="name"]');
    const $inputCode = $entityModal.find('[name="code"]');
    const $inputSymbol = $entityModal.find('[name="symbol"]');
    const $btnShotAddModal = $('.btn-show-add-modal');
    const getActionsTemplate = id => {
        return `
            <button class="btn btn-primary btn-icon-split btn-show-edit-modal"
                    data-entity-id="${id}">
                <span class="icon text-white-50">
                    <i class="fas fa-edit"></i>
                </span>
                <span class="text">Edit</span>
            </button>
            <button class="btn btn-danger btn-icon-split btn-show-delete-modal"
                    data-entity-id="${id}">
                <span class="icon text-white-50">
                    <i class="fas fa-ban"></i>
                </span>
                <span class="text">Delete</span>
            </button>`;
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
                const $editButton = $dataTable.find(`button.btn-show-edit-modal[data-entity-id="${id}"]`);
                const $row = $editButton.parents('tr');
                const $cells = $row.find('td');
                $cells.eq(0).html(data.name);
                $cells.eq(1).html(data.code);
                $cells.eq(2).html(data.symbol);
                entityModalHelper.hideModal();
                ToastHelper.displaySuccess(`Currency "${data.name}" has been updated!`);
            }).fail((jqxhr, textStatus, error) => {
                console.error({
                    jqxhr,
                    textStatus,
                    error,
                });
                entityModalHelper.handleErrorResponse(jqxhr.responseJSON);
            }).always(() => {
                entityModalHelper.resumeModal();
            });
        }
    }

    const addModalSubmitCallback = () => {
        entityModalHelper.freezeModal();
        const data = getFormFieldsData();
        $.ajax({
            url: Routing.generate('app_api_add_currency'),
            method: 'POST',
            data: JSON.stringify(data),
        }).done(data => {
            const currency = data.currency;
            const rowNode = dataTableObject.row.add([
                currency.name,
                currency.code,
                currency.symbol,
                getActionsTemplate(currency.id),
            ]).draw(false).node();
            const $row = $(rowNode);
            const $cells = $row.find('td');
            $cells.eq(3).addClass('text-center');
            entityModalHelper.hideModal();
            ToastHelper.displaySuccess(`Currency "${data.name}" has been create!`);
        }).fail((jqxhr, textStatus, error) => {
            console.error({
                jqxhr,
                textStatus,
                error,
            });
            entityModalHelper.handleErrorResponse(jqxhr.responseJSON);
        }).always(() => {
            entityModalHelper.resumeModal();
        });
    }

    $('.dataTable').on(
        'click',
        'tr > td > button.btn-show-edit-modal',
        e => {
            let $button = $(e.target);
            $button = $button.is('button') ? $button : $button.parents('button');
            const id = $button.data('entity-id');
            entityModalHelper.setTitle('Edit Currency');
            entityModalHelper.showModalWithSpinner();
            $.getJSON(Routing.generate('app_api_get_currency', {id}), data => {
                entityModalHelper.setupFormFields(data.currency);
                entityModalHelper.hideSpinner();
                entityModalHelper.setupFormSubmit(editModalSubmitCallback(id));
            }).fail((jqxhr, textStatus, error) => {
                console.error({
                    jqxhr,
                    textStatus,
                    error,
                });
                ToastHelper.displayError('Can not fetch currency data!');
            });
        }
    );

    $btnShotAddModal.click(() => {
        entityModalHelper.setTitle('Add Currency');
        entityModalHelper.setupFormFields({
            id: '',
            name: '',
            code: '',
            symbol: '',
        });
        entityModalHelper.showModal();
        entityModalHelper.setupFormSubmit(addModalSubmitCallback);
    });
});
