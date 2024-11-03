<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexEditProfile() {  //edit profile admin
        return view ('pages.admin.edit-profile');
    }
}
