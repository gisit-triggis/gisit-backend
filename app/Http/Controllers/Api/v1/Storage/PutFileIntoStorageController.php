<?php

namespace App\Http\Controllers\Api\v1\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Storage\PutFileIntoStorageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laminas\Diactoros\Exception\UploadedFileErrorException;

class PutFileIntoStorageController extends Controller
{
    protected function handle(): JsonResponse
    {
        $request = app(PutFileIntoStorageRequest::class)->validated();

        $file = $request['file'];

        $fileName = uuid_create() . '_' . time() . '.' . $file->getClientOriginalExtension();

        if (!Storage::put($fileName, file_get_contents($file))) {
            throw new UploadedFileErrorException();
        }

        $response = [
            'url' =>  Storage::url($fileName),
        ];

        return fast_response(data: $response);
    }
}
