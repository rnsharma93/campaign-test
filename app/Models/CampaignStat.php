<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignStat extends Model
{
    use HasFactory;

    protected $guarded = [];

    //add observer to update campaign stats
    protected static function booted(): void
    {
        static::saving(function (CampaignStat $campaignStat) {
            //get hour from timestamp
            $campaignStat->hours = date("H", strtotime($campaignStat->monetization_timestamp));
        });
    }

}
