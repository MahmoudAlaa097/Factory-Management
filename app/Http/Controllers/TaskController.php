<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;

class TaskController extends Controller
{
    public function index()
    {
        // Fetch all tasks
        $tasks = auth()->user()->tasks()->with(['division', 'division.management'])->paginate(10);

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
            'priority' => 'required|in:low,medium,high',
            'division_id' => 'required|exists:divisions,id',
            'location' => 'required|string|max:255',
            'scheduled_date' => 'nullable|date',
        ]);

        // Create a new task
        $task = auth()->user()->tasks()->create([
            'title' => request('title'),
            'description' => request('description'),
            'type' => 'occasional',
            'priority' => request('priority'),
            'division_id' => request('division_id'),
            'location' => request('location'),
            'scheduled_date' => request('scheduled_date'),
            'created_by' => auth()->id(),
        ]);

        // Redirect to the tasks index with a success message
        return redirect('/tasks')->with('success', 'Task created successfully!');
    }
}
