<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductInventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_starts_empty_for_a_new_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Your inventory is empty.');
    }

    public function test_user_can_add_a_product_to_their_inventory(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Aurora ceramic mug',
            'sku' => 'ACC-084',
            'category' => 'Home & Living',
            'stock' => 12,
            'price' => 450,
            'variant' => 'Matte olive',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'sku' => 'ACC-084',
            'stock' => 12,
        ]);
    }

    public function test_user_cannot_edit_another_users_product(): void
    {
        $owner = User::factory()->create();
        $product = Product::factory()->for($owner)->create();

        $this->actingAs(User::factory()->create())
            ->put(route('products.update', $product), [
                'name' => 'Changed name',
                'sku' => 'OTHER-001',
                'category' => 'Accessories',
                'stock' => 2,
                'price' => 100,
            ])->assertForbidden();
    }
}
