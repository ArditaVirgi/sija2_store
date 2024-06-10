<?php

namespace app\Http\Controllers;

use app\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the reosource.
     */
    public function index()
    {
        return view('home.index', [
            'title' => 'Home - Sija\'s Store',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'CREATED';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return 'STORE';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'EDIT' . $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 'UPDATED';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return 'DESTROY';
    }
}
