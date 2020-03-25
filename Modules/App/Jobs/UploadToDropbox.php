<?php

namespace Modules\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadToDropbox implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $fileUnZip;
    private $xmlString;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileUnZip, $xmlString)
    {
        $this->fileUnZip = $fileUnZip;
        $this->xmlString = $xmlString;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // define dropbox storage
        $client = new Client(env('DROPBOX_TOKEN'));

        // upload to dropbox
        $dropboxFilePath = $this->fileUnZip . "_" . strtotime("now") . '.plist';
        Storage::disk('dropbox')->put($dropboxFilePath, $this->xmlString);

        // get share link
        $client->createSharedLinkWithSettings($dropboxFilePath);
        $shareLink = $client->listSharedLinks($dropboxFilePath);
        $pathPlist = $shareLink[0]['url'];
        $pathSave = str_replace('www.dropbox.com', 'www.dl.dropboxusercontent.com', $pathPlist);
        $pathSave = str_replace('?dl=0', '', $pathSave);
        $pathSave = "itms-services://?action=download-manifest&url=" . $pathSave;
        return $pathSave;
    }
}
