<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/ticket/get_all',function (){
   return \App\Models\ticket::with('ticket_subjec')->get();
});
Route::get('/ticket/subject/show',[\App\Http\Controllers\Subject_define::class,'subject_show']);
Route::post('/ticket/subject/create',[\App\Http\Controllers\Subject_define::class,'subject_create']);
Route::post('/ticket/send',[\App\Http\Controllers\ticket_modify::class,'save_ticket']);
Route::get('/ticket/show',[\App\Http\Controllers\ticket_modify::class,'ticket_show']);
Route::get('/ticket/answer/show',[\App\Http\Controllers\ticket_modify::class,'ticket_answer_show']);
Route::middleware(['rate_limiter','auth:sanctum'])->post('/ticket/answer/send',[\App\Http\Controllers\ticket_modify::class,'ticket_answer_send']);
Route::post('/register',[\App\Http\Controllers\register_controller::class,'authenticate_manually']);
