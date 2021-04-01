<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\CguSite;
use App\Models\CguCategory;
use Illuminate\Support\Facades\File;
use App\Models\Company;

class MigrateCguToHandbook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:cgutohandbook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate concrete CGU sites to Handbook as companies';

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
     * @return mixed
     */
    public function handle()
    {
        $companyDirectory = public_path() . '/' . Company::UPLOAD_DIRECTORY;
        $siteDirectory = public_path() . '/' . CguSite::UPLOAD_FILE_PATH;

        $publicInfo = CguCategory::find(30);
        $mediaInfo = CguCategory::find(31);

        $this->info('Collecting data...');

        $publicCategories = $publicInfo->descendants()->pluck('id');
        $publicCategories[] = $publicInfo->getKey();

        $mediaCategories = $mediaInfo->descendants()->pluck('id');
        $mediaCategories[] = $mediaInfo->getKey();

        $categories = array_merge($publicCategories->toArray(), $mediaCategories->toArray());
        $sites = CguSite::whereIn('category_id', $categories)->get();

        $this->info('Starting migration...');

        foreach ($sites as $site) {
            $this->info("Migrating site $site->ru_title into companies");
            $newCompany = Company::create([
                'ru_title' => $site->ru_title,
                'ru_description' => $site->ru_description,
                'active' => $site->active,
                'url' => $site->link
            ]);
            if ($site->image) {
                $newCompany->image = $site->image;
                try {
                    File::copy($siteDirectory . $site->image, $companyDirectory . $site->image);
                } catch (\Exception $e) {
                    $this->error($e);
                }
                $newCompany->save();
            }
            $this->info('Done!');
        }
    }
}
