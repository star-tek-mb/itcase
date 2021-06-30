<?php

namespace App\View\Components;

use App\Repositories\TenderRepository;
use App\Repositories\UserRepository;

use Illuminate\View\Component;
use Whoops\Exception\ErrorException;

class Search extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $contractors;
    public $tenders;

    public function __construct($search)
    {

        $user = new UserRepository();
        $tender = new TenderRepository();
        if ($search != null) {
            $this->contractors = $user->searchContractorsByName($search);
            $this->tenders = $tender->searchTenderByTitle($search);
        } else {
            $this->contractors = collect([]);
            $this->tenders = collect([]);
        }
//        dd($this->contractors);
//        dd($this->tenders);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.search');
    }
}
