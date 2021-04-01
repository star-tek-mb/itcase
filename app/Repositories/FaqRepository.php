<?php


namespace App\Repositories;

use App\Models\FaqGroup;
use App\Models\FaqItem;
use Illuminate\Database\Eloquent\Collection;

class FaqRepository implements FaqRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function all()
    {
        return FaqGroup::all();
    }

    /**
     * @inheritDoc
     */
    public function get(int $faqId)
    {
        return FaqGroup::findOrFail($faqId);
    }

    /**
     * @inheritDoc
     */
    public function create($faqData)
    {
        $faqGroup = FaqGroup::create($faqData->all());
        if ($faqData->has('items')) {
            foreach ($faqData->get('items') as $item) {
                $faqGroup->items()->create($item);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function update(int $faqId, $faqData)
    {
        $faq = $this->get($faqId);
        $faq->update($faqData->all());

        if (!$faqData->has('items')) {
            $faq->items()->delete();
        } else {
            $items = $faqData->get('items');
            $currentItems = $faq->items;
            foreach ($currentItems as $key => $currentItem) {
                if (!isset($items[$key])) {
                    $currentItem->delete();
                } else {
                    $currentItem->update($items[$key]);
                }
            }
            foreach ($items as $key => $item) {
                if (!isset($currentItems[$key])) {
                    $faq->items()->create($item);
                }
            }
        }

        return $faq;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $faqId)
    {
        FaqGroup::destroy($faqId);
    }
}
