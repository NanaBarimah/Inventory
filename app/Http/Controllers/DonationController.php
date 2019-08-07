<?php

namespace App\Http\Controllers;

use App\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donation = Donation::with('equipment')->get();

        return view('all-donations', compact('donation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required',
            'hospital_id' => 'required',
            'date_donated' => 'required'
        ]);

        $donation = new Donation();

        $donation->id = md5('Donation'.microtime().rand(1000));
        $donation->region_id = $request->region_id;
        $donation->hospital_id = $request->hospital_id;
        $donation->date_donated = $request->date_donated != null ? date('Y-m-d', \strtotime($request->date_donated)) : null;
        $donation->description = $request->description;
        $donation->presented_by = $request->presented_by;
        $donation->presented_to = $request->presented_to;

        if($donation->save()) {
            return response()->json([
                'error' => false,
                'data' => $donation,
                'message' => 'Donation saved successfully'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Could not save donation. Try again!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function show(Donation $donation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donation $donation)
    {
        //
    }
}
