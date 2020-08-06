<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class MapEmbedController extends Controller
{
    public function index($id) {
        $map = Map::find($id);
        return view('embeds', ['data' => $map]);
    }
    public function createMap(Request $request) {
        $map = new Map();

        $map->name = $request->input('name');
    }
}
