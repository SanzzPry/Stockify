<?php

namespace App\Services\User;

use LaravelEasyRepository\Service;
use App\Repositories\User\UserRepository;

class UserServiceImplement extends Service implements UserService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function getAllUser()
    {
        return $this->mainRepository->all();
    }

    public function getUserById($id)
    {
        return $this->mainRepository->find($id);
    }

    public function createUser($data)
    {
        return $this->mainRepository->create($data);
    }

    public function updateUser($id, $data)
    {
        return $this->mainRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->mainRepository->delete($id);
    }

    public function getActivities(): array
    {
        $activities = $this->mainRepository->userActivities();
        return array_reverse($activities); // terbaru di atas
    }

    public function getUserActivityReport()
    {
        return $this->mainRepository->userActivityReport();
    }
    // Define your custom methods :)
}
