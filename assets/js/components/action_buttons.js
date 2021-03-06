const generateActionButtons = id => {
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

export default generateActionButtons;
