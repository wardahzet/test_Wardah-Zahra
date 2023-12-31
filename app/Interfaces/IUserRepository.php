<?php 

namespace App\Interfaces;

interface IUserRepository
{
    public function getAll();
    public function find($uuid);
    public function create($request);
    public function update($user, $request);
    public function delete($id);
}

?>