import EntityModalHelper from '@js/components/entity_modal';
import RemovalModalHelper from '@js/components/removal_modal';
import ToastHelper from '@js/components/toastr';
import generateActionButtons from "@js/components/action_buttons";

$('document').ready(() => {
    const $dataTable = $('.data-table');
    const dataTableObject = $dataTable.DataTable()
    const $entityModal = EntityModalHelper.getModal();
    const $inputId = $entityModal.find('[name="id"]');
    const $inputName = $entityModal.find('[name="name"]');
    const $selectCurrency = $entityModal.find('[name="currency"]');
    const $btnShowAddModal = $('.btn-show-add-modal');

    const getFormFieldsData = () => {
        return {
            id: '' === $inputId.val() ? null : parseInt($inputId.val()),
            name: $inputName.val(),
            currency: $selectCurrency.val(),
        };
    }

    const addModalSubmitCallback = () => {
        EntityModalHelper.freezeModal();
        const data = getFormFieldsData();
        $.ajax({
            url: Routing.generate('app_api_add_account'),
            method: 'POST',
            data: JSON.stringify(data),
        }).done(data => {
            const account = data.account;
            const currency = account.currency;
            const rowNode = dataTableObject.row.add([
                account.name,
                `${currency.name} (${currency.symbol})`,
                generateActionButtons(account.id),
            ]).draw(false).node();
            const $row = $(rowNode);
            const $cells = $row.find('td');
            $cells.eq(2).addClass('text-center');
            EntityModalHelper.hideModal();
            ToastHelper.displaySuccess(`Account "${data.name}" has been created!`);
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

    const editModalSubmitCallback = id => {
        return () => {
            EntityModalHelper.freezeModal();
            const data = getFormFieldsData();
            $.ajax({
                url: Routing.generate('app_api_update_account', {id}),
                method: 'PUT',
                data: JSON.stringify(data),
            }).done(() => {
                const $editButton = $dataTable.find(`button.btn-show-edit-modal[data-entity-id="${id}"]`);
                const $row = $editButton.parents('tr');
                const $cells = $row.find('td');
                $cells.eq(0).html(`${data.name}`);
                $cells.eq(1).html($selectCurrency.find(`[value="${data.currency}"]`).html());
                EntityModalHelper.hideModal();
                ToastHelper.displaySuccess(`Account "${data.name}" has been updated!`);
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

    const deleteModalConfirmCallback = id => {
        return () => {
            RemovalModalHelper.freezeModal();
            $.ajax({
                url: Routing.generate('app_api_delete_account', {id}),
                method: 'DELETE',
            }).done(() => {
                const $btnDelete = $(`.btn-show-delete-modal[data-entity-id="${id}"]`);
                const $row = $btnDelete.parents('tr');
                dataTableObject.row($row).remove().draw();
                ToastHelper.displaySuccess(`Account has been deleted!`);
            }).fail((jqxhr, textStatus, error) => {
                console.error({
                    jqxhr,
                    textStatus,
                    error,
                });
                const message = undefined !== jqxhr.responseJSON.message
                    ? jqxhr.responseJSON.message
                    : 'Can not remove account!';
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
                EntityModalHelper.setTitle('Edit Account');
                EntityModalHelper.showModalWithSpinner();
                $.getJSON(Routing.generate('app_api_get_account', {id}), data => {
                    EntityModalHelper.setupFormFields(data.account);
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
                RemovalModalHelper.setTitle('Delete Account');
                RemovalModalHelper.showModalWithSpinner();
                $.getJSON(Routing.generate('app_api_get_account', {id}), data => {
                    RemovalModalHelper.setContent(`Are you sure to remove Account "${data.account.name}"?`);
                    RemovalModalHelper.hideSpinner();
                    RemovalModalHelper.setupConfirm(deleteModalConfirmCallback(id));
                }).fail((jqxhr, textStatus, error) => {
                    console.error({
                        jqxhr,
                        textStatus,
                        error,
                    });
                    ToastHelper.displayError('Can not fetch account data!');
                });
            }
        )
    ;

    $btnShowAddModal.click(() => {
        EntityModalHelper.setTitle('Add Currency');
        EntityModalHelper.setupFormFields({
            id: '',
            name: '',
            currency: '',
        });
        EntityModalHelper.showModal();
        EntityModalHelper.setupFormSubmit(addModalSubmitCallback);
    });
});
