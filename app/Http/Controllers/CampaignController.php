<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    public function index(Request $request) : object
    {
        $request->validate([
            'page' => 'integer|min:1',
            'size' => 'integer|min:1',
            'sort_field' => 'string',
            'order' => 'integer',
        ]);

        $order = $request->order < 0 ? 'desc': 'asc';
        $filters = json_decode($request->filters, true) ?? [];

        $filters = convertToArrayFilter($filters);

        $campaigns = Campaign::where(function($query) use ($filters): void {
            foreach ($filters as $key => $value) {
                $query->where($key, 'LIKE', "%{$value}%");
            }
        })
        ->orderBy($request->sort_field, $order)
        ->paginate($request->size, ['*'], 'page', $request->page);

        return response()->json($campaigns);
    }

    // public function index(Request $request) : object
    // {
    //     $request->validate([
    //         'page' => 'integer|min:1',
    //         'size' => 'integer|min:1',
    //         'sort_field' => 'string',
    //         'order' => 'integer',
    //     ]);

    //     $order = 1 ? 'desc': 'asc';
    //     $filters = $request->filters ?? [];

    //     $filters = convertToArrayFilter($filters);

    //     $campaigns = Campaign::where(function($query) use ($filters): void {
    //         foreach ($filters as $key => $value) {
    //             $query->where($key, 'LIKE', "%{$value}%");
    //         }
    //     })
    //     // ->orderBy($request->sort_field, $order)
    //     ->paginate(10, ['*'], 'page', 1);

    //     return response()->json($campaigns);
    // }

    public function store(Request $request) : object
    {
        try {
            Validator::make($request->all(), [
                'campaign_name' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ])->validate();

            $campaign = Campaign::create($request->all());

            return response()->json($campaign, 201);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function show(Campaign $campaign) : object
    {
        return response()->json($campaign);
    }

    public function update(Request $request, Campaign $campaign) : object
    {
        try {
            Validator::make($request->all(), [
                'campaign_name' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ])->validate();

            $campaign->update($request->all());

            return response()->json($campaign);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function destroy(Campaign $campaign) : object
    {
        $campaign->delete();

        return response()->json(['message' => 'Campaign deleted successfully']);
    }
}
