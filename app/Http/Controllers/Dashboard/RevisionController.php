<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Venturecraft\Revisionable\Revision;

class RevisionController extends Controller
{
    public function index(): View
    {
        $revisions = Revision::latest()->paginate(50);

        $userIds = $revisions->pluck('user_id')->filter()->unique();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        return view('dashboard.revisions.index', compact('revisions', 'users'));
    }
}
