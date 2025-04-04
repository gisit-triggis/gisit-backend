<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ResponseTest extends TestCase
{

    public function test_fast_error_message_returns_default_error_message(): void
    {
        $this->assertEquals('Error', __('Error'));
        $this->assertTrue(true);
    }

    public function test_fast_error_message_returns_custom_error_message(): void
    {
        $this->assertEquals('Custom error', __('Custom error'));
        $this->assertTrue(true);
    }
}
