<?php

namespace Tests\Unit\Support;

use App\Support\enums\LogLevel;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class LogTest extends TestCase
{
    public function test_log_message_calls_error_with_correct_parameters(): void
    {
        Log::spy();
        
        log_message(LogLevel::ERROR, 'Error message', ['trace' => 'data']);
        
        Log::shouldHaveReceived('error')
            ->once()
            ->with('Error message', ['trace' => 'data']);
    }
    
    public function test_log_message_calls_warning_with_correct_parameters(): void
    {
        Log::spy();
        
        log_message(LogLevel::WARNING, 'Warning message');
        
        Log::shouldHaveReceived('warning')
            ->once()
            ->with('Warning message', []);
    }
    
    public function test_log_message_calls_info_with_correct_parameters(): void
    {
        Log::spy();
        
        log_message(LogLevel::INFO, 'Info message', ['key' => 'value']);
        
        Log::shouldHaveReceived('info')
            ->once()
            ->with('Info message', ['key' => 'value']);
    }
    
    public function test_log_message_calls_debug_with_correct_parameters(): void
    {
        Log::spy();
        
        log_message(LogLevel::DEBUG, 'Debug message');
        
        Log::shouldHaveReceived('debug')
            ->once()
            ->with('Debug message', []);
    }
}