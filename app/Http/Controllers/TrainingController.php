<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use File;
use Storage;


class TrainingController extends Controller
{
    public function index()
    {
        //$trainings = Training::all();
        //$trainings = Training::paginate(5);

        //get current authenticate user
        $user = auth()->user();
         //get user training using  authenticate user
        $trainings = $user->trainings()->paginate(5);

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
        //ini validate guna cara inheritant dari extend controller (Controller.php)
        //cara lain ada dalam nota
        $this->validate(
            $request,
            [
                'title' => 'required|min:3',
                'description' => 'required|10',
            ]
        );
        
        //dd($request->all());
        //Method 1 - POPO - Plain Old PHP Object
        $training = new Training();
        $training->title = $request->title;
        $training->description = $request->description;
        $training->trainer = $request->trainer;
        $training->user_id = auth()->user()->id;
        $training->save();

        if($request->hasFile('attachment')){
            //rename file eg: 10-2020-22.jpg
            $filename = $training->id.'-'.date("Y-m-d").'.'.$request->attachment->getClientOriginalExtension();

            //store file on storage
            Storage::disk('public')->put($filename, File::get($request->attachment));

            //update row with filename
            $training->update(['attachment' => $filename]);
        }

        //return redirect back
        //return redirect()->back();
        return redirect()
            ->route('training:list')
            ->with([
                'alert-type' => 'alert-primary',
                'alert' => 'Your Training has been stored!'
            ]);
        
    }

    //public function show($id){ //ini biasa punya
    public function show(Training $training){ //ini model binding
        //find id on table using model
        //$training = Training::find($id); //ini pakai biasa punya kalau model binding x perlu letak ini

        //dd($training);
        //return to view
        return view('trainings.show', compact('training'));
    }

    public function edit($id){ // ini biasa punya x sama macam model binding
        //find id on table using model
        $training = Training::find($id);

        //return to view
        return view('trainings.edit', compact('training'));
    }

    public function update(Request $request, $id){
        //find id on table using model
        $training = Training::find($id);
        //update training with edited attributes

        //Method 2 - Mass Assignment
        //$training->update($request->all());//update semua automatik
        $training->update($request->only('title','description','trainer'));//update tertentu shaja
        //return to trainings
        return redirect()
            ->route('training:list')
            ->with([
                'alert-type' => 'alert-success',
                'alert' => 'Your Training has been updated!'
            ]);
    }

    public function delete(Training $training){//ini guna model binding
        if ($training->attachment !=null) {
            Storage::disk('public')->delete($training->attachment);
        }

        $training->delete();
        return redirect()
            ->route('training:list')
            ->with([
                'alert-type' => 'alert-danger',
                'alert' => 'Your Training has been deleted!'
            ]);
    }
    
}
