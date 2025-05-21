<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BelajarController extends Controller
{
    public function index()
    {

        $user = auth()->user();
        $users = User::all();
        return inertia('BelajarVue', [
            'user' => $user,
            'users' => $users,
        ]);
    }
    public function sayHello()
    {
        return inertia('SayHello');
    }
    public function style()
    {
        return inertia('Style');
    }
    public function score()
    {
        return inertia('Score');
    }
    public function todolist()
    {
        return inertia('Todolist');
    }
}
