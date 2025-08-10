<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FilesCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prunes files older than an hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = File::where('created_at', '<=', now()->addHours(-1))->get();

        foreach($files as $file) {
            Storage::disk('files')->deleteDirectory($file->uid);
            $file->delete();
        }
    }
}
