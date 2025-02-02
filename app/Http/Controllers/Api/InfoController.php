<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Character\Character;
use Illuminate\Http\Request;

class InfoController extends Controller {
    public function getCharacter(Request $request) {
        $character = Character::findOrFail($request->id);

        return response()->json($character);
    }
}
