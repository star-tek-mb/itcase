<?php

namespace App\Console\Commands;

use App\Models\Tender;
use Illuminate\Console\Command;

class CheckTendersDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenders:checkdeadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command check all tenders\' deadlines and delete requests';

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
        $tenders = Tender::where('deadline', '<', now())->get();
        foreach ($tenders as $tender) {
            $tender->opened = false;
            $tender->save();
            $tender->requests()->delete();
        }
    }
}
