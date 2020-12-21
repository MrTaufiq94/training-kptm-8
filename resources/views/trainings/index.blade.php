@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Training Index') }}</div>

                <div class="card-body">
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Creator</th>
                                <th>Created At</th>
                                <th>Created Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainings as $training)
                                <tr>
                                    <td>{{$training->id}}</td>
                                    <td>{{$training->title}}</td>
                                    <td>{{$training->description}}</td>
                                    <td>
                                        {{$training->user->name}} <strong>{{$training->user->email}}</strong>
                                    </td>
                                    <td>{{$training->created_at ? $training->created_at->diffForHumans() : 'No Data'}}</td>
                                    <td>{{$training->created_at ?? 'No Data'}}</td>
                                    <td>
                                        <a href="{{ route('training:show', $training) }}" class="btn btn-primary">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
