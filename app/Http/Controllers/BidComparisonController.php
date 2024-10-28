<?php

namespace App\Http\Controllers;

use App\Models\BidComparison;
use Illuminate\Http\Request;

class BidComparisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bidComparisons = BidComparison::get();
        $lowestBid = BidComparison::orderBy('unit_cost', 'ASC')->first();
        $qty = 1;

        return view('bid-comparison.index', compact('bidComparisons', 'lowestBid', 'qty'));
    }

    public function updatedVersion(Request $request)
    {
        $bidComparisons = BidComparison::get();
        $selectedBid = BidComparison::where('id', $request->id)->first();
        $qty = 1;
        $data['success']['html'] = view('bid-comparison.updated-version', compact('bidComparisons', 'selectedBid', 'qty'))->render();
        return response()->json($data);
    }
}
