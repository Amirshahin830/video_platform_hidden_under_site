<?php

namespace App\Http\Controllers;

use App\Models\ticket_subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Utils;

class Subject_define extends Controller
{
    public function subject_create(Request $request)
    {

        $validation = Validator::make($request->all(),[
           'subject' => 'required|max:255|unique:ticket_subjects'
        ]);

        if ($validation->fails()){
            return response()->json($validation->errors(),422);
        }
        ticket_subject::create(['subject'=>$request->subject]);

    }

    public function subject_show()
    {
       return ticket_subject::get();
    }
}
