<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FrequencyController extends Controller
{
    public function uploadPOFFile(Request $request)
    {
        //
        $file = $request->file('pof')->store('vatsim_pof');
        return response()->json([
            'file' => $file
        ]);

    }
    public function importFrequencies(Request $request)
    {
        //
    }

}
