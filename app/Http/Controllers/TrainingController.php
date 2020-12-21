<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;


class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::all();
        //dd($training);
        return view('trainings.index',compact('trainings'));
    }

    public function create()
    {
        //$trainings = \App\Models\Training::all();
        //$users = \App\Models\User::all();

        return view('trainings.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        //Method 1 - POPO - Plain Old PHP Object
        $training = new Training();
        $training->title = $request->title;
        $training->description = $request->description;
        $training->trainer = $request->trainer;
        $training->user_id = auth()->user()->id;
        $training->save();

        //return redirect back
        return redirect()->back();
    }

    public function show($id){
        //find id on table using model
        $training = Training::find($id);

        //dd($training);
        //return to view
        return view('trainings.show', compact('training'));
    }

    
}
