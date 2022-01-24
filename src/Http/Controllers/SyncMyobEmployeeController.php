<?php

namespace Dcodegroup\LaravelMyobEmployee\Http\Controllers;

use App\Models\User;
use Dcodegroup\LaravelMyobEmployee\Jobs\SyncMyobEmployee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SyncMyobEmployeeController
{
    public function __invoke(Request $request, User $user): Response
    {
        SyncMyobEmployee::dispatch($user);

        return response(__('Job has been dispatched to sync the employee'));
    }
}
