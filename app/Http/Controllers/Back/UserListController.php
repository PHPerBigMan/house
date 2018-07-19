<?php

namespace App\Http\Controllers\Back;

use App\Model\Buy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserListController extends Controller
{
    public function index($id){
        $data = Buy::with('list_use')->findOrFail($id);

        $title = 'list';

        return view('Back.UserList.index',compact('data','title'));
    }
}
