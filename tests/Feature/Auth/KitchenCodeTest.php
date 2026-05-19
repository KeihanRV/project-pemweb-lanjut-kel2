<?php

namespace Tests\Feature\Auth;

use App\Models\Kitchen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KitchenCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_kitchen_code_validate_returns_success_for_valid_code(): void
    {
        $user = User::factory()->create();
        $kitchen = Kitchen::factory()->create();

        $response = $this->actingAs($user)->post('/kitchen-code/validate', [
            'code' => $kitchen->code,
        ]);

        $response->assertStatus(200);
        $response->assertSeeText("Selamat datang di kitchen {$kitchen->nama}!");

        $this->assertSame($kitchen->id, $user->fresh()->kitchen_id);
    }

    public function test_kitchen_code_validate_returns_error_for_invalid_code(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/kitchen-code/validate', [
            'code' => 'ZZZZ',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['code']);

        $this->assertNull($user->fresh()->kitchen_id);
    }

    public function test_kitchen_code_show_redirects_when_user_already_assigned(): void
    {
        $kitchen = Kitchen::factory()->create();
        $user = User::factory()->create(['kitchen_id' => $kitchen->id]);

        $response = $this->actingAs($user)->get('/kitchen-code');

        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
