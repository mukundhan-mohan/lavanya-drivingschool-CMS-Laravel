<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessageContent;
use Illuminate\Http\Request;
use DB;
use Auth;

class MessageContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MessageContent  $messageContent
     * @return \Illuminate\Http\Response
     */
    public function show(MessageContent $messageContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MessageContent  $messageContent
     * @return \Illuminate\Http\Response
     */
    public function edit(MessageContent $messageContent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessageContent  $messageContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MessageContent $messageContent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MessageContent  $messageContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageContent $messageContent)
    {
        //
    }

    public function welcomemessage(){
        $wcmsgCon = MessageContent::select('message_contents.*')->where('message_contents.type','=','welcome_msg')->first();
        return view('admin.message-content.welcome', compact('wcmsgCon'));
    }

    public function welcomeMessageStore(Request $request)
    {
        $wcmsg = "";

        $wcmsgdata = $request->wcmsg;
        // print_r($notes);
        // exit();
        $entryexistance = MessageContent::select('message_contents.*')->where('message_contents.type','=','welcome_msg')->first();

        if(!$entryexistance)
        {
            $msgTable = new MessageContent();
            $msgTable->content = $wcmsgdata;
            $msgTable->type = "welcome_msg";
            $msgTable->save();
        }else{
            $entryexistance->content = $wcmsgdata;
            $entryexistance->save();
        }
        // $msg = "saved";
        return redirect()->route('welcomemessage')->withSuccess("Welcome Message Changed Successfully!");
        //return $msg;
    }

    public function enableDisable(Request $request){
        $wcmsgEnorDis = $request->enOrdis;
        $entryexistance = MessageContent::select('message_contents.*')->where('message_contents.type','=','welcome_msg')->first();
        $entryexistance->is_active = $wcmsgEnorDis;
        $entryexistance->save();
        if($wcmsgEnorDis == 1)
        {
            return redirect()->route('welcomemessage')->withSuccess("Welcome Message Activated Successfully!");
        }else{
            return redirect()->route('welcomemessage')->withSuccess("Welcome Message Deactivated Successfully!");
        }
        
    }
}
