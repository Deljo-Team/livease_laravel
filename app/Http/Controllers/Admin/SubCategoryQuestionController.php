<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubCategoryQuestion;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubCategoryQuestionController extends Controller
{
    protected $services;
    public function __construct()
    {
        $this->services = new GeneralServices();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $sub_categories = [];
        $selected_category = null;
        $selected_sub_category = null;
        if ($request->sub_category_id) {
            $sub_category = SubCategory::find($request->sub_category_id);
            $selected_category = $sub_category->category->id ?? null;
            $sub_categories = SubCategory::where('category_id', $sub_category->category_id)->get();
            $selected_sub_category = $request->sub_category_id;
            $questions = SubCategoryQuestion::where('sub_category_id', $request->sub_category_id)
                ->orderBy('priority', 'ASC')
                ->get();
        }
        // dd($questions->toArray());
        return view('admin.pages.questions.index', compact('categories', 'sub_categories', 'selected_category', 'selected_sub_category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $html =  view('admin.pages.questions.create');
        return response()->json(['success' => 1, 'html' => $html->render()]);
    }

    public function show(Request $request)
    {
        if (!$request->subcategory_id) {
            return response()->json(['success' => 0, 'message' => 'Sub Category not found']);
        }
        $questions = SubCategoryQuestion::where('sub_category_id', $request->subcategory_id)
            ->orderBy('priority', 'ASC')
            ->get();

        $html =  view('admin.pages.questions.show', compact('questions'));
        return response()->json(['success' => 1, 'html' => $html->render()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'sub_category_id' => 'required|exists:sub_categories,id',
            'question_type' => 'required',
            'question' => 'required',
        ];
        if ($request->question_type == 'select') {
            $rules['options'] = 'required|array';
        }
        $validated = $request->validate($rules);
        if ($validated) {
            try {
                $priority = SubCategoryQuestion::where('sub_category_id', $request->sub_category_id)->max('priority');
                if (!$priority) {
                    $priority = 1;
                } else {
                    $priority++;
                }
                $question = new SubCategoryQuestion();
                $question->sub_category_id = $request->sub_category_id;
                $question->type = $request->question_type;
                $question->question = $request->question;
                $question->answer = null;
                $question->priority = $priority;
                if ($request->question_type == 'select') {
                    $question->answer = json_encode($request->options);
                }
                $question->save();
                return response()->json(['success' => 1, 'message' => 'Question added successfully']);
            } catch (\Exception $e) {

                return response()->json(['success' => 0, 'message' => 'Something went wrong', 'error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $question = SubCategoryQuestion::find($request->id);
        $html =  view('admin.pages.questions.edit', compact('question'));
        return response()->json(['success' => 1, 'html' => $html->render()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $rules = [
            'sub_category_id' => 'required|exists:sub_categories,id',
            'question_type' => 'required',
            'question' => 'required',
        ];
        if ($request->question_type == 'select') {
            $rules['options'] = 'required|array';
        }
        $validated = $request->validate($rules);
        if ($validated) {
            try {
                $question = SubCategoryQuestion::find($request->id);
                $question->sub_category_id = $request->sub_category_id;
                $question->type = $request->question_type;
                $question->question = $request->question;
                $question->answer = null;
                if ($request->question_type == 'select') {
                    $question->answer = json_encode($request->options);
                }
                $question->save();
                return response()->json(['success' => 1, 'message' => 'Question updated successfully']);
            } catch (\Exception $e) {

                return response()->json(['success' => 0, 'message' => 'Something went wrong', 'error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        try {
            $question = SubCategoryQuestion::find($request->id);
            if (!$question) {
                return response()->json(['success' => 0, 'message' => 'Question not found']);
            }
            $question->delete();
            return response()->json(['success' => 1, 'message' => 'Question deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => 'Something went wrong']);
        }
    }

    public function priority(Request $request)
    {
        try {
            if ($request->priority == 'up') {
                $direction = '<';
                $order = 'DESC';
                $error_message = 'This is the first question';
            } else {
                $direction = '>';
                $order = 'ASC';
                $error_message = 'This is the last question';
            }

            $question = SubCategoryQuestion::find($request->id);
            if (!$question) {
                return response()->json(['success' => 0, 'message' => 'Question not found']);
            }
            $current_priority = $question->priority;

            $next_question = SubCategoryQuestion::where('sub_category_id', $question->sub_category_id)
                ->where('priority', $direction, $current_priority)
                ->orderBy('priority', $order)
                ->first();

            if (!$next_question) {
                return response()->json(['success' => 0, 'message' => $error_message]);
            }
            $next_priority = $next_question->priority;
            $next_question->priority = $current_priority;
            $question->priority = $next_priority;
            $question->save();
            $next_question->save();

            return response()->json(['success' => 1, 'message' => 'Question priority updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => 'Something went wrong']);
        }
    }

    public function status(Request $request)
    {
        try {
            $question = SubCategoryQuestion::find($request->id);
            if (!$question) {
                return response()->json(['success' => 0, 'message' => 'Question not found']);
            }
            $question->is_active = $request->status;
            $question->save();
            return response()->json(['success' => 1, 'message' => 'Question status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => 'Something went wrong']);
        }
    }
}
