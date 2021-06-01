<?php

namespace App\Models;

use App\Models\MessageToken;
use App\Models\Traits\MustVerifyPhone;
use App\Models\Chat\Chat;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Notifications\SendNotificationFireBase;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, MustVerifyPhone;

    const INDIVIDUAL = 'individual';
    const LEGAL_ENTITY = 'legal_entity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'company_name',
        'site',
        'city',
        'foundation_year',
        'customer_type',
        'contractor_type',
        'gender',
        'birthday_date',
        'specialization',
        'skills',
        'facebook',
        'vk',
        'telegram',
        'whatsapp',
        'instagram',
        'phone_number',
        'about_myself',
        'slug',
        'telegram_id',
        'telegram_username',
        'google_id',
        'fake',
        'meta_title'
    ];

//    public function notify($instance)
//    {
//        $this->traitNotify($instance);
//        $this->sendToApp($instance);
//    }
    public function routeNotificationForFcm()
    {
        return $this->messageTokens;
    }


    protected static function boot()
    {
        parent::boot();

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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_confirmed_at' => 'datetime',
        'agree_personal_data_processing' => 'boolean',
        'last_online_at' => 'datetime',
        'birthday_date' => 'datetime'
    ];

    private static $UPLOAD_DIRECTORY = 'uploads/users/';

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * All user's companies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class, 'user_id', 'id');
    }

    public function messageTokens()
    {
        return $this->hasMany(MessageToken::class, 'user_id', 'id');
    }

    public function createTokenMessage(string $token)
    {
        $message = new MessageToken([
            'token' => $token,
        ]);
        $message->save();
        return $message != null;
    }

    /**
     * Get user role
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->roles[0];
    }

    /**
     * Check if user has any role
     *
     * @return boolean
     */
    public function hasOneRole()
    {
        return isset($this->roles[0]);
    }

    /**
     * Authorize role for user
     *
     * @param string|array $roles
     *
     * @return bool
     */
    public function authorizeRole($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
        }

        return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    /**
     * Check multiple roles
     *
     * @param array $roles
     *
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     *
     * Check one role
     *
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * User categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this
            ->belongsToMany(HandbookCategory::class, 'user_category', 'user_id', 'category_id')
            ->withPivot('price_from', 'price_to', 'price_per_hour');
    }

    /**
     * Get all user's chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_participants', 'user_id', 'chat_id');
    }

    /**
     * Get history of user's actions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(HistoryItem::class, 'user_id', 'id');
    }

    /**
     * All user's requests for tenders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(TenderRequest::class, 'user_id', 'id');
    }

    /**
     * Tenders created by the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownedTenders()
    {
        return $this->hasMany(Tender::class, 'owner_id', 'id');
    }

    /**
     * User portfolio
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function portfolio()
    {
        return $this->hasMany(FormMultipleUpload::class, 'user_id', 'id');
    }

    /**
     * All tenders that user's request was accepted
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractedTenders()
    {
        return $this->hasMany(Tender::class, 'contractor_id', 'user_id');
    }

    /**
     * Generate slug
     *
     * @return void
     */
    public function generateSlug()
    {
        $slug = Str::slug($this->email);
        if ($this->company_name) {
            $slug = Str::slug($this->company_name);
        } elseif ($this->name) {
            $slug = Str::slug($this->name);
        }
        $existCount = self::where('slug', $slug)->count();
        if ($existCount > 0) {
            $slug .= "-$existCount";
        }
        $this->slug = $slug;
        $this->save();
    }

    /**
     * Create history item for user
     *
     * @param string $type
     * @param string $meta
     * @return void
     */
    public function addHistoryItem(string $type, string $meta)
    {
        $this->history()->create(['type' => $type, 'meta' => $meta]);
    }

    /**
     * Upload an image and save it in file storage
     *
     * @param $image
     */
    public function uploadImage($image)
    {
        if (!$image) {
            return;
        }

        $this->removeImage();
        $filename = $this->generateFileName($image->extension());
        $image->storeAs(self::$UPLOAD_DIRECTORY, $filename, '');
        $this->saveImageName($filename);
    }

    public function uploadResume($resume)
    {
        if (!$resume) {
            return;
        }

        if ($this->resume) {
            Storage::delete(self::$UPLOAD_DIRECTORY . $this->resume);
        }
        $filename = $this->generateFileName($resume->extension());
        $resume->storeAs(self::$UPLOAD_DIRECTORY, $filename, '');
        $this->resume = $filename;
        $this->save();
    }

    /**
     * Set default user avatar
     *
     * @return void
     */
    public function setDefaultAvatar()
    {
        $this->image = 'avatar0.jpg';
        $this->save();
    }

    /**
     * Generate filename for image
     *
     * @param string $imageName
     * @return string
     */
    private function generateFileName(string $imageName)
    {
        return Str::random(20) . '.' . $imageName;
    }

    /**
     * Get image filename
     *
     * @return string
     */
    public function getImage()
    {
        if ($this->image) {
            return '/' . self::$UPLOAD_DIRECTORY . $this->image;
        } else {
            return asset('assets/img/avatars/avatar15.jpg');
        }
    }

    public function getResume()
    {
        if ($this->resume) {
            return '/' . self::$UPLOAD_DIRECTORY . $this->resume;
        } else {
            return asset('assets/img/avatars/avatar15.jpg');
        }
    }

    /**
     * Remove an image
     *
     * @return void
     */
    public function removeImage()
    {
        if ($this->image) {
            Storage::delete(self::$UPLOAD_DIRECTORY . $this->image);
        }
    }

    /**
     * Save an image name to the database
     *
     * @param string $imageName
     * @return void
     */
    private function saveImageName(string $imageName)
    {
        $this->image = $imageName;
        $this->save();
    }

    /**
     * Save password for the user
     *
     * @param string $password
     * @return void
     */
    public function savePassword(string $password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }

    /**
     * Check if user has completed account
     *
     * @return bool
     */
    public function checkCompletedAccount()
    {
        return $this->completed;
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getContractorTitle()
    {
        if ($this->contractor_type === 'legal_entity') {
            return $this->company_name;
        } elseif ($this->contractor_type === 'individual') {
            return $this->name;
        } elseif ($this->name) {
            return $this->name;
        } else {
            return $this->email;
        }
    }

    public function getCommonTitle()
    {
        if ($this->hasRole('customer')) {
            switch ($this->customer_type) {
                case 'legal_entity':
                    return $this->company_name;
                case 'individual':
                    return $this->name;
                default:
                    return $this->email;
            }
        } elseif ($this->hasRole('contractor')) {
            switch ($this->contractor_type) {
                case 'legal_entity':
                    return $this->company_name;
                case 'individual':
                    return $this->name;
                default:
                    return $this->email;
            }
        } else {
            return $this->email;
        }
    }

    public function hasRequestFromContractor(User $contractor)
    {
        if ($this->hasRole('customer')) {
            if ($contractor->requests()->count() > 0) {
                $tendersIds = $this->ownedTenders()->pluck('id')->toArray();
                return $contractor->requests()->whereIn('tender_id', $tendersIds)->count() > 0;
            }
            return false;
        }
        return false;
    }

    public function delete()
    {
        $this->requests()->delete();
        $this->categories()->delete();
        $this->ownedTenders()->delete();
        $this->contractedTenders()->delete();
        $this->chats()->delete();
        $this->removeImage();
        return parent::delete(); // TODO: Change the autogenerated stub
    }

    public function getIsOnlineAttribute()
    {
        return $this->last_online_at > now()->subMinutes(10);
    }
}
