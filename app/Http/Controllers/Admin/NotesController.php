<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notes;
use App\Models\LicenceEntries;
use App\Models\Payments;
use App\Models\CustomerEnquiry;
use Illuminate\Http\Request;
use App\Models\Version;
use App\Models\Activity;
use DB;
use Auth;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allNotes = Notes::select('notes.*')->where('notes.id',1)->first();
        // print_r($allNotes);
        // exit();
        return view('admin.notes.index' , compact('allNotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notes = "";

        $notesdata = $request->notes;
        // print_r($notes);
        // exit();
        $entryexistance = Notes::select('notes.*')->where('notes.id','=',1)->first();

        if(!$entryexistance)
        {
            $notesTable = new Notes();
            $notesTable->notes = $notesdata;
            $notesTable->save();
        }else{
            $entryexistance->notes = $notesdata;
            $entryexistance->save();
        }
        $msg = "saved";
        //return redirect()->route('notespage')->withSuccess("Note Added successfully!");
        return $msg;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function show(Notes $notes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function edit(Notes $notes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notes $notes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notes $notes)
    {
        //
    }
}
