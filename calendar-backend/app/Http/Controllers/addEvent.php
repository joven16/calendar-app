<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;

class addEvent extends Controller
{
    //
    function saveEvent(Request $request){
        $event = EventModel::create($request->all());
        return response()->json($event, 201);
    }
}
