<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request) {
        return view('admin.user.index');
    }

    public function add(Request $request) {
        return view('admin.user.add');
    }

    public function edit(Request $request) {
        return view('admin.user.edit');
    }

    public function delete(Request $request) {
        return view('admin.user.delete');
    }
}
