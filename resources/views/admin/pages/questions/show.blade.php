<div class="row">
    <div class="col-12">
        <div class="accordion" id="questions">
            @if ($questions->count() != 0)
                @foreach ($questions as $question)
                    <?php $disabled = $question->type == 'select' ? '' : 'disabled';
                    $answers = $question->answer != '' ? json_decode($question->answer) : ''; ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ $question->id }}" data-id="{{ $question->id }}">
                            <div class="action-area">
                                @if ($loop->iteration != 1)
                                    <span class="material-symbols-outlined text-success priority" data-move="up">arrow_upward</span>
                                @endif
                                @if ($loop->iteration != $questions->count())
                                    <span class="material-symbols-outlined text-danger priority"
                                        data-move="down">arrow_downward</span>
                                @endif
                                @if ($question->is_active)
                                    <span class="material-symbols-outlined text-success status" data-status="0">toggle_on</span>
                                @else
                                    <span class="material-symbols-outlined text-danger status" data-status="1">toggle_off</span>
                                @endif
                                <span class='material-symbols-outlined edit'>edit</span>
                                <span class='material-symbols-outlined text-danger delete'>delete_forever</span>
                            </div>
                            <span class="accordion-button {{ $disabled }}" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $question->id }}" aria-expanded="true"
                                aria-controls="collapseOne" {{ $disabled }}>

                                <strong>Q{{ $loop->iteration }}.&nbsp;</strong> {{ $question->question }}
                            </span>
                        </h2>
                        @if ($question->type == 'select')
                            <div id="collapse-{{ $question->id }}" class="accordion-collapse collapse show"
                                aria-labelledby="heading-{{ $question->id }}" data-bs-parent="#questions">

                                <div class="accordion-body">
                                    @foreach ($answers as $option)
                                        <span class="option-pill">{{ $option }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12 d-flex justify-content-center">
        <button type="button" id="add-question" class="btn btn-primary">
            Add Question
        </button>
    </div>
