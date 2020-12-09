<?php

namespace App\Console\Commands;

use App\Models\HandbookCategory;
use App\Models\MenuItem;
use Illuminate\Console\Command;

class MakeMetaTitlePrefixes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:metaprefixes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create prefixes for categories in tenders';

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
        $categories = HandbookCategory::all();
        $metaWords = ['Тендеры по', 'Заказы по', 'Работа по'];
        foreach ($categories as $category) {
            $category->tender_meta_title_prefix = $metaWords[array_rand($metaWords)];
            $category->save();
        }
        $menuItems = MenuItem::all();
        foreach ($menuItems as $item) {
            $item->tender_meta_title_prefix = $metaWords[array_rand($metaWords)];
            $item->save();
        }
    }
}
