<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Complaint;
use App\Models\JobOrder;
use Illuminate\Support\Facades\Log;

class CleanOldComplaints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complaints:clean-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Soft delete complaints that have been resolved or rejected for more than 10 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = Carbon::now()->subDays(10);

        $complaintIds = Complaint::whereIn('status',['resolved','rejected'])
        ->where('updated_at','<=',$thresholdDate)
        ->pluck('id');

        if($complaintIds->isEmpty()){
            $this->info("No old complaints found to clean up.");
            return;
        }

        $deletedJobsCount = JobOrder::whereIn('complaint_id', $complaintIds)->delete();
        $deletedComplaintsCount = Complaint::whereIn('id',$complaintIds)->delete();

        $this->info("Successfully soft deleted {$deletedComplaintsCount} complaints and {$deletedJobsCount} related job orders.");
        Log::info("Cleanup Command: Soft deleted {$deletedComplaintsCount} complaints and {$deletedJobsCount} related job orders.");
    }
}
