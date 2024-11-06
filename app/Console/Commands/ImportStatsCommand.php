<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignStat;
use App\Models\Term;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-stats {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stats from CSV files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * we should implement this feature with Queue, as it can take a long time to import stats
         * in queue job we should send chunk of data to the queue, and then process it
         */
        //get the filename from the command line argument

        try {

            $filename = $this->argument('filename');

            $fh = fopen(storage_path($filename), 'r');

            if ($fh === false) {
                $this->error($filename.' not found');
                return;
            }

            //get all campaign
            //making campaing in lowercase, as utm_campaing (krbedsnakedroid) is unique in database, but has different case in csv
            $campaigns = Campaign::all()->pluck('id', 'utm_campaign')->mapWithKeys(function ($id, $utm_campaign) {
                return [strtolower($utm_campaign) => $id];
            })->toArray();

            $terms = Term::all()->pluck('id', 'utm_term')->mapWithKeys(function ($id, $utm_term) {
                return [strtolower($utm_term) => $id];
            })->toArray();

            $isHeader = true;
            $count = 0;
            while ($row = fgetcsv($fh)) {

                $count++;

                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                $campaign = strtolower($row[0]);
                $term = strtolower($row[1]);
                $timestamp = $row[2];
                $revenue = $row[3];

                //check if campaign or term  null, then skip inserting stats
                if (empty($campaign) || empty($term) || $campaign == 'null' || $term == 'null') {
                    $this->error('Campaign or term is empty at row '.$count . ', timestamp' . $timestamp);
                    continue;
                }

                $campaignId = $campaigns[$campaign] ?? null;
                $termId = $terms[$term] ?? null;

                //if campagin not found, insert new campaign
                if (!$campaignId) {
                    $campaignId = Campaign::create([
                        'utm_campaign' => $campaign,
                        'name' => $campaign,
                    ])->id;

                    //add in the campaigns array, so we don't have to query the database again
                    $campaigns[$campaign] = $campaignId;
                }

                //if term not found in database, insert new term
                if (!$termId) {
                    $termId = Term::create([
                        'utm_term' => $term,
                        'name' => $term,
                    ])->id;

                    //add in the terms array, so we don't have to query the database again
                    $terms[$term] = $termId;
                }

                //insert stats
                CampaignStat::create([
                    'campaign_id' => $campaignId,
                    'term_id' => $termId,
                    'monetization_timestamp' => $timestamp,
                    'revenue' => $revenue,
                ]);

            }

            fclose($fh);

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

    }
}
