<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class TaskController extends Controller
{


    public  function show(Tasks $task, Request $request) {
        // $tasks = Tasks::where('user-id', Auth::user()->id)
        //     ->where('title', 'like', '%' . $request->search . '%')
        //     ->get();
        // return view('dashboard', compact('tasks'));

        echo "Show Method";

        $this->destroy($task);
        return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
    }
   
    public function index() {
       
        $tasks = Tasks::where('user-id', Auth::user()->id)->paginate(10);
        return view('dashboard', compact('tasks'));
    }

  


    public function create() {
        return view('tasks.create');
    }




 public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);
            Tasks::create([
            'user-id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',    
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');

    }


    public function destroy(Tasks $task) {
        $task->delete();
    }


    public function edit(Tasks $task) {
        return view('tasks.edit', compact('task'));
    }



    public function update(Tasks $task){
        // $oTask = Tasks::find($task->id);
        // $oTask->title = $task->title;
        // $oTask->description = $task->description;
        // $oTask->status = $task->status;
        // $oTask->due_date = $task->due_date;
        // $oTask->save();
        // return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
        $task->update([
            'title' => request('title'),
            'description' => request('description'),
            'status' => $task->status, // Assuming status is not being changed here
            'due_date' => request('due_date'),
        ]);
        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }






    public function completed(Tasks $task) {
        // Mark the task as completed
        $task->status = 'completed';
        $task->save();

        return redirect()->route('dashboard')->with('success', 'Task marked as completed!');
    }











    /**
     * Store a newly created resource in storage.
    //  */
   

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Request $request)
    // {
    //     $tasks  = Tasks::where('user-id', Auth::user()->id)
    //         ->where('title', 'like', '%' . $request->search . '%')
    //         ->get();
    //     return view('dashboard', compact('task'));
    // }
    

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Tasks $task)
    // {
    //     //
    //     return view('tasks.edit', compact('task'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Tasks $tasks)
    // {
    //     //
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'status' => 'required|in:pending,completed',
    //         'due_date' => 'nullable|date',
    //     ]);
    //     $tasks->update([
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'status' => $request->status,
    //         'due_date' => $request->due_date,
    //     ]); 

    //     return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Tasks $tasks)
    // {
    //     //
        
    //}
}
