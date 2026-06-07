<?php

namespace App\Http\Controllers;


use App\Models\ticket;
use App\Models\ticket_answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ticket_modify extends Controller
{
    public function save_ticket(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'subject' => 'required|integer',
        'phone_number' => 'required|string|max:11',
        'email' => 'required|email',
        'Description' => 'required',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),422);
        }

        ticket::create([
            'subject' => $request->subject,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'Description' => $request->Description,
            'type' => 0,
        ]);
    }
    public function ticket_show()
    {
        return ticket::with('ticket_subject')->get();
    }

    public function ticket_answer_show()
    {

        return ticket_answer::with('tickets')->get();
    }

    public function ticket_answer_send(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'ticket_id' => 'required|integer',
            'answer'=>'required'
        ]);
        if($validate->fails()){
            return response()->json([$validate->errors(),422]);
        }


            ticket_answer::create([
                'ticket_id' => $request->ticket_id,
                'answer' => $request->answer,
                'User_id' => auth()->id()
        ]);

    }
}
