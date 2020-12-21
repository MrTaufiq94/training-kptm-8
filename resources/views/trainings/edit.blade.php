@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Training') }}</div>

                <div class="card-body">
                   <form action="" method="post">
                       @csrf
                       <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $training->title }}">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control" id=""> {{$training->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Trainer</label>
                            <input type="text" name="trainer" class="form-control" value="{{ $training->trainer }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update My Training</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
