<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;


    public function testNoBlogPostWhenNothingInDatabase(): void
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No found Post');
    }

    public function testSee1BlogPostWhenThereIs1(){
        //Arrange 
        $post = $this->createDummyBlogPost();

        //Act 
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New Title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title
        ]);
    }
    public function testStoreValid(){
        $params = [
            'title' => 'Valid Title',
            'content' => 'At least 10 characters'
        ];
        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail(){
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title field must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content field must be at least 10 characters.');
        // dd($message->getMessages());
    }

    public function testUpdateValid(){

        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
            'content' => 'Content of the blog post'
        ]);

        $params = [
            'title' => 'A new named title',
            'content' => 'A content was change'
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new named title'
        ]);
    }

    public function testDelete(){

        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts',  [
            'title' => 'New Title',
            'content' => 'Content of the blog post'
        ]);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog Post was Deleted' .' ID: '. $post->id); 
        $this->assertDatabaseMissing('blog_posts', $post->toArray());   
    }
    private function createDummyBlogPost(): BlogPost {
        $post = new BlogPost();
        $post->title = 'New Title';
        $post->content = 'Content of the blog post';
        $post->save();
        
        return $post;
    }
}
