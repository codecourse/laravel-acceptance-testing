@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Editing task: {{ $task->title }}
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('tasks.update', [$task->group, $task]) }}" method="post" class="form-horizontal">
                            <div class="form-group{{ $errors->has('task_title') ? ' has-error' : '' }}">
                                <label for="task_title" class="col-md-4 control-label">Task title</label>

                                <div class="col-md-6">
                                    <input type="text" name="task_title" id="task_title" class="form-control" value="{{ $task->title }}">

                                    @if ($errors->has('task_title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('task_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Save task</button>
                                </div>
                            </div>

                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
