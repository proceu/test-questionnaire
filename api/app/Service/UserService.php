<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Spatie\Permission\Models\Role;

class UserService extends CoreService
{
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @param array $data
     * @return void
     */
    public function register(array $data): void
    {
        $data['password'] = Hash::make($data['password']);
        $roleName = env('APP_DEFAULT_ROLE');

        if (!$role = Role::findByName($roleName)) {
            throw new RuntimeException('Role not found!',404);
        }
        if (!$user = User::create($data)) {
            throw new RuntimeException('Error on creating user!',500);
        }
        if (!$user->assignRole($role)) {
            throw new RuntimeException('Error on assign role to user!',500);
        }
    }

    /**
     * @param array $data
     * @return string
     */
    public function login(array $data): string
    {
        if (!$user = User::where('email',$data['email'])->first()) {
            throw new RuntimeException('User not found!',404);
        }
        if (! Hash::check($data['password'], $user->password)) {
            throw new RuntimeException('Wrong email or password!',422);
        }
        return $user->createToken(config('app.name'))->plainTextToken;
    }

    public function search(array $data)
    {
        $query = $this->query();
        $query->whereDoesntHave('answers');

        return $query->paginate();
    }
}
