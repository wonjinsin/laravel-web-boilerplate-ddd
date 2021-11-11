<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class TasksController extends Controller
{
    public function index(\Illuminate\Http\Request $request, $userId){
        return UserRepository::getUser($userId);
    }
}
