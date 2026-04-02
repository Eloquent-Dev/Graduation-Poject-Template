<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobOrder;
use Illuminate\Support\Facades\Log;

class EscalateJobPriorities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:escalate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically escalate priorities of pending/in-progress job orders based on allowance time.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $activeJobs = JobOrder::whereIn('status', ['pending', 'in_progress'])->get();
        $escalatedCount = 0;

        foreach($activeJobs as $job){

        $allowanceHours = $job->complaint->category->allowance_period * 24;

        if($allowanceHours == 0) continue;

        $hoursElapsed = $job->created_at->diffInHours(now());

        $percentElapsed = $hoursElapsed / $allowanceHours;

        $newPriority = $job->priority;

        if($percentElapsed >= 0.66){
            $newPriority = 'high';
        }elseif($percentElapsed >= 0.33){
            if($job->priority == 'low'){
            $newPriority = 'medium';
            }
        }

        if($newPriority !== $job->priority){
            $job->update(['priority' => $newPriority]);
            $escalatedCount++;
            Log::info("Job Order # {$job->id} automatically escalated to {$newPriority} priority.");
        }

        }

        $this->info("Escalation complete! {$escalatedCount} jobs updated.");
    }
}
