<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

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
        $filters = $request->filters ?? [];

        $filters = $this->convertToArrayFilter($filters);

        $campaigns = Campaign::where(function($query) use ($filters): void {
            foreach ($filters as $key => $value) {
                $query->where($key, 'LIKE', "%{$value}%");
            }
        })
        ->orderBy($request->sort_field, $order)
        ->paginate($request->size, ['*'], 'page', $request->page);

        return response()->json($campaigns);
    }

    private function convertToArrayFilter($filters) : array
    {
        if (!$filters) 
            return [];

        $all_filters = [];

        $input_filters = array_values(array_filter(explode('&', $filters)));
            
        foreach ($input_filters as $filter) {
            list($field, $value) = explode('=', $filter);
            $all_filters[$field] = $value;
        }

        return $all_filters;
    }
}
