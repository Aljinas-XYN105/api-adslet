<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SmsCampaign;

class SendSmsCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaignId;
    
    public function __construct(int $campaignId)
    {
        $this->campaignId = $campaignId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // // Fetch the SMS campaign from the database
        // $campaign = SmsCampaign::findOrFail($this->campaignId);

        // // Update the campaign queue status to 'processing'
        // $campaign->queue_status = 'processing';
        // $campaign->save();

        // // Your logic to send SMS messages goes here
        // // For example, you could use a third-party SMS gateway API
        // // to send the SMS messages based on the campaign details

        // // Once the SMS messages have been sent, update the campaign status
        // $campaign->status = 'finished';
        // $campaign->queue_status = 'completed';
        // $campaign->save();

        $campaign = SmsCampaign::findOrFail($this->campaignId);

        $campaign->queue_status = 'processing';
        $campaign->save();

        // Your logic to send SMS messages goes here

        $campaign->status = SmsCampaign::STATUS_FINISHED;
        $campaign->queue_status = 'completed';
        $campaign->save();
    }

    public function failed(\Throwable $exception)
    {
        $campaign = SmsCampaign::findOrFail($this->campaignId);

        $campaign->queue_status = 'failed';
        $campaign->save();

        // You can also log the exception or send a notification here
    }
}
