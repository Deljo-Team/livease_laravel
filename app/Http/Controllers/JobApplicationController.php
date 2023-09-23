<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationCreateRequest;
use App\Http\Requests\JobApplicationDeleteRequest;
use App\Interfaces\FileStorageInterface;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class JobApplicationController extends Controller
{   
    protected $storage_path;
    public function __construct()
    {
        $this->storage_path = 'coustomer/job_application/';
    }
    public function index()
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $jobApplications = JobApplication::where('user_id', $user_id)->get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Job applications for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => $jobApplications,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch job applications',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
    public function storeOrUpdate(JobApplicationCreateRequest $request, FileStorageInterface $storage)
    {
        $user = auth('sanctum')->user();
        $user_id = $user->id;

        try {
            $job_application = JobApplication::where('user_id', $user_id)->first();

            if (!$job_application) {
                $job_application = new JobApplication();
                $job_application->user_id = $user_id;
            }
            $job_application->phone = $request->phone;
            $job_application->email = $request->email;
            $job_application->linked_in_link = $request->linked_in_link;
            $job_application->visa_validity = $request->visa_validity;
            $job_application->gender_id = $request->gender_id;
            $job_application->job_type_id = $request->job_type_id;
            $job_application->experience_level = $request->experience_level;
            $job_application->current_job_id = $request->current_job_id;
            $job_application->desire_job_id = $request->desire_job_id;
            $job_application->visa_type_id = $request->visa_type_id;
            $job_application->note = $request->note;
            $job_application->present_company = $request->present_company;
            $job_application->present_salary = $request->present_salary;
            $job_application->expected_salary = $request->expected_salary;
            $job_application->status = $request->status;

            if ($request->hasFile('image')) {
                $imagePath = $storage->saveFile($request->file('image'), $this->storage_path . $user_id, 'image.' . $request->file('image')->extension());
                $job_application->image = $imagePath;
            }

            if ($request->hasFile('cv')) {
                $cvPath = $storage->saveFile($request->file('cv'), $this->storage_path . $user_id, 'cv.' . $request->file('cv')->extension());
                $job_application->cv = $cvPath;
            }

            if ($request->hasFile('proof')) {
                $proofPath = $storage->saveFile($request->file('proof'), $this->storage_path . $user_id, 'proof.' . $request->file('proof')->extension());
                $job_application->proof = $proofPath;
            }

            $job_application->save();

            $imageUrl = $job_application->image ? config('app.url') . $storage->getFileUrl($job_application->image) : null;
            $cvUrl = $job_application->cv ? config('app.url') . $storage->getFileUrl($job_application->cv) : null;
            $proofUrl = $job_application->proof ? config('app.url') . $storage->getFileUrl($job_application->proof) : null;

            return response()->json([
                'Success' => true,
                'Message' => 'Job profile ' . ($job_application->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $job_application,
                'Image' => $imageUrl,
                'CV' => $cvUrl,
                'Proof' => $proofUrl,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Job profile ' . ($job_application->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($job_application_id, FileStorageInterface $storage)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
            
            $jobApplication = JobApplication::where('user_id', $user_id)
                ->findOrFail($job_application_id);
    
            $storage->deleteFile($jobApplication->getRawOriginal('image'));
            $storage->deleteFile($jobApplication->getRawOriginal('cv'));
            $storage->deleteFile($jobApplication->getRawOriginal('proof'));
            $jobApplication->delete();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Job application deleted successfully',
                'Title'   => 'Success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete job application',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
