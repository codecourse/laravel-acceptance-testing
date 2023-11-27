<?php

namespace App\Http\Controllers;

use App\Task;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function toggle(Request $request, Group $group, Task $task)
    {
        $this->authorize('affect', $task);

        $task->done = !$task->done;
        $task->save();

        $status = $task->done ? 'done' : 'to do';

        return back()->withSuccess('Task marked as ' . $status);
    }

    public function edit(Request $request, Group $group, Task $task)
    {
        $this->authorize('affect', $task);
        
        return view('tasks.edit', [
            'task' => $task
        ]);
    }

    public function update(UpdateTaskRequest $request, Group $group, Task $task)
    {
        $this->authorize('affect', $task);
        
        $task->title = $request->task_title;
        $task->save();

        return redirect()
            ->route('groups.show', $task->group)
            ->withSuccess('Task was updated');
    }

    public function store(StoreTaskRequest $request, Group $group)
    {
        $this->authorize('affect', $group);

        $task = new Task;
        $task->group()->associate($group);
        $task->title = $request->task_title;
        $task->done = false;

        $task->save();

        return redirect()->back()->withSuccess('Task created successfully');
    }

    public function destroy(Request $request, Group $group, Task $task)
    {
        $this->authorize('affect', $task);

        $task->delete();
        
        return redirect()->back()->withSuccess('Task deleted successfully');
    }
}
