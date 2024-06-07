<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    function index(DashboardChart $chart)
    {
        // $data['chart'] = $chart->build();
        return view('sistema.dashboard.index');
    } 
}

