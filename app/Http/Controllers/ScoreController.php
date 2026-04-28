<?php

namespace App\Http\Controllers;

use App\Models\Scorename;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index()
    {
        // Eloquent ORM 查询，替代原来的 mysqli
        $scores = Scorename::all();
        
        return view('scores.index', compact('scores'));
    }
}
