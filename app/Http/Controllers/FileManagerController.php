<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FileManagerController extends Controller {
    public function index() {
        if( !Auth::check() || !Auth::user()->isStaff || !Auth::user()->hasPower('manage_files') ) {
            abort(404);
        }
        return view('filemanager');
    }
}
