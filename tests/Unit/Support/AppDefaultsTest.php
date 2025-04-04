<?php

namespace Tests\Unit\Support;

use App\Support\AppDefaults;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AppDefaultsTest extends TestCase
{
    public function test_password_min_returns_config_value(): void
    {
        // Set up a mock config value
        config(['app_rules.auth_rules.password_min_length' => 8]);
        
        $this->assertEquals(8, AppDefaults::passwordMin());
    }

    public function test_password_max_returns_config_value(): void
    {
        config(['app_rules.auth_rules.password_max_length' => 20]);
        
        $this->assertEquals(20, AppDefaults::passwordMax());
    }

    public function test_user_name_min_returns_config_value(): void
    {
        config(['app_rules.user_rules.user_name_min_length' => 2]);
        
        $this->assertEquals(2, AppDefaults::userNameMin());
    }

    public function test_user_name_max_returns_config_value(): void
    {
        config(['app_rules.user_rules.user_name_max_length' => 50]);
        
        $this->assertEquals(50, AppDefaults::userNameMax());
    }

    public function test_user_surname_min_returns_config_value(): void
    {
        config(['app_rules.user_rules.user_surname_min_length' => 2]);
        
        $this->assertEquals(2, AppDefaults::userSurnameMin());
    }

    public function test_user_surname_max_returns_config_value(): void
    {
        config(['app_rules.user_rules.user_surname_max_length' => 50]);
        
        $this->assertEquals(50, AppDefaults::userSurnameMax());
    }
}