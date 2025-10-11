<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        // Fetch all tasks
        $tasks = auth()->user()
            ->tasks()
            ->with(['division', 'division.management'])
            ->latest()
            ->paginate(10);

        // Pass tasks to the view
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Fetch all divisions
        $divisions = Division::select('id as value', 'name')->get()->toArray();

        // Preappend a default option
        array_unshift($divisions, ['value' => '', 'name' => 'Select Division']);

        // Pass divisions to the view
        return view('tasks.create', compact('divisions'));
    }

    public function store()
    {
        // Validate the request data
        request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'division_id' => 'required|exists:divisions,id',
            'location' => 'required|string|max:255',
        ]);

        // Create a new task
        $task = auth()->user()->tasks()->create([
            'title' => request('title'),
            'description' => request('description'),
            'type' => 'occasional',
            'priority' => request('priority'),
            'division_id' => request('division_id'),
            'location' => request('location'),
            'created_by' => auth()->id(),
        ]);

        // Redirect to the tasks index with a success message
        return redirect('/tasks')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        return view('tasks.show', [ 'task' => $task ]);
    }

    public function edit(Task $task)
    {
        $type = 'base';

        if (request()->is('tasks/*/maintenance/edit')) {
            $type = 'maintenance';
        }

        // Fetch all divisions
        $divisions = Division::select('id as value', 'name')->get()->toArray();

        return view('tasks.edit', [ 'task' => $task , 'divisions' => $divisions , 'type' => $type ]);
    }

    public function update(Task $task)
    {
        // Validate the request data
        request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'division_id' => 'required|exists:divisions,id',
            'location' => 'required|string|max:255',
        ]);

        // Update the task
        $task->update([
            'title' => request('title'),
            'description' => request('description'),
            'priority' => request('priority'),
            'division_id' => request('division_id'),
            'location' => request('location'),
        ]);

        // Redirect to the task's page with a success message
        return redirect('/tasks/' . $task->id)->with('success', 'Task updated successfully!');
    }
}
