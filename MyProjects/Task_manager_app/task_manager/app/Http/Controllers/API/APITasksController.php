<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\task_manager;
use Illuminate\Http\Request;
use App\Models\TaskManager;
use App\Jobs\SendEmailJob;

class APITasksController extends Controller
{
    public function create(Request $request)
    {   $data = new task_manager();
        $data->task_description = $request->get('task_description');
        $data->task_owner = $request->get('task_owner');
        $data->task_owner_email = $request->get('task_owner_email');
        $data->task_eta = $request->get('task_eta');
        if($data->save()) {
            dispatch(new SendEmailJob($data));
            return "data saved successfully";
        }
        return "error saving data";
    }

    public function index()
    {
        $data = task_manager::get();
        return $data;
    }

    public function getTaskById($id)
    {
        $data = task_manager::find($id);
        return $data;
    }

    public function update(Request $request, $id)
    {
        $data = task_manager::find($id);
        $data->task_description = $request->get('task_description');
        $data->task_owner = $request->get('task_owner');
        $data->task_owner_email = $request->get('task_owner_email');
        $data->task_eta = $request->get('task_eta');
        if($data->save()) {
            return "data updated successfully";
        }
        return "error updating data";
    }

    public function markAsDone($id)
    {
        $data = task_manager::find($id);
        $data->task_status = 1;
        if($data->save()) {
            dispatch(new SendEmailJob($data));
            return "task marked as done";
        }
        return "error marking task as done";
    }

    public function delete($id)
    {
        $data = task_manager::find($id);
        if($data->delete()) {
            return "task deleted successfully";
        }
        return "error deleting task";
    }
}
