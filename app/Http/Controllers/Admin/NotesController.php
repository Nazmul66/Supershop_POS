<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateNoteRequest;
use App\Http\Requests\Admin\UpdateNoteRequest;
use App\Models\Admin;
use App\Models\Note;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class NotesController extends Controller
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
        $important_notes = Note::where('important', 1)->get();
        $admin_list = Admin::where('email', '!=', 'mainAdmin@gmail.com')->get();

        return view('admin.pages.notes_list.index',[
            'important_notes' =>  $important_notes,
            'admin_list' =>  $admin_list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNoteRequest $request)
    {
        if (!$this->user || !$this->user->can('create.category')) {
            throw UnauthorizedException::forPermissions(['create.category']);
        }
  
        // dd($request->all());

        DB::beginTransaction();
        try {
            $notes                             = new Note();
            $notes->title                      = $request->title;
            $notes->tag                        = $request->tag;
            $notes->priority                   = $request->priority;
            $notes->description                = $request->description;
            $notes->important                  = $request->important;
            $notes->assign_user_id             = $request->assign_user_id;
            $notes->priority_status            = $request->priority_status;
            $notes->status                     = $request->status;
            $notes->created_at                 = now();
            $notes->updated_at                 = now();

            // dd($notes);
            $notes->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Notes Created!", 'status' => true]);
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
    public function edit(Note $note)
    {
        if (!$this->user || !$this->user->can('update.category')) {
            throw UnauthorizedException::forPermissions(['update.category']);
        }

        // dd($note);
        return response()->json(['success' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, $id)
    {
        if (!$this->user || !$this->user->can('create.category')) {
            throw UnauthorizedException::forPermissions(['create.category']);
        }
  
        // dd($request->all());
        $notes  = Note::find($id);

        DB::beginTransaction();
        try {
            $notes->title                      = $request->title;
            $notes->tag                        = $request->tag;
            $notes->priority                   = $request->priority;
            $notes->description                = $request->description;
            $notes->important                  = $request->important;
            $notes->assign_user_id             = $request->assign_user_id;
            $notes->priority_status            = $request->priority_status;
            $notes->status                     = $request->status;
            $notes->created_at                 = now();
            $notes->updated_at                 = now();

            // dd($notes);
            $notes->save();
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
    public function destroy(Note $note)
    {
        if (!$this->user || !$this->user->can('delete.category')) {
            throw UnauthorizedException::forPermissions(['delete.category']);
        }

        $note->delete();

        return response()->json(['message' => 'Note has been deleted.'], 200);
    }
}
