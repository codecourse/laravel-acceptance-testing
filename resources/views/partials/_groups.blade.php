<div class="panel panel-default">
    <div class="panel-heading">Your task groups</div>
    <ul class="nav nav-pills nav-stacked">
        @foreach ($groups as $group)
            <li class="{{ request()->is('groups/' . $group->id) ? 'active' : '' }}"><a href="{{ route('groups.show', $group) }}">{{ $group->title }}</a></li>
        @endforeach
    </ul>
</div>

<form action="{{ route('groups.store') }}" method="post" class="form-vertical">
    <div class="form-group{{ $errors->has('group_title') ? ' has-error' : '' }}">
        <div class="input-group">
            <input type="text" name="group_title" class="form-control" placeholder="Create a group">

            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit" id="create-group">
                    <i class="fa fa-plus"></i>
                </button>
            </span>
        </div>

        @if ($errors->has('group_title'))
            <span class="help-block">
                <strong>{{ $errors->first('group_title') }}</strong>
            </span>
        @endif
    </div>

    {{ csrf_field() }}
</form>