<?php

namespace App\Jobs;

use Image;
use App\Models\Products;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $upload;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Products $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $disk = config('site.upload_disk');
        $original_file = storage_path() . '/uploads'. $this->upload->image;
    }
}
