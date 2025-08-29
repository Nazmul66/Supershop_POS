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
        $all_notes = Note::leftJoin('admins', 'admins.id', 'notes.assign_user_id')
                     ->select('notes.*', 'admins.image')
                     ->where('notes.status', 1)
                     ->get();

        $important_notes = Note::leftJoin('admins', 'admins.id', 'notes.assign_user_id')
                    ->select('notes.*', 'admins.image')
                    ->where('notes.important', 1)
                    ->where('notes.status', 1)
                    ->get();

        $trash_notes = Note::leftJoin('admins', 'admins.id', 'notes.assign_user_id')
                     ->select('notes.*', 'admins.image')
                     ->where('notes.status', 0)
                     ->get();

        $admin_list = Admin::where('email', '!=', 'mainAdmin@gmail.com')->get();

        return view('admin.pages.notes_list.index',[
            'important_notes' =>  $important_notes,
            'admin_list'      =>  $admin_list,
            'all_notes'       =>  $all_notes,
            'trash_notes'     =>  $trash_notes,
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

        $page = Note::findOrFail($id);
        $page->important = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNoteRequest $request)
    {
        if (!$this->user || !$this->user->can('create.note')) {
            throw UnauthorizedException::forPermissions(['create.note']);
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
        if (!$this->user || !$this->user->can('update.note')) {
            throw UnauthorizedException::forPermissions(['update.note']);
        }

        // dd($note);
        return response()->json(['success' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, $id)
    {
        if (!$this->user || !$this->user->can('update.note')) {
            throw UnauthorizedException::forPermissions(['update.note']);
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
        if (!$this->user || !$this->user->can('delete.note')) {
            throw UnauthorizedException::forPermissions(['delete.note']);
        }

        $note->delete();

        return response()->json(['message' => 'Note has been deleted.'], 200);
    }


    public function noteView($id)
    {
        $note  = Note::find($id);
        // dd($note);

        $tag = '';
        if ($note->tag === 'personal') {
            $tag = 'Personal';
        } elseif( $note->tag === 'social' ) {
            $tag = 'Social';
        } elseif( $note->tag === 'work' ) {
            $tag = 'Work';
        }

        $priority = '';
        if ($note->priority === 'low') {
            $priority = '<span class="badge bg-outline-danger d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Low</span>';
        } elseif ($note->priority === 'medium') {
            $priority = '<span class="badge bg-outline-warning d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Medium</span>';
        } elseif ($note->priority === 'high') {
            $priority = '<span class="badge bg-outline-success d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>High</span>';
        } elseif ($note->priority === 'urgent') {
            $priority = '<span class="badge bg-outline-info d-inline-flex align-items-center"><i class="fas fa-circle fs-6 me-1"></i>Urgent</span>';
        }

        return response()->json([
            'success'           => $note,
            'priority'          => $priority,
            'tag'               => $tag,
        ]);
    }
}
