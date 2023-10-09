<form id="question-form">
    <input type="hidden" name="form_type" id="form_type" value="create">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
        <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="form-floating mb-3">
            <select class="form-select" aria-label="Default select example" id="question-type" name="question_type">
                <option selected>Select Question Type</option>
                <option value="select">Select</option>
                <option value="text">Text</option>
                <option value="time">Time</option>
                <option value="file">File</option>
                <option value="boolean">Boolean</option>
            </select>
            <label for="question-type" class="form-label">Question type</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="question" placeholder="Enter the question" name="question">
            <label for="question" class="form-label">Question</label>
        </div>
        <div class="options d-none" id="option-create">
            <div class="row mb-3">
                <div class="col-9">
                    <div class="options-heading">Options</div>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-success rounded-button" id="add-option">
                        <span class="material-symbols-outlined">add</span>
                    </button>
                </div>
            </div>
            <div id="option-list">
                <div class="row option-row mb-3">
                    <div class="col-9">
                        <input type="text" class="form-control option" placeholder="Enter the option"
                            name="options[]">
                    </div>
                    <div class="col-3 d-flex">
                        <button type="button" class="btn btn-danger rounded-button remove-option">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal-close" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit">Add Question</button>
    </div>
</form>
