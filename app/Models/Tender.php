<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tender extends Model
{
    const UPLOAD_DIRECTORY = 'uploads/tenders/';

    protected $fillable = [
        'client_type', 'client_name', 'client_email', 'client_phone_number', 'client_company_name', 'client_site_url',
        'title', 'description', 'budget', 'deadline',
        'target_audience', 'links', 'additional_info', 'other_info', 'what_for', 'type',
        'slug', 'opened',
        'need_id', 'owner_id', 'contractor_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->generateSlug();
        });

        static::created(function ($item) {
            event('model.changed');
        });

        static::updated(function ($item) {
            event('model.changed');
        });

        static::deleted(function ($item) {
            event('model.changed');
        });
    }

    /**
     * Type of need
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function need()
    {
        return $this->hasOne(NeedType::class, 'id', 'need_id');
    }

    public function files()
    {
        return $this->hasMany(TenderFile::class, 'tender_id', 'id');
    }

    /**
     * All tender's requests from user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(TenderRequest::class, 'tender_id', 'id');
    }

    /**
     * Tender's attached categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(HandbookCategory::class, 'tender_category',
            'tender_id', 'category_id');
    }

    /**
     * Owner of the tender
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    /**
     * Contractor of the tender
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contractor()
    {
        return $this->hasOne(User::class, 'id', 'contractor_id');
    }

    public function saveFiles($files)
    {
        if (!$files)
            return;
        $this->files()->delete();
        foreach ($files as $file) {
            $filename = Str::random(20) . '.' . $file->extension();
            $file->storeAs(self::UPLOAD_DIRECTORY, $filename);
            $this->files()->create([
                'path' => $filename
            ]);
        }
    }

    /**
     * Generate slug
     *
     * @return void
     */
    public function generateSlug() {
        $slug = Str::slug($this->title);
        if ($this->slug == $slug)
            return;
        $existCount = self::where('slug', $slug)->count();
        if ($existCount > 0)
            $slug .= "-$existCount";
        $this->slug = $slug;
    }

    public function getCustomerTitle() {
        if ($this->client_type == 'private')
            return $this->client_name;
        else
            return $this->client_company_name;
    }

    public function checkDeadline()
    {
        $deadline = Carbon::create($this->deadline)->setHour(23)->setMinute(59)->setSecond(59);
        return now() < $deadline;
    }

    public function hasRequestFrom($userId)
    {
        return $this->requests()->where('user_id', $userId)->count() > 0;
    }

    public function delete()
    {
        $this->requests()->delete();
        return parent::delete();
    }
}
