<?php


namespace App\Repositories;

use App\Models\Tender;
use App\Models\TenderRequest;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class TenderRepository implements TenderRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function all()
    {
        return Tender::all();
    }

    /**
     * @inheritDoc
     */
    public function allOrderedByCreatedAt($withoutContractors = false, $map=false)
    {
        $query = Tender::whereNotNull('owner_id')->where('published', true)->whereNull('delete_reason');
        if ($withoutContractors) {
            $query = $query->whereNull('contractor_id');
        }
        if ($map) {
            $query = $query->whereNotNull('geo_location');
        }

        return $query->whereNotNull('owner_id')->orderBy('opened', 'desc')->orderBy('created_at', 'desc')->get();
    }

    public function TenderSearch($search)
    {
        $query = Tender::whereNotNull('owner_id')->where('published', true)->whereNull('delete_reason');
        return $query->whereNotNull('owner_id')->where('title', 'like', '%'.$search->search.'%')->orderBy('opened', 'desc')->orderBy('created_at', 'desc')->get();
    }
    public function allOrderedByCreatedAtAdmin($withoutContractors = false)
    {
        $query = Tender::whereNotNull('owner_id')->where('published', true)->whereNull('delete_reason');
        if ($withoutContractors) {
            $query = $query->whereNull('contractor_id');
        }
        return $query->whereNotNull('owner_id')->orderBy('created_at', 'desc')->get();
        //orderBy('created_at', 'desc') orderByRaw('-contractor_id asc')
    }

    /**
     * @inheritDoc
     */
    public function create($data)
    {
        $tenderData = $data->all();
        $user = auth()->user();
        if ($user) {
            $tenderData['client_name'] = $user->name;
            $tenderData['client_email'] = $user->email;
            $tenderData['client_phone_number'] = $user->phone_number || '';
            $tenderData['client_type'] = $user->customer_type;
            $tenderData['owner_id'] = $user->id;
        } else {
            $tenderData['client_name'] = '';
            $tenderData['client_type'] = '';
            $tenderData['client_phone_number'] = '';
        }
        if (Arr::get($tenderData, 'remote')=='on') {
            $tenderData['type']='remote';
        }
        $tenderData['deadline'] = Carbon::createFromFormat('d.m.Y', $data->get('deadline'))->setHour(23)->setMinutes(59)->setSecond(59)->format('Y-m-d H:i:s');
        $tenderData['work_start_at'] = Carbon::createFromFormat('d.m.Y H:i', $data->get('work_start_at'));
        $tenderData['work_end_at'] = Carbon::createFromFormat('d.m.Y H:i', $data->get('work_end_at'));
        $tender = Tender::create($tenderData);

        $tender->saveFiles($data->file('files'));
        //change $data->get('categories')
        foreach ($data->categories as $categoryId) {
            $tender->categories()->attach($categoryId);
        }
        return $tender;
    }

    /**
     * @inheritDoc
     */
    public function update($id, $data)
    {
        $tender = $this->get($id);
        $tenderData = $data->all();
        $tenderData['deadline'] = Carbon::createFromFormat('d.m.Y', $data->get('deadline'))->setHour(23)->setMinutes(59)->setSecond(59)->format('Y-m-d H:i:s');
        if (Arr::get($tenderData, 'remote')=='on') {
            $tenderData['type']='remote';
        }
        $tender->update($tenderData);
        $tender->saveFiles($data->file('files'));
        $tender->categories()->detach();
        foreach ($data->get('categories') as $categoryId) {
            $tender->categories()->attach($categoryId);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete($id, $reason = '')
    {
        $tender = Tender::find($id);
        $tender->forceFill([
            'delete_reason' => $reason
        ])->save();
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        return Tender::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getBySlug(string $slug)
    {
        return Tender::where('slug', $slug)->first();
    }

    /**
     * @inheritDoc
     */
    public function createRequest($data)
    {
        return TenderRequest::create($data->all());
    }

    /**
     * @inheritDoc
     */
    public function cancelRequest($requestId)
    {
        $request = TenderRequest::findOrFail($requestId);
        $request->delete();
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function acceptRequest($tenderId, $requestId)
    {
        $tender = $this->get($tenderId);
        $request = TenderRequest::findOrFail($requestId);
        if ($tender->contractor) {
            return false;
        }
        abort_if($tender->owner->id !== auth()->user()->id, 401);
        $tender->contractor_id = $request->user_id;
        $tender->opened = false;
        $tender->save();
        $request->user->victories_count+=1;
        $request->user->save();
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function setOwnerToTender($tenderId, $userId)
    {
        $tender = $this->get($tenderId);
        $tender->owner_id = $userId;
        $tender->save();
    }

    /**
     * @inheritDoc
     */
    public function addContractor($tenderId, $contractorId)
    {
        return TenderRequest::create([
            'user_id' => $contractorId,
            'tender_id' => $tenderId,
            'invited' => true
        ]);
    }

    /**
     * @inheritDoc
     */
    public function publishTender($tenderId)
    {
        $tender = $this->get($tenderId);
        $tender->published = true;
        $tender->published_at = now();
        $tender->save();
        return $tender;
    }
}
