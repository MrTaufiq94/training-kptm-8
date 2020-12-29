@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Audits') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th>Action</th>
                            <th>User</th>
                            <th>Time</th>
                            <th>Old Values</th>
                            <th>New Values</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($audits as $audit)
                        <tr>
                            <td>{{ $audit->auditable_type }} (ID: {{ $audit->auditable_id }})</td>
                            <td>{{ $audit->event }}</td>
                            <td>{{ $audit->user->name }}</td>
                            <td>{{ $audit->created_at }}</td>
                            <td>
                                <table class="table">
                                    @foreach($audit->old_values as $attribute => $value)
                                    <tr>
                                        <td><b>{{ $attribute }}</b></td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td>
                                <table class="table">
                                    @foreach($audit->new_values as $attribute => $value)
                                    <tr>
                                        <td><b>{{ $attribute }}</b></td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection 