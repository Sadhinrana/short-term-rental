<?php

namespace App\Jobs;

use App\JobInQueue;
use Illuminate\Bus\Queueable;
use App\Imports\NooPropertyImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NooPropertyPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($podcast)
    {
        $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->podcast->file_url != '' && file_exists(public_path($this->podcast->file_url))) {
            Excel::import(new NooPropertyImport, public_path($this->podcast->file_url));

            $data = JobInQueue::find($this->podcast->id);
            $data->status = 2;
            $data->save();
        }
    }
}
