@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Create Training') }}</div>

                <div class="card-body">
                   <form action="{{ route('training:store') }}" method="post" enctype="multipart/form-data">
                       @csrf
                       <div class="form-group">
                           <label for="">Title</label>
                           <input type="text" name="title" class="form-control" class="@error('title') is-invalid @enderror" value="{{ old('title') }}">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                       </div>
                       <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control" id="" class="@error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Trainer</label>
                            <input type="text" name="trainer" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Attachment</label>
                            <input type="file" name="attachment" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Store My Training</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
