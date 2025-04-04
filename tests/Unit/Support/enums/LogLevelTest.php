<?php

namespace Tests\Unit\Support\enums;

use App\Support\enums\LogLevel;
use Tests\TestCase;

class LogLevelTest extends TestCase
{
    public function test_log_level_has_error_case(): void
    {
        $this->assertEquals('error', LogLevel::ERROR->value);
    }
    
    public function test_log_level_has_warning_case(): void
    {
        $this->assertEquals('warning', LogLevel::WARNING->value);
    }
    
    public function test_log_level_has_info_case(): void
    {
        $this->assertEquals('info', LogLevel::INFO->value);
    }
    
    public function test_log_level_has_debug_case(): void
    {
        $this->assertEquals('debug', LogLevel::DEBUG->value);
    }
    
    public function test_log_level_cases_count(): void
    {
        $this->assertCount(4, LogLevel::cases());
    }
}