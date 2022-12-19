<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenceEntries;
use App\Models\CustomerEnquiry;
use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\Debit;
use App\Models\Version;
use App\Models\Activity;
use DB;
use Auth;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Debit::query();

        if($request->get('debit') != "") {
            $query->where('debits.debit', $request->get('debit'));
        }
        if($request->get('details') != "") {
            $query->where('debits.details', $request->get('details'));
        }
        if($request->get('cat_id') != "") {
            $query->where('debits.category', $request->get('cat_id'));
        }

        $debits = $query->select('debits.*')
        ->orderBy('created_at', 'DESC')->paginate(20);
        return view('admin.debit.index', compact('debits') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['version'] = $version = Version::find($request->version_id);
        return view('admin.debit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = "";
        $amount = "";
        $category = "";
        $debit_details = "";

        $date = $request->debit_date_formatted;
        $amount = $request->amount;
        $category = $request->cat_id;
        $debit_details = $request->debit_details;

        $debit = new Debit();
        $debit->debit = $amount;
        $debit->category = $category;
        $debit->date = $date;
        $debit->details = $debit_details;
        $debit->created_by = Auth::user()->id;
        $debit->save();

        $activity = new Activity();
        $activity->updated_by = auth()->user()->id;
        $activity->eloquent = "Debit";
        $activity->eloquent_id = $debit->id;
        $activity->change = "";
        $activity->create_or_update = 'Update';
        $activity->save();
        return redirect()->route('debitpage')->withSuccess("Debit created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Debit  $debit
     * @return \Illuminate\Http\Response
     */
    public function show(Debit $debit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Debit  $debit
     * @return \Illuminate\Http\Response
     */
    public function edit(Debit $debit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Debit  $debit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Debit $debit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Debit  $debit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Debit $debit)
    {
        //
    }
}
