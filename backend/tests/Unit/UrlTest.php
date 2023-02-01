<?php

namespace Tests\Feature;

use App\Url;
use PHPUnit\Framework\TestCase;
use Tests\TestCase2; //this
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlTest extends TestCase
{
    use RefreshDatabase;
    public function testCreateUrlPost()
    {
        $data = [
            'url' => 'https://www.example.com',
            'check_periodicity' => 1,
            'repeat_periodicity' => 2,
        ];

        $response = $this->post('/api/createUrl', $data);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'successful']);
        $this->assertDatabaseHas('urls', $data);
    }

    public function testShowUrls()
    {
        factory(Url::class, 15)->create();

        $response = $this->post('/api/urls/');
        $data = [
            'page' => 1
        ];
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }
}
