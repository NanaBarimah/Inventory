<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Region;
use App\Equipment;
use Illuminate\Http\Request;

use Auth;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donations = Donation::with('hospital')->get();

        return view('admin.donations', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $admin = Auth::guard("admin")->user();
        
        $region = Region::with("districts", "districts.hospitals", "equipment")->where("id", $admin->region_id)->first();
        return view("admin.donation-add", compact("region", "admin"));
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

        $donation->id = md5('Donation'.microtime().rand(1, 1000));
        $donation->region_id = $request->region_id;
        $donation->hospital_id = $request->hospital_id;
        $donation->title = $request->title;
        $donation->date_donated = $request->date_donated != null ? date('Y-m-d', \strtotime($request->date_donated)) : null;
        $donation->description = $request->description;
        $donation->presented_by = $request->presented_by;
        $donation->presented_to = $request->presented_to;

        if($donation->save()) {
            Equipment::whereIn("id", $request->equipment)->update(["donation_id" => $donation->id]);
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
        $donation = $donation->with("equipment", "hospital")->first();
        return view("admin.donation-details", compact("donation"));
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
