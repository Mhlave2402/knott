<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        return view('public.competitions');
    }

    public function show($competitionId)
    {
        // Show competition details logic
    }

    public function enter($competitionId)
    {
        // Handle competition entry logic
    }
}
