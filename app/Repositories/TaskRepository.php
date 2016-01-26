<?php

namespace App\Repositories;


use App\User;
use App\Task;
use DB;

class TaskRepository
{
    /**
     * @param User $user
     * @return App\Task[]
     */
    public function forUser(User $user)
    {
//        return $user->tasks()->getResults();

        return Task::with('user') // Eager loading: https://laravel.com/docs/5.2/eloquent-relationships#eager-loading
            ->withTrashed()
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}