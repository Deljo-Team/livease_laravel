<?php $question_types = ['select', 'text', 'time', 'file', 'boolean']; ?>
<form id="question-form">
    <input type="hidden" name="form_type" id="form_type" value="edit">
    <input type="hidden" name="question_id" id="question_id" value="{{$question->id}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
        <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="form-floating mb-3">
            <select class="form-select" aria-label="Default select example" id="question-type" name="question_type">
                <option selected>Select Question Type</option>
                @foreach($question_types as $question_type)
                <option value="{{$question_type}}" {{$question_type == $question->type ? "selected":""}}>{{ucwords($question_type)}}</option>
                @endforeach
            </select>
            <label for="question-type" class="form-label">Question type</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="question" placeholder="Enter the question" name="question" value="{{$question->question}}">
            <label for="question" class="form-label">Question</label>
        </div>
        <div class="options {{'select' != $question->type ? 'd-none' : ''}}" id="option-create">
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
                @if($question->type == 'select')
                @foreach(json_decode($question->answer) as $option)
                <div class="row option-row mb-3">
                    <div class="col-9">
                        <input type="text" class="form-control option" placeholder="Enter the option"
                            name="options[]" value="{{$option}}">
                    </div>
                    <div class="col-3 d-flex">
                        <button type="button" class="btn btn-danger rounded-button remove-option">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </div>
                @endforeach
                @else
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
                @endif

            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal-close" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit">Update Question</button>
    </div>
</form>
