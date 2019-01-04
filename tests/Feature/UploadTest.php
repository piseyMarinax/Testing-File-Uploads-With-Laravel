<?php

namespace Tests\Feature;

use App\Upload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /** @test */
    function upload_file_test()
    {
        Storage::fake('public');

        $this->json('post', '/upload', [
            'file' => $file = UploadedFile::fake()->image('random.jpg')
        ]);

        $this->assertEquals('file/' . $file->hashName(), Upload::latest()->first()->file);

        Storage::disk('public')->assertExists('file/' . $file->hashName());
    }
}
