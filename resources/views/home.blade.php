@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include ('partials._groups')
            </div>
            <div class="col-md-9">
                @include ('partials._tasks', [
                    'tasks' => $tasks,
                    'showGroup' => true
                ])
            </div>
        </div>
    </div>
@endsection
