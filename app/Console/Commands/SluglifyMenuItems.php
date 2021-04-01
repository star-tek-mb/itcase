<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MenuItem;

class SluglifyMenuItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sluglify:menuitems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create slug for menu items';

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
        $this->info('Generating slug for menu items...');
        foreach (MenuItem::all() as $menuItem) {
            if (empty($menuItem->ru_slug)) {
                $menuItem->generateSlug();
            }
        }
        $this->info('Done!');
    }
}
