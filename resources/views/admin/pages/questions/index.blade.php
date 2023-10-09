@extends('layouts.admin')

@section('content')
    <div class="container sub-category-question-section">
        <div class="card">
            <div class="card-header">Questions</div>
            <div class="card-body">
                <div class="row selection-section">
                    <div class="col-md-6">
                        <label for="category"> Category</label>
                        <select class="form-select" name="category" id="category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $selected_category && $category->id == $selected_category ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="sub_category"> SubCategory</label>
                        <select class="form-select" name="sub_category" id="sub_category">
                            <option value="">Select Subcategory</option>
                            @foreach ($sub_categories as $sub_category)
                                <option value="{{ $sub_category->id }}"
                                    {{ $selected_sub_category && $sub_category->id == $selected_sub_category ? 'selected' : '' }}>
                                    {{ $sub_category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row question-section" id="question-section">
                   
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let sub_category_url = "{{ route('general.sub-category') }}";
    let question_url = "{{ route('questions.base') }}";
    // let create_url = "{{ route('questions.create') }}";
    // let store_url = "{{ route('questions.store') }}";
</script>
@vite('resources/js/admin/questions.js')
@endpush
