@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include ('partials._groups')
            </div>
            <div class="col-md-9">
                <p class="lead">Tasks in group: {{ $group->title }}</p>

                <hr>

                @include ('partials._tasks', [
                    'tasks' => $group->tasks
                ])

                <hr>

                <form action="{{ route('tasks.store', $group) }}" method="post">
                    <div class="form-group{{ $errors->has('task_title') ? ' has-error' : '' }}">
                        <div class="input-group">
                            <input type="text" name="task_title" class="form-control" placeholder="Create a task">

                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit" id="create-task">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </span>
                        </div>

                        @if ($errors->has('task_title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('task_title') }}</strong>
                            </span>
                        @endif
                    </div>

                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection
