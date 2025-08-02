<?php

namespace App\Events;

class ActivityLogged
{
    public string $activity;
    public string $user;
    public string $role;
    public string $timestamp;

    public function __construct(string $activity, string $user, string $role)
    {
        $this->activity = $activity;
        $this->user = $user;
        $this->role = $role;
        $this->timestamp = now()->toDateTimeString();
    }
}
