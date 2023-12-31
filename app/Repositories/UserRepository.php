<?php 

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;

class UserRepository implements IUserRepository
{
    public function __construct(private User $user) 
    {
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function find($uuid)
    {
        return $this->user->find($uuid);
    }

    public function create($request)
    {
        return $this->user->create($request);
    }

    public function update($id, $request)
    {
        return $this->find($id)->update($request);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}