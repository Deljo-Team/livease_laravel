<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRemindersRequest;
use App\Models\Reminders;

class RemindersController extends Controller
{
    public function index($reminder_id)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $reminder = Reminders::where('id', $reminder_id)
            ->where('user_id', $user_id)
            ->get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Reminder for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => $reminder,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch reminder',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function reminderInfo() {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $reminderPendingCount = Reminders::where('user_id', $user_id)
            ->where('status', 'pending')
            ->count();

            $reminderCompletedCount = Reminders::where('user_id', $user_id)
            ->where('status', 'completed')
            ->count();

            $reminderTodayPendingCount = Reminders::where('user_id', $user_id)
            ->where('status', 'pending')
            ->whereDate('date_time', '=', now()->toDateString())
            ->count();

            return response()->json([
                'Success' => true,
                'Message' => 'Reminder for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => [
                    'pending_count' => $reminderPendingCount,
                    'completed_count' => $reminderCompletedCount,
                    'today_pending_count' => $reminderTodayPendingCount,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch reminder',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function reminderList() {
        try{
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $reminderList = Reminders::where('user_id', $user_id)
            ->where('status', 'pending')
            ->orderBy('date_time', 'asc')
            ->get();

            return response()->json([
                'Success' => true,
                'Message' => 'Reminders for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => [
                    'reminder_list' => $reminderList,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch reminders',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function storeOrUpdate(StoreRemindersRequest $request)
    {
        $user = auth('sanctum')->user();
        $user_id = $user->id;

        try {
            if (!$request->id) {
                $reminder = new Reminders();
            } else {
                $reminder = Reminders::where('id', $request->id)->first();
            }

            $reminder->user_id = $user_id;
            $reminder->reminder = $request->reminder;
            $reminder->date_time = $request->date_time;
            $reminder->person_name = $request->person_name;
            $reminder->reminder_type = $request->reminder_type;
            $reminder->alert = $request->alert;
            $reminder->icon = $request->icon;
            $reminder->status = $request->status;
            $reminder->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Reminder ' . ($reminder->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $reminder,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Reminder ' . ($reminder->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($reminder_id)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
            
            $reminder = Reminders::where('user_id', $user_id)
                ->findOrFail($reminder_id);

            $reminder->delete();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Reminder deleted successfully',
                'Title'   => 'Success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete reminder',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
