<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_authenticated_user_can_create_category(){

        $this->withoutExceptionHandling();
        // 1. Given => Teniendo
        // $user = factory(User::class)->create();
        // $user = User::factory()->create();
        // $this->actingAs($user);

        // 2. When => Cuando
        $this->post(route('categories.store'), ['name' => 'First Category']);

        // $this->post('api/category', ['name' => 'First Category']);

        // 3. Then => Entonces
        $this->assertDatabaseHas('categories', [
            'name' => 'First Category'
        ]);

    }
}
