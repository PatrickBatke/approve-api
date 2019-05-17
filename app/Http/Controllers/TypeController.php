<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    //
    /**
     * Show all Projects.
     *
     * @return Response
     */
    public function getTypes()
    {
        return Type::all();
    }
}
