<?php


namespace App\Repositories;


use App\Models\User;
use App\Models\Role;
use App\Models\FormMultipleUpload;
use App\Models\Comments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    /**
     * Get all users
     *
     * @return mixed
     */
    public function all()
    {
        return User::all();
    }

    public function searchContractors($search){
      
      $users = User::where('name', 'like', '%'.$search->contractorSearch.'%')->get();
      return $users->filter(function ($user) { return $user->hasRole('contractor');});


    }
    //$allUsers = User::all();
    // return $allUsers->filter(function ($user) { return $user->hasRole('contractor'); });

    /**
     * Get user by it's id
     *
     * @param int $userId
     * @return User
     */
    public function get($userId)
    {
        return User::findOrFail($userId);
    }

    /**
     * Create an User
     *
     * @param \Illuminate\Http\Request $userData
     * @param int $userRoleId
     * @return void
     */
    public function create($userData, $userRoleId)
    {
        $role = Role::findOrFail($userRoleId);
        $data = [
            'name' => $userData->get('name'),
            'email' => $userData->get('email'),
            'password' => Hash::make($userData->get('password'))
        ];
        $user = User::create($data);
        $user->roles()->attach($role);
        $user->save();
        $user->generateSlug();
        $user->uploadImage($userData->file('image'));
    }

    /**
     * Update an user
     *
     * @param int $userId
     * @param \Illuminate\Http\Request $userData
     * @return void
     */
    public function update($userId, $userData)
    {
        $user = $this->get($userId);
        $data = $userData->all();
        if (isset($data['birthday_date']))
            $data['birthday_date'] = Carbon::createFromFormat('d.m.Y', $data['birthday_date'])->format('Y-m-d');
        $user->update($data);
        $user->generateSlug();
        $user->uploadImage($userData->file('image'));
        $user->uploadResume($userData->file('resume'));
    }

    /**
     * Delete user
     *
     * @param int $userId
     * @return void
     */
    public function delete($userId)
    {
        User::destroy($userId);
    }

    /**
     * Get all users with role 'admin'
     *
     * @return mixed
     */
    public function getAdmins()
    {
        $role = Role::where('name', 'admin')->first();
        return $role->users;
    }

    /**
     * Get all users with role 'customer'
     *
     * @return mixed
     */
    public function getCustomers()
    {
        $role = Role::where('name', 'customer')->first();
        return $role->users;
    }

    /**
     * Get all roles
     *
     * @return array
     */
    public function allRoles()
    {
        return Role::all();
    }

    /**
     * @inheritDoc
     */
    public function getContractors()
    {
        $allUsers = User::all();
        return $allUsers->filter(function ($user) { return $user->hasRole('contractor'); });
    }



    /**
     * @inheritDoc
     */
    public function getContractorBySlug(string $slug)
    {
        return $this->getContractors()->first(function ($user) use ($slug) {
            return $user->slug === $slug;
        });
    }


    public function getPortfolio(string $slug){
      $allPortfolio = FormMultipleUpload::where('slug', $slug)->get();
      return $allPortfolio;

    }

    public function getPortfolioBySlug(string $slug){

      return $this->getPortfolio($slug)->all(function ($user) use ($slug) {
          return $user->slug === $slug;
      });
    }

    public function getComment(string $slug){
      $allComments = Comments::where('for_set', $slug)->whereNotNull('comment')->get();
      return $allComments;

    }

    public function getCommentBySlug(string $slug){

      return $this->getComment($slug)->all(function ($user) use ($slug) {
          return $user->slug === $slug;
      });
    }

    /**
     * @inheritDoc
     */
    public function createAccount($data)
    {
        $user = auth()->user();
        $userRole = $data->get('user_role');
        $role = Role::where('name', $userRole)->first();
        $user->roles()->attach($role->id);
        $dataToSet = [];
        $dataToSet['name'] = $data->get($userRole.'_name');
        $dataToSet['phone_number'] = $data->get($userRole.'_phone_number');
        $dataToSet[$userRole.'_type'] = $data->get($userRole.'_type');
        $dataToSet['email'] = $data->get($userRole.'_email');
        $dataToSet['company_name'] = $data->get($userRole.'_company_name');
        $dataToSet['about_myself'] = $data->get($userRole.'_about_myself');
        if ($userRole == 'contractor' && $data->get($userRole.'_type') == 'individual') {
            $dataToSet['birthday_date'] = Carbon::createFromFormat('d.m.Y', $data->get('contractor_birthday_date'))->format('Y-m-d');
            $dataToSet['gender'] = $data->get('gender');
        }
        $user->update($dataToSet);
        $user->completed = true;
        $user->save();
        $user->generateSlug();
        $user->uploadImage($data->file('image'));
    }

    /**
     * @inheritDoc
     */
    public function createUserViaTelegram($data)
    {
        $telegramId = $data->get('id');
        $name = $data->get('first_name') . ' ' . $data->get('last_name');
        $username = $data->get('username');
        $user = User::create([
            'name' => $name,
            'telegram_id' => $telegramId,
            'telegram_username' => $username,
            'email' => '',
            'password' => ''
        ]);
        $user->generateSlug();
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getUserByTelegramId(int $telegramId)
    {
        return User::where('telegram_id', $telegramId)->first();
    }


}
