<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\DateTimeHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back.dashboard', []);
    }
}
