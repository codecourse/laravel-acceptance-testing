@if ($tasks->count())
    <ul class="tasks">
        @foreach ($tasks as $task)
            <li class="{{ $task->done ? 'done' : '' }}">
                
                <form action="{{ route('tasks.toggle', [$task->group, $task]) }}" method="post" style="display: inline;">
                    <input type="checkbox" name="done" id="done" {{ $task->done ? 'checked="checked"' : '' }} onclick="this.form.submit()">
                    <input type="submit" class="hidden" name="toggle-task-{{ $task->id }}" value="Toggle done">

                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                </form>

                &nbsp;

                <span>
                    {{ $task->title }}

                    @if (isset($showGroup) && $showGroup === true)
                        ({{ $task->group->title }})
                    @endif
                </span>

                <div class="controls pull-right">
                    <a href="{{ route('tasks.edit', [$task->group, $task]) }}" id="update-task-{{ $task->id }}" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>
                    <form action="{{ route('tasks.destroy', [$task->group, $task]) }}" style="display: inline;" method="post">
                        <button id="destroy-task-{{ $task->id }}" type="submit" class="btn btn-sm btn-default"><i class="fa fa-times"></i></button>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p>No tasks here yet.</p>
@endif
