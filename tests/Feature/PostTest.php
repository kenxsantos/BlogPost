<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;


    public function testNoBlogPostWhenNothingInDatabase(): void
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No found Post');
    }

    public function testSee1BlogPostWhenThereIs1WithComments(){
        //Arrange 
        $post = $this->createDummyBlogPost();

        //Act 
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('No Comments');

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title
        ]);
    }

    public function testSee1BlogPostWithComments(){
        $user = $this->user();
        $post = $this->createDummyBlogPost();

        Comment::factory()
            ->count(4)
            ->create([
                'commentable_id' => $post->id,
                'commentable_type' => BlogPost::class,
                'user_id' => $user->id
        ]);   
        //Act 
        $response = $this->get('/posts');
        $response->assertSeeText('4 comments');
    }

    public function testStoreValid(){

        $params = [
            'title' => 'Valid Title',
            'content' => 'At least 10 characters'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail(){
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title field must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content field must be at least 10 characters.');
        // dd($message->getMessages());
    }

    public function testUpdateValid(){
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
            'content' => 'Content of the blog post'
        ]);
        $params = [
            'title' => 'A new named title',
            'content' => 'A content was change'
        ];
        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new named title'
        ]);
    }

    public function testDelete(){
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts',  [
            'title' => 'New Title',
            'content' => 'Content of the blog post'
        ]);
        
        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog Post was Deleted' .' ID: '. $post->id); 
        $this->assertDatabaseMissing('blog_posts', $post->toArray());   
        // $this->assertSoftDeleted('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost($userId = null): BlogPost {
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        return BlogPost::factory()->newTitle()->create([
            'user_id' => $userId ?? $this->user()->id,

        ]);
        
        // return $post;
    }
}
