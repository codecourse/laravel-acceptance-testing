<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGroupRequest;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function show(Request $request, Group $group)
    {
        $this->authorize('show', $group);

        return view('groups.show', [
            'group' => $group
        ]);
    }

    public function store(StoreGroupRequest $request)
    {
        $group = new Group;
        $group->user()->associate($request->user());
        $group->title = $request->group_title;
        $group->save();
        
        return redirect()->back()->withSuccess('Group created successfully');
    }
}
