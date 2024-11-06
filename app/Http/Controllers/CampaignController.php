<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
     * Display list of campaigns and aggregate revenue for each campaign
     */
    public function index()
    {
        //get campaings with pagination and aggregate revenue
        $campaigns = Campaign::query()
            ->leftJoin('campaign_stats', 'campaigns.id', '=', 'campaign_stats.campaign_id')
            ->select('campaigns.*', DB::raw('sum(campaign_stats.revenue) as total_revenue'))
            ->groupBy('campaigns.id')
            ->orderBy('total_revenue', 'desc')
            ->paginate(20);

        return view('campaign.index', compact('campaigns'));
    }

    /**
     * Display a specific campaign with a hourly breakdown of all revenue
     */
    public function show(Campaign $campaign)
    {
        // @TODO implement
    }

    /**
     * Display a specific campaign with the aggregate revenue by utm_term
     */
    public function publishers(Campaign $campaign)
    {
        // @TODO implement
    }
}
