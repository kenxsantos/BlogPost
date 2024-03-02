<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHomePageIsWorkingCorrectly(): void
    {
        $response = $this->get('/');

        // $response->assertStatus(200);

        $response->assertSeeText('Welcome, Laravel BlogPost');
        $response->assertSeeText('This is the content of the main page');
    }

    public function testContactPageIsWorkingCorrectly(){

        $response = $this->get('/contact');
        $response->assertSeeText('Contact Page');
        $response->assertSeeText('This is contact page');
    }
}
