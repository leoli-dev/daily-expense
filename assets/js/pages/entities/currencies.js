import EntityModalHelper from '@js/components/entity_modal';
import RemovalModalHelper from '@js/components/removal_modal';
import generateActionButtons from '@js/components/action_buttons';
import ToastHelper from '@js/components/toastr';

$('document').ready(() => {
    const $dataTable = $('.data-table');
    const dataTableObject = $dataTable.DataTable()
    const $entityModal = EntityModalHelper.getModal();
    const $inputId = $entityModal.find('[name="id"]');
    const $inputName = $entityModal.find('[name="name"]');
    const $inputCode = $entityModal.find('[name="code"]');
    const $inputSymbol = $entityModal.find('[name="symbol"]');
    const $btnShowAddModal = $('.btn-show-add-modal');

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
            EntityModalHelper.freezeModal();
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
                EntityModalHelper.hideModal();
                ToastHelper.displaySuccess(`Currency "${data.name}" has been updated!`);
            }).fail((jqxhr, textStatus, error) => {
                console.error({
                    jqxhr,
                    textStatus,
                    error,
                });
                EntityModalHelper.handleErrorResponse(jqxhr.responseJSON);
            }).always(() => {
                EntityModalHelper.resumeModal();
            });
        }
    }

    const addModalSubmitCallback = () => {
        EntityModalHelper.freezeModal();
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
                generateActionButtons(currency.id),
            ]).draw(false).node();
            const $row = $(rowNode);
            const $cells = $row.find('td');
            $cells.eq(3).addClass('text-center');
            EntityModalHelper.hideModal();
            ToastHelper.displaySuccess(`Currency "${data.name}" has been created!`);
        }).fail((jqxhr, textStatus, error) => {
            console.error({
                jqxhr,
                textStatus,
                error,
            });
            EntityModalHelper.handleErrorResponse(jqxhr.responseJSON);
        }).always(() => {
            EntityModalHelper.resumeModal();
        });
    };

    const deleteModalConfirmCallback = id => {
        return () => {
            RemovalModalHelper.freezeModal();
            $.ajax({
                url: Routing.generate('app_api_delete_currency', {id}),
                method: 'DELETE',
            }).done(() => {
                const $btnDelete = $(`.btn-show-delete-modal[data-entity-id="${id}"]`);
                const $row = $btnDelete.parents('tr');
                dataTableObject.row($row).remove().draw();
                ToastHelper.displaySuccess(`Currency has been deleted!`);
            }).fail((jqxhr, textStatus, error) => {
                console.error({
                    jqxhr,
                    textStatus,
                    error,
                });
                const message = undefined !== jqxhr.responseJSON.message
                    ? jqxhr.responseJSON.message
                    : 'Can not remove currency!';
                ToastHelper.displayError(message);
            }).always(() => {
                RemovalModalHelper.resumeModal();
                RemovalModalHelper.hideModal();
            });
        }
    };

    $('.dataTable')
        .on(
            'click',
            'tr > td > button.btn-show-edit-modal',
            e => {
                let $button = $(e.target);
                $button = $button.is('button') ? $button : $button.parents('button');
                const id = $button.data('entity-id');
                EntityModalHelper.setTitle('Edit Currency');
                EntityModalHelper.showModalWithSpinner();
                $.getJSON(Routing.generate('app_api_get_currency', {id}), data => {
                    EntityModalHelper.setupFormFields(data.currency);
                    EntityModalHelper.hideSpinner();
                    EntityModalHelper.setupFormSubmit(editModalSubmitCallback(id));
                }).fail((jqxhr, textStatus, error) => {
                    console.error({
                        jqxhr,
                        textStatus,
                        error,
                    });
                    ToastHelper.displayError('Can not fetch currency data!');
                });
            }
        )
        .on(
            'click',
            'tr > td > button.btn-show-delete-modal',
            e => {
                let $button = $(e.target);
                $button = $button.is('button') ? $button : $button.parents('button');
                const id = $button.data('entity-id');
                RemovalModalHelper.setTitle('Delete Currency');
                RemovalModalHelper.showModalWithSpinner();
                $.getJSON(Routing.generate('app_api_get_currency', {id}), data => {
                    RemovalModalHelper.setContent(`Are you sure to remove Currency "${data.currency.name}"?`);
                    RemovalModalHelper.hideSpinner();
                    RemovalModalHelper.setupConfirm(deleteModalConfirmCallback(id));
                }).fail((jqxhr, textStatus, error) => {
                    console.error({
                        jqxhr,
                        textStatus,
                        error,
                    });
                    ToastHelper.displayError('Can not fetch currency data!');
                });
            }
        )
    ;

    $btnShowAddModal.click(() => {
        EntityModalHelper.setTitle('Add Currency');
        EntityModalHelper.setupFormFields({
            id: '',
            name: '',
            code: '',
            symbol: '',
        });
        EntityModalHelper.showModal();
        EntityModalHelper.setupFormSubmit(addModalSubmitCallback);
    });
});
