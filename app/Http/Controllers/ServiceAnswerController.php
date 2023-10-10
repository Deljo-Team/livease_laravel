<?php

namespace App\Http\Controllers;

use App\Models\ServiceAnswer;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Interfaces\FileStorageInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ServiceAnswerController extends Controller
{
    protected $storage_path;
    public function __construct()
    {
        $this->storage_path = 'coustomer/ServiceFiles/';
    }

    public function storeAnswers(Request $request, FileStorageInterface $storage)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
            $service = new Service();
            $service->user_id  = $user->id;
            $service->save();

            $answersData = $request->answers;
            $answerType = 'text';
            foreach ($answersData as $questionId => $answer) {
                if (is_array($answer)) {
                    $implodingData = [];
                    foreach ($answer as $key=>$answers) {
                        if (is_uploaded_file($answers)) {
                            $implodingData[] = $answers->storeAs($this->storage_path . $user_id .'/'. $service->id .'/'. $questionId, $key.'.' . $answers->getClientOriginalExtension());
                            $answerType = 'file';
                        } else {
                            $implodingData[] = $answers;
                            $answerType = 'multiple';
                        }
                    }
                    if(isset($implodingData)) {
                        $answer =  implode(', ', $implodingData);
                    }
                }
                $serviceAnswers[] = [
                    'service_id' => $service->id,
                    'questions_id' => $questionId,
                    'answer' => $answer,
                    'answer_type' => $answerType,
                ];
            }
            ServiceAnswer::insert($serviceAnswers);

            $serviceAnswer = ServiceAnswer::where('service_id', $service->id)->get();
            if($serviceAnswer) {
                foreach ($serviceAnswer as $answerData) {
                    $fileUrls = [];
                    if($answerData->answer_type == 'file' || $answerData->answer_type == 'multiple') {
                        $explodedData =  explode(', ', $answerData->answer);
                        if($answerData->answer_type == 'file') {
                            foreach ($explodedData as $location) {
                                $fileUrls[] = $location ? config('app.url') . $storage->getFileUrl($location) : null;
                            }
                        }
                        $answerData->answer = $fileUrls ? $fileUrls : $explodedData; 
                    }
                }
            }
            return response()->json([
                'Success' => true,
                'Message' => 'Service answers for the user stored successfully',
                'Title'   => 'Success',
                'Data'    => $serviceAnswer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to store service answers',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
