<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignStat;
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
        $stats = CampaignStat::where('campaign_id', $campaign->id)
                    ->selectRaw('DATE(monetization_timestamp) as date, hours, SUM(revenue) as total_revenue')
                    ->groupBy('date', 'hours')
                    ->orderBy('date')
                    ->orderBy('hours')
                    ->paginate(24);

        return view('campaign.campaign', compact('campaign', 'stats'));
    }

    /**
     * Display a specific campaign with the aggregate revenue by utm_term
     */
    public function publishers(Campaign $campaign)
    {
        $termStats = CampaignStat::where('campaign_id', $campaign->id)
            ->join('terms', 'terms.id', '=', 'campaign_stats.term_id')
            ->select('terms.utm_term', 'terms.id')
            ->selectRaw('SUM(campaign_stats.revenue) as total_revenue')
            ->groupBy('terms.id')
            ->orderBy('total_revenue', 'desc')
            ->paginate(20);

        return view('campaign.publisher', compact('campaign', 'termStats'));
    }
}
