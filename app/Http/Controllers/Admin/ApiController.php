<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Admin / Api Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of API access.
    |
    */

    /**
     * Shows the API index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex() {
        return view('admin.api.api');
    }

    /**
     * Generates (or re-generates) an API token.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postGenerateToken(Request $request, UserService $service) {
        if (!$service->generateToken(Auth::user())) {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back()->withInput();
    }

    /**
     * Generates (or re-generates) an API token.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postRevokeToken(Request $request, UserService $service) {
        if (!$service->revokeTokens(Auth::user())) {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        } else {
            flash('Token(s) revoked successfully.')->success();
        }

        return redirect()->back()->withInput();
    }
}
