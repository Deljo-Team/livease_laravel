<?php

namespace App\Http\Controllers;

use App\Models\SubCategoryQuestion;
use Illuminate\Http\Request;

class SubCategoryQuestionController extends Controller
{
    public function fectchQuestians(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            
            $subCategoryQuestions = SubCategoryQuestion::where('sub_category_id', $request->sub_category_id)->get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Sub category question for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => $subCategoryQuestions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch sub category question',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
