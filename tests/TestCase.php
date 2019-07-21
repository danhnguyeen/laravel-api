<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string|null  $driver
     * @return $this
     */
    public function actingAsAdmin($driver = 'api')
    {
        $user = User::find(101);
        
        return $this->be($user, $driver);
    }
}
