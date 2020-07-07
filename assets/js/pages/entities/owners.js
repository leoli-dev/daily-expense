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
    const $btnShowAddModal = $('.btn-show-add-modal');

    const getFormFieldsData = () => {
        return {
            id: '' === $inputId.val() ? null : parseInt($inputId.val()),
            name: $inputName.val(),
            icon: $entityModal.find('input[name="icon"]:checked').val(),
        };
    }

    const editModalSubmitCallback = id => {
        return () => {
            EntityModalHelper.freezeModal();
            const data = getFormFieldsData();
            $.ajax({
                url: Routing.generate('app_api_update_owner', {id}),
                method: 'PUT',
                data: JSON.stringify(data),
            }).done(() => {
                const $editButton = $dataTable.find(`button.btn-show-edit-modal[data-entity-id="${id}"]`);
                const $row = $editButton.parents('tr');
                const $cells = $row.find('td');
                $cells.eq(0).html(data.name);
                $cells.eq(1).html(`<i class="fas ${data.icon}"></i>`);
                EntityModalHelper.hideModal();
                ToastHelper.displaySuccess(`Owner "${data.name}" has been updated!`);
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
            url: Routing.generate('app_api_add_owner'),
            method: 'POST',
            data: JSON.stringify(data),
        }).done(data => {
            const owner = data.owner;
            const rowNode = dataTableObject.row.add([
                owner.name,
                `<i class="fas ${owner.icon}"></i>`,
                generateActionButtons(owner.id),
            ]).draw(false).node();
            const $row = $(rowNode);
            const $cells = $row.find('td');
            $cells.eq(2).addClass('text-center');
            EntityModalHelper.hideModal();
            ToastHelper.displaySuccess(`Owner "${data.name}" has been created!`);
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
                url: Routing.generate('app_api_delete_owner', {id}),
                method: 'DELETE',
            }).done(() => {
                const $btnDelete = $(`.btn-show-delete-modal[data-entity-id="${id}"]`);
                const $row = $btnDelete.parents('tr');
                dataTableObject.row($row).remove().draw();
                ToastHelper.displaySuccess(`Owner has been deleted!`);
            }).fail((jqxhr, textStatus, error) => {
                console.error({
                    jqxhr,
                    textStatus,
                    error,
                });
                const message = undefined !== jqxhr.responseJSON.message
                    ? jqxhr.responseJSON.message
                    : 'Can not remove owner!';
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
                EntityModalHelper.setTitle('Edit Owner');
                EntityModalHelper.showModalWithSpinner();
                $.getJSON(Routing.generate('app_api_get_owner', {id}), data => {
                    EntityModalHelper.setupFormFields(data.owner);
                    EntityModalHelper.hideSpinner();
                    EntityModalHelper.setupFormSubmit(editModalSubmitCallback(id));
                }).fail((jqxhr, textStatus, error) => {
                    console.error({
                        jqxhr,
                        textStatus,
                        error,
                    });
                    ToastHelper.displayError('Can not fetch owner data!');
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
                RemovalModalHelper.setTitle('Delete Owner');
                RemovalModalHelper.showModalWithSpinner();
                $.getJSON(Routing.generate('app_api_get_owner', {id}), data => {
                    RemovalModalHelper.setContent(`Are you sure to remove Owner "${data.owner.name}"?`);
                    RemovalModalHelper.hideSpinner();
                    RemovalModalHelper.setupConfirm(deleteModalConfirmCallback(id));
                }).fail((jqxhr, textStatus, error) => {
                    console.error({
                        jqxhr,
                        textStatus,
                        error,
                    });
                    ToastHelper.displayError('Can not fetch owner data!');
                });
            }
        )
    ;

    $btnShowAddModal.click(() => {
        EntityModalHelper.setTitle('Add Owner');
        EntityModalHelper.setupFormFields({
            id: '',
            name: '',
            icon: '',
        });
        EntityModalHelper.showModal();
        EntityModalHelper.setupFormSubmit(addModalSubmitCallback);
    });
});
