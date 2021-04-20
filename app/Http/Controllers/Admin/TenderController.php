<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\NewRequest;
use App\Notifications\TenderPublished;
use App\Repositories\TenderRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function React\Promise\reduce;
use App\Http\Controllers\Helpers\PaginateCollection;

class TenderController extends Controller
{
    /**
     * @var TenderRepositoryInterface
     */
    private $tenderRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(TenderRepositoryInterface $tenderRepository, UserRepositoryInterface $userRepository)
    {
        $this->tenderRepository = $tenderRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function allTenders()
    {
        $tenders = $this->tenderRepository->allOrderedByCreatedAtAdmin();
        $currentCategory = null;
        $tendersCount = $tenders->count();
        $tenders = PaginateCollection::paginateCollection($tenders, 10);

        return view('admin.pages.tenders.alltenders', compact('tenders', 'currentCategory', 'tendersCount'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $tender = $this->tenderRepository->get($id);
        $users = $this->userRepository->getContractors();
        return view('admin.pages.tenders.show', compact('tender', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        if ($request->get('from_category')) {
            $fromCategory = $request->get('from_category');
            $this->tenderRepository->delete($id);
            return redirect()->route('admin.categories.tenders', $fromCategory);
        } else {
            $this->tenderRepository->delete($id);
            return redirect()->route('admin.tenders.all');
        }
    }


    public function createRequest(Request $request, int $id)
    {
        $tender = $this->tenderRepository->get($id);
        $userId = $request->get('user_id');
        if ($tender->requests()->where('user_id', $userId)->count() > 0) {
            return back()->with('info', 'Пользователь уже участвует в конкурсе');
        }
        $request = $tender->requests()->create($request->all());
        if ($tender->owner) {
            $tender->owner->notify(new NewRequest($request));
        }
        return back()->with('success', 'Добалена новая заявка на участие в этом конкурсе!');
    }

    public function publishTender(int $tenderId)
    {
        $tender = $this->tenderRepository->publishTender($tenderId);
        try {
            $tender->owner->notify(new TenderPublished($tender, true));
        } catch (\Exception $e) {}
        return back()->with('success', 'Конкурс опубликован!');
    }
}
