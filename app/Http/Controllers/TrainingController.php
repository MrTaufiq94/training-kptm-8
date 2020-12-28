<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use File;
use Storage;
use App\Http\Requests\StoreTrainingRequest; //ini dapat dari request yg dibuat/custom
use Mail;//guna untuk send email
use Notification;
use App\Notifications\DeleteTrainingNotification;
use App\Notifications\CreateTrainingNotification;


class TrainingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->keyword) {
            $search = $request->keyword;
            // $trainings = Training::where('title','LIKE','%'.$search.'%')
            // ->orWhere('description','LIKE','%'.$search.'%')
            // ->paginate(5);

            $trainings = auth()->user()->trainings()->where('title','LIKE','%'.$search.'%')
            ->orWhere('description','LIKE','%'.$search.'%')
            ->orderBy('created_at','desc')
            ->paginate(5); // sama dengan cara yang else , untuk display hanya user ini punya data
        
        }else{

            //$trainings = Training::all();
            $trainings = Training::paginate(5);

            //get current authenticate user
            //$user = auth()->user();
            //get user training using  authenticate user
            //$trainings = $user->trainings()->paginate(5);
        }

        //dd($training);
        return view('trainings.index',compact('trainings'));
    }

    public function create()
    {
        //$trainings = \App\Models\Training::all();
        //$users = \App\Models\User::all();

        return view('trainings.create');
    }

    public function store(StoreTrainingRequest $request)
    {
        $user = auth()->user();
        Notification::send($user, new CreateTrainingNotification());
        //ini validate guna cara inheritant dari extend controller (Controller.php)
        //cara lain ada dalam nota
        // $this->validate(
        //     $request,
        //     [
        //         'title' => 'required|min:3',
        //         'description' => 'required|min:10',
        //         'attachment' => 'required|mimes:jpg,pdf,png'
        //     ]
        // );
        
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

        //send email to user
        //kalau kita taknak guna use di atas pakai \Mail
        // Mail::send('email.training-created',[
        //     'title' => $training->title,
        //     'description' => $training->description
        // ], function($message){
        //     $message->to('m.taufiqfariduddin94@gmail.com');
        //     $message->subject('Training Created using Inline Mail');
        // });

        //send email to user using mailable class
        //param 1:user nak dihantar, param 2: apa yg nk dihantar
        //function ini lama sgt nk send jadi buat job SendEmailJob
        // Mail::to('m.taufiqfariduddin94@gmail.com')->send(new \App\Mail\TrainingCreated($training));

        dispatch(new \App\Jobs\SendEmailJob($training));

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

        $this->authorize('view',$training);//kene buat utk authorize polisi supaya x boleh show walaupun button hilang
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
        $this->authorize('update',$training);//kene buat utk authorize polisi supaya x boleh update walaupun button disabled/hilang
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
        $this->authorize('delete',$training);//kene buat utk authorize polisi supaya x boleh update walaupun button disabled/hilang
        $user = auth()->user();
        Notification::send($user, new DeleteTrainingNotification());

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
