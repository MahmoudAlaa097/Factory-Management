<?php
// app/Http/Controllers/FaultController.php

namespace App\Http\Controllers;

class FaultController extends Controller
{
    /**
     * Show the form for creating a new fault request
     */
    public function create()
    {
        // Just return the view - Livewire handles everything else
        return view('fault.create');
    }

    /**
     * Display a listing of fault requests
     */
    public function index()
    {


        return view('fault.index');
    }
}
