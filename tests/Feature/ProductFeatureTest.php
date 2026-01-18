<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    #[Test]
    public function unauthenticated_user_cannot_access_products_api(): void
    {
        $this->getJson('/api/products')
             ->assertStatus(401);
    }

    #[Test]
    public function authenticated_user_can_fetch_products(): void
    {
        $this->authenticate();

        Product::factory()->count(3)->create();

        $this->getJson('/api/products')
             ->assertStatus(200)
             ->assertJsonCount(3);
    }

    #[Test]
    public function authenticated_user_can_create_product(): void
    {
        $this->authenticate();

        $payload = [
            'name' => 'Test Product',
            'quantity' => 10,
            'price' => 99.99,
            'status' => 'active',
        ];

        $this->postJson('/api/products', $payload)
             ->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
        ]);
    }

    #[Test]
    public function product_name_is_required(): void
    {
        $this->authenticate();

        $this->postJson('/api/products', [
            'quantity' => 5,
            'price' => 10,
            'status' => 'active',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors('name');
    }

    #[Test]
    public function authenticated_user_can_update_product(): void
    {
        $this->authenticate();

        $product = Product::factory()->create([
            'name' => 'Old Name',
        ]);

        $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Name',
            'quantity' => $product->quantity,
            'price' => $product->price,
            'status' => 'active',
        ])
        ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
        ]);
    }

    #[Test]
    public function authenticated_user_can_delete_product(): void
    {
        $this->authenticate();

        $product = Product::factory()->create();

        $this->deleteJson("/api/products/{$product->id}")
             ->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    #[Test]
    public function products_can_be_filtered_by_status(): void
    {
        $this->authenticate();

        Product::factory()->create(['status' => 'active']);
        Product::factory()->create(['status' => 'inactive']);

        $this->getJson('/api/products?status=active')
             ->assertStatus(200)
             ->assertJsonCount(1);
    }
}
