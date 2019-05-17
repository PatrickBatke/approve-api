<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Authentification\User;
use App\Models\Authentification\Password_reset;

class PwResetLinkCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pw;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Password_reset $pw)
    {
        //
        $this->pw = $pw;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date2 = Carbon::now();
        $diff = abs(strtotime($this->pw->created_at) - strtotime($date2));
        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24))/24;
        if ($hours > 24) {
            $this->pw = null;
            $pw->save();
        }
    }
}
