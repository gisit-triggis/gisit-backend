<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\GrpcError;
use Tests\TestCase;

class GrpcErrorTest extends TestCase
{
    public function test_grpc_error_extends_error(): void
    {
        $error = new GrpcError('Test error message');
        
        $this->assertInstanceOf(\Error::class, $error);
    }
    
    public function test_grpc_error_has_correct_message(): void
    {
        $errorMessage = 'GRPC service unavailable';
        $error = new GrpcError($errorMessage);
        
        $this->assertEquals($errorMessage, $error->getMessage());
    }
    
    public function test_grpc_error_has_correct_code(): void
    {
        $errorCode = 123;
        $error = new GrpcError('Error message', $errorCode);
        
        $this->assertEquals($errorCode, $error->getCode());
    }
}