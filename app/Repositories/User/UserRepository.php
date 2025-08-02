<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;
use PhpParser\Node\Expr\FuncCall;

interface UserRepository extends Repository
{

    public function all();
    public function find($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function userActivities();
    public function userActivityReport();


    // Write something awesome :)
}
