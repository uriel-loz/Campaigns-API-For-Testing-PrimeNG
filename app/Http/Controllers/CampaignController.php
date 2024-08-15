<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request) : object
    {
        $size = $request->size ?? 10;
        $page = $request->page ?? 1;
        $sort_field = $request->sort_field ?? 'updated_at';
        $order = $request->order < 0 ? 'desc': 'asc';

        // delete size and page from request
        unset($request['size'], $request['page'], $request['sort_field'], $request['order']);

        $campaigns = Campaign::where(function($query) use ($request): void {
            foreach ($request->all() as $key => $value) {
                $query->where($key, 'LIKE', "%{$value}%");
            }
        })
        ->orderBy($sort_field, $order)
        ->paginate($size, ['*'], 'page', $page);

        return response()->json($campaigns);
    }
}
