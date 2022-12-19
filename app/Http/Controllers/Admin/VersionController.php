<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Version;
use App\Models\Activity;
use DB;
use Auth;

class VersionController extends Controller
{
    public function index()
    {
        $query = Version::query();
        $Versions = $query->select('versions.*','users.name as updator_name','creator.name as creator_name')
        ->where('versions.has_deleted','0')
        ->orderBy('created_at', 'DESC')
        ->leftJoin('users','users.id','=','versions.updated_by')
        ->leftJoin('users as creator','creator.id','=','versions.created_by')->paginate(20);
        return view('admin.version.index', compact('Versions') );
    }
    public function create(Request $request)
    {
        $data['version'] = $version = Version::find($request->version_id);
        return view('admin.version.create', $data);
    }
    public function store(Request $request)
    {
        $titl = $request->title;
        $amt = $request->amount;
        $clss = $request->no_of_class; 

        $versionInputes['updated_by'] = Auth::user()->id;
        $versionInputes['name'] = $titl;
        $versionInputes['amount'] = $amt;
        $versionInputes['no_of_classes'] = $clss;
        $versionInputes['updated_by'] = auth()->user()->id;

        $existingVersion = Version::find($request->version_id);
        if($existingVersion)
        {
            Version::where('id', $request->version_id)->update($versionInputes);

            $activity = new Activity();
            $activity->updated_by = auth()->user()->id;
            $activity->eloquent = "Version";
            $activity->eloquent_id = $titl;
            $activity->change = "";
            $activity->create_or_update = 'update';
            $activity->save();
            return redirect()->route('versionpage')->withSuccess("Record updated successfully!");
        }else{
            $version = new Version();
            $version->name = $titl;
            $version->amount = $amt;
            $version->no_of_classes = $clss;
            $version->created_by = auth()->user()->id;
            $version->updated_by = auth()->user()->id;
            $version->save();

            $activity = new Activity();
            $activity->updated_by = auth()->user()->id;
            $activity->eloquent = "Version";
            $activity->eloquent_id = $titl;
            $activity->change = "";
            $activity->create_or_update = 'create';
            $activity->save();
            return redirect()->route('versionpage')->withSuccess("Record created successfully!");
        }
    }
    public function show(Version $version)
    {
        return view('admin.version.show', compact('version'));
    }
    public function delete(Request $request, $id)
    {
        $version = Version::find($id);
        if($version) {
            $version->has_deleted = 1;
            $version->updated_by = auth()->user()->id;
            $version->save();
        }
        if($request->ajax()){
            return response()->json(['status' => 200, 'message' => 'Record deleted successfully!'], 200); 
        }
        return redirect()->route('users.index')->withSuccess("Record deleted successfully!");
    }
}
