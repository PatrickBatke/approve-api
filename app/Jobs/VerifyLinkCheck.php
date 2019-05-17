<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use  Carbon\Carbon;
use App\Models\Authentification\User;

class VerifyLinkCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date2 = Carbon::now();
        $diff = abs(strtotime($this->user->created_at) - strtotime($date2));
        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24))/24;
        //
        if ($hours > 24) {
            $this->user->resettoken($this->user->token, "verify");
        }
    }
}
