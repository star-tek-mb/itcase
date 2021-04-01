<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HandbookCategory;

class HideCompaniesPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companies:hidepages {category}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hide company pages from concrete category';

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
        $categoryId = $this->argument('category');
        $category = HandbookCategory::find($categoryId);
        if (!$category) {
            $this->error('Category not found');
            return;
        }
        foreach ($category->getAllCompaniesFromDescendingCategories() as $company) {
            $this->info("Прячем компанию $company->ru_title...");
            $company->show_page = false;
            $company->save();
            $this->info('Готово!\n');
        }
    }
}
