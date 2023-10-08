<?php

namespace App\Http\Controllers;

use App\Models\ServiceAnswer;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceAnswerController extends Controller
{
    public function storeAnswers(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            
            $service = new Service();
            $service->user_id = $user->id;
            $service->save();

            $answersData = $request->answers;
            foreach ($answersData as $questionId => $answer) {
                $serviceAnswers[] = [
                    'service_id' => $service->id,
                    'questions_id' => $questionId,
                    'answer' => $answer,
                ];
            }
            ServiceAnswer::insert($serviceAnswers);
            $serviceAnswer = ServiceAnswer::where('service_id', $service->id)->get();
            return response()->json([
                'Success' => true,
                'Message' => 'Service answers for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => $serviceAnswer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch service answers',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
