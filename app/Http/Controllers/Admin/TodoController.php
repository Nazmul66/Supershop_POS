<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateTodoRequest;
use App\Http\Requests\Admin\UpdateTodoRequest;
use App\Models\Admin;
use App\Models\Todo;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class TodoController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user = Auth::guard('admin')->user();
        if (!$this->user) {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urgent_todo = Todo::leftJoin('admins', 'admins.id', 'todos.assign_user_id')
                     ->select('todos.*', 'admins.image')
                     ->where('todos.priority', 'urgent')
                     ->get();

        $high_todo = Todo::leftJoin('admins', 'admins.id', 'todos.assign_user_id')
                     ->select('todos.*', 'admins.image')
                     ->where('todos.important', 1)
                     ->where('todos.status', 1)
                     ->get();

        $low_todo  = Todo::leftJoin('admins', 'admins.id', 'todos.assign_user_id')
                      ->select('todos.*', 'admins.image')
                      ->where('todos.status', 0)
                      ->get();

        $medium_todo = Todo::leftJoin('admins', 'admins.id', 'todos.assign_user_id')
                     ->select('todos.*', 'admins.image')
                     ->where('todos.status', 0)
                     ->get();

        $admin_list = Admin::where('email', '!=', 'mainAdmin@gmail.com')->get();

        return view('admin.pages.todo_list.index',[
            'admin_list'       =>  $admin_list,
            'urgent_todo'      =>  $urgent_todo,
            'high_todo'        =>  $high_todo,
            'medium_todo'      =>  $medium_todo,
            'low_todo'         =>  $low_todo,
        ]);
    }

    public function changeImportantStatus(Request $request)
    {
        if (!$this->user || !$this->user->can('important.note')) {
            throw UnauthorizedException::forPermissions(['important.note']);
        }

        $id = $request->id;
        $current_important = $request->important;

        if ($current_important == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Todo::findOrFail($id);
        $page->important = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTodoRequest $request)
    {
        if (!$this->user || !$this->user->can('create.note')) {
            throw UnauthorizedException::forPermissions(['create.note']);
        }
  
        // dd($request->all());

        DB::beginTransaction();
        try {
            $todo                             = new Todo();
            $todo->title                      = $request->title;
            $todo->tag                        = $request->tag;
            $todo->priority                   = $request->priority;
            $todo->description                = $request->description;
            $todo->important                  = $request->important;
            $todo->todo_cross                 = 0;
            $todo->assign_user_id             = $request->assign_user_id;
            $todo->priority_status            = $request->priority_status;
            $todo->status                     = $request->status;
            $todo->created_at                 = now();
            $todo->updated_at                 = now();

            // dd($todo);
            $todo->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Todo Created!", 'status' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        if (!$this->user || !$this->user->can('update.note')) {
            throw UnauthorizedException::forPermissions(['update.note']);
        }

        // dd($todo);
        return response()->json(['success' => $todo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, $id)
    {
        if (!$this->user || !$this->user->can('update.note')) {
            throw UnauthorizedException::forPermissions(['update.note']);
        }
  
        // dd($request->all());
        $todo  = Todo::find($id);

        DB::beginTransaction();
        try {
            $todo->title                      = $request->title;
            $todo->tag                        = $request->tag;
            $todo->priority                   = $request->priority;
            $todo->description                = $request->description;
            $todo->important                  = $request->important;
            $todo->assign_user_id             = $request->assign_user_id;
            $todo->priority_status            = $request->priority_status;
            $todo->status                     = $request->status;
            $todo->updated_at                 = now();

            // dd($todo);
            $todo->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "success"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        if (!$this->user || !$this->user->can('delete.note')) {
            throw UnauthorizedException::forPermissions(['delete.note']);
        }

        $todo->delete();

        return response()->json(['message' => 'Todo has been deleted.'], 200);
    }


    public function todoView($id)
    {
        $todo  = Todo::find($id);
        // dd($todo);

        $tag = '';
        if ($todo->tag === 'personal') {
            $tag = 'Personal';
        } elseif( $todo->tag === 'social' ) {
            $tag = 'Social';
        } elseif( $todo->tag === 'work' ) {
            $tag = 'Work';
        }

        $priority = '';
        if ($todo->priority === 'low') {
            $priority = '<span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>';
        } elseif ($todo->priority === 'medium') {
            $priority = '<span class="badge bg-outline-warning d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>';
        } elseif ($todo->priority === 'high') {
            $priority = '<span class="badge bg-outline-success d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>';
        } elseif ($todo->priority === 'urgent') {
            $priority = '<span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Urgent</span>';
        }

        return response()->json([
            'success'           => $todo,
            'priority'          => $priority,
            'tag'               => $tag,
        ]);
    }
}
