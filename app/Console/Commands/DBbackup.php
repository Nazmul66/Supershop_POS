<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class DBbackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dbbackup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = Storage::path('backup/' . 'DB_backup_' . now()->format('d_F_Y_h_i_s_A') . '.sql');

        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST'),
            env('DB_DATABASE'),
            $path
        );

        $process = Process::run($command);

        if( $process->successful() ){
            $this->info("✅ Database backup saved: " . basename($path));
        } else {
            $this->error("❌ Backup failed: " . $process->errorOutput());
        }
    }
}
