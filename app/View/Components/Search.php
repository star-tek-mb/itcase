<?php

namespace App\View\Components;

use App\Models\Page;
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
    public $search;
    public $pages;
    public function __construct($search)
    {

        $user = new UserRepository();
        $tender = new TenderRepository();
        $this->search = $search;
        if ($search != null) {
            $this->contractors = $user->searchContractorsByName($search);
            $this->tenders = $tender->searchTenderByTitle($search);
            $this->pages = Page::where('title', 'LIKE', '%' . $search . '%')->get();
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
