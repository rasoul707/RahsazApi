<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UserAgentLocationApiCall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $log;
    protected $ip;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($log, $ip)
    {
        $this->log = $log;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $location = Http::get('http://ip-api.com/json/'. $this->ip);
        $this->log->location = $location->body();
        $this->log->save();
    }
}
