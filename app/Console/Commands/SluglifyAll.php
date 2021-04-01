<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\HandbookCategory;
use App\Models\Company;
use App\Models\NeedType;

class SluglifyAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sluglify:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create slug for companies, categories, types of needs';

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
        $this->info('Generating slug for companies, categories, types of needs');
        $this->info('Generating slug for types of needs...');
        foreach (NeedType::all() as $needType) {
            if (empty($needType->ru_slug)) {
                $needType->generateSlug();
            }
        }
        $this->info('Done!');

        $this->info('Generating slug for categories...');
        foreach (HandbookCategory::all() as $category) {
            if (empty($category->ru_slug)) {
                $category->generateSlug();
            }
        }
        $this->info('Done!');

        $this->info('Generating slug for companies. It can be take several minutes...');
        foreach (Company::all() as $company) {
            if (empty($company->ru_slug)) {
                $company->generateSlug();
            }
        }
        $this->info('Done!');
        $this->info('Slugs for companies, categories and types of needs generated successfully!');
    }
}
