<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = \App\Models\Training::all();
        //dd($training);
        return view('trainings.index',compact('trainings'));
    }
}
