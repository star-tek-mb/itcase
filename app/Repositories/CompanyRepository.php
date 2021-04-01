<?php


namespace App\Repositories;

use App\Models\Company;
use App\Models\NeedType;
use App\Models\Service;
use Illuminate\Support\Str;

class CompanyRepository implements CompanyRepositoryInterface
{

    /**
     * All handbooks
     *
     * @param mixed $paginate
     * @return mixed
     */
    public function all($paginate = null)
    {
        if ($paginate) {
            return Company::orderBy('position', 'asc')->paginate($paginate);
        } else {
            return Company::orderBy('position', 'asc')->get();
        }
    }

    /**
     * Get company by id
     *
     * @param int $companyId
     * @return Company
     */
    public function get(int $companyId)
    {
        return Company::find($companyId);
    }

    /**
    * Get favourites companies
    *
    * @return array
    */
    public function getFavourites()
    {
        return Company::where('favourite', true)->orderBy('position', 'asc')->get();
    }

    /**
     * Create a company
     *
     * @param \Illuminate\Http\Request $companyData
     * @return Company
     */
    public function create($companyData)
    {
        $company = Company::create($companyData->all());
        if ($companyData->has('favourite')) {
            $company->favourite = true;
            $company->save();
        }
        if ($companyData->has('showPage')) {
            $company->show_page = true;
            $company->save();
        }
        if (empty($companyData->get('ru_slug'))) {
            $company->generateSlug();
        }
        $company->uploadImage($companyData->file('image'));
        $services = $companyData->get('services');
        $company->services()->attach($services);
        return $company;
    }

    /**
     * Update a company
     *
     * @param int $companyId
     * @param \Illuminate\Http\Request $companyData
     * @return Company
     */
    public function update(int $companyId, $companyData)
    {
        $company = $this->get($companyId);
        $company->update($companyData->all());
        if ($companyData->has('favourite')) {
            $company->favourite = true;
        } else {
            $company->favourite = false;
        }
        $company->save();
        if ($companyData->has('showPage')) {
            $company->show_page = true;
        } else {
            $company->show_page = false;
        }
        $company->save();
        if (empty($companyData->get('ru_slug'))) {
            $company->generateSlug();
        }
        $company->uploadImage($companyData->file('image'));
        $company->services()->detach();
        $services = $companyData->get('services');
        $company->services()->attach($services);
        return $company;
    }

    /**
     * Set position for company
     *
     * @param int $companyId
     * @param int $position
     * @return boolean
     */
    public function setPosition(int $companyId, int $position)
    {
        $company = $this->get($companyId);
        $company->position = $position;
        return $company->save();
    }

    /**
     * Delete company
     *
     * @param int $companyId
     * @return mixed Parent Category
     * @throws \Exception
     */
    public function delete(int $companyId)
    {
        $company = $this->get($companyId);
        $category = $company->category;
        $company->delete();
        return $category;
    }

    /**
     * Search company by name
     *
     * @param string $query
     * @param int $paginate
     * @return array
    */
    public function search(string $query, $paginate = null)
    {
        $queryResult = Company::where('ru_title', 'like', '%' . $query . '%');
        if ($paginate) {
            return $queryResult->paginate($paginate);
        } else {
            return $queryResult->get();
        }
    }

    /**
     * Get company by slug
     *
     * @param string $slug
     * @return Company
     */
    public function getBySlug(string $slug)
    {
        $company = Company::where('ru_slug', $slug)->first();
        return $company;
    }
}
