<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database và upload lên Google Drive';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Tạo backup từ database
        // $mysqldumpPath = env('MYSQLDUMP_PATH', 'mysqldump');
        // $command = "\"{$mysqldumpPath}\" --user=" . env('DB_USERNAME') .
        //             " --password=" . env('DB_PASSWORD') .
        //             " --host=" . env('DB_HOST') .
        //             " " . env('DB_DATABASE') . " > " . $backupPath;
        $fileName = 'backup_' . Carbon::now()->format('Y_m_d_H_i_s') . '.sql';
        $path = storage_path('logs/' . $fileName);

        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$path}";

        $returnVar = null;
        $output = null;
        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            // Mở file backup để đọc theo từng phần (stream)
            $stream = fopen($path, 'r');

            if ($stream) {
                // Lưu file lên Google Drive theo stream
                Storage::disk('google')->put($fileName, $stream);
                fclose($stream);
                unlink($path);

                $this->info(Carbon::now()->format('d/m/Y') . ': Backup CSDL thành công.');
            } else {
                $this->info(Carbon::now()->format('d/m/Y') . ': Không tìm thấy file backup');
            }
        } else {
            $this->info(Carbon::now()->format('d/m/Y') . ': Backup thất bại');
        }

        return 0;
    }
}