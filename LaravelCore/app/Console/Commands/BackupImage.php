<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BackupImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup images to Google Drive';

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
        $localFolderPath = storage_path('app/public');

        if (!is_dir($localFolderPath)) {
            $this->error('The public folder does not exist.');
            return 1;
        }

        $this->uploadFolderToGoogleDrive($localFolderPath, env('GOOGLE_DRIVE_IMAGE_FOLDER_ID', '17ctllpACoRew3EioYKYqMXKoS-cjzWnD'));

        $this->info(Carbon::now()->format('d/m/Y') . ': Successfully backed up images to Google Drive');
        return 0;
    }

    function createGoogleDriveFolder($folderName, $parentFolderId = null)
    {
        $fileMetadata = new DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);

        // thêm vào thuộc tính parents
        if ($parentFolderId) {
            $fileMetadata->setParents([$parentFolderId]);
        }
        $folder = Storage::disk('google')->getAdapter()->getService()->files->create($fileMetadata);
        return $folder->id;
    }


    //Recursive upload folder to googole drive
    function uploadFolderToGoogleDrive($localFolderPath, $googleDriveParentFolderId = null)
    {
        $folderName = basename($localFolderPath) . ($googleDriveParentFolderId == '17ctllpACoRew3EioYKYqMXKoS-cjzWnD' ? '_' . Carbon::now()->format('Y-m-d_H-i-s') : '');
        $googleDriveFolderId = $this->createGoogleDriveFolder($folderName, $googleDriveParentFolderId);

        foreach (File::glob($localFolderPath . '/*') as $item) {
            if (is_dir($item)) {
                $this->uploadFolderToGoogleDrive($item, $googleDriveFolderId);
            } else {
                $filePath = $item;
                $fileName = basename($filePath);
                $stream = fopen($filePath, 'r+');

                Storage::disk('google')->put($googleDriveFolderId . '/' . $fileName, $stream);
                fclose($stream);
            }
        }
    }
}
