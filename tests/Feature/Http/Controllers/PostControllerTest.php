<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;

class PostControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index_post()
    {
        // Create user and acting as user
        Passport::actingAs(
            user::factory()->create()
        );

        // Error with handling 
        $this->withoutExceptionHandling();

        // get to /api/v1/posts page and Assert status is 200
        $this->json('GET', '/api/v1/posts')->assertStatus(200);
    }

    public function test_store_post()
    {
        // Create user factory and acting as user
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $categories = Category::factory()->create();

        $data = [
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(200, 200),
            'user_id' => $user->id,
            'category_id' => $categories->id
        ];

        // Error with handling 
        $this->withoutExceptionHandling();

        // get to /api/v1/posts page and Assert status is 200
        $this->json('POST', '/api/v1/posts', $data)->assertStatus(200);
    }

    public function test_update_post()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $categories = Category::factory()->create();

        $post = Post::factory()->make([
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(200, 200),
            'user_id' => $user->id,
            'category_id' => $categories->id
        ]);
        $user->posts()->save($post);

        $data = [
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(200, 200),
            'user_id' => $user->id,
            'category_id' => $categories->id
        ];

        $this->json('PUT', route('posts.update', $post->id), $data)
            ->assertStatus(200);
    }

    public function test_show_post()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $categories = Category::factory()->create();

        $post = Post::factory()->make([
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(200, 200),
            'user_id' => $user->id,
            'category_id' => $categories->id
        ]);
        $user->posts()->save($post);

        $this->json('GET', '/api/v1/posts/' . $post->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_detele_post()
    {
        $user = Passport::actingAs(
            User::factory()->create()
        );

        $categories = Category::factory()->create();

        $data = Post::factory()->create([
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(200, 200),
            'user_id' => $user->id,
            'category_id' => $categories->id
        ]);

        $this->json('DELETE', '/api/v1/posts/' . $data->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
