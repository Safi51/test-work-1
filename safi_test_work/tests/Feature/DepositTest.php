<?php

namespace Tests\Feature;

use App\Helpers\Constants\TransactionType;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepositTest extends TestCase
{
    use RefreshDatabase;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_success_with_balance_deposit(): void
    {
        $balance = Balance::factory()->create(['user_id' => $this->user->id]);

        $response = $this->post('/api/deposit', [
            'user_id' => $this->user->id,
            'amount' => 123.123,
            'comment' => 'hello'
        ]);

        $this->assertDatabaseHas('transactions', [
            'to_user_id' => $this->user->id,
            'amount'     => 123.123,
            'type'       => TransactionType::DEPOSIT,
            'comment'    => 'hello'
        ]);
        $this->assertDatabaseHas('balances', [
            'user_id' => $this->user->id,
            'balance' => $balance->balance + 123.123,
        ]);

        $response->assertStatus(200);

    }
    public function test_success_deposit_without_balance(): void
    {
        $response = $this->post('/api/deposit', [
            'user_id' => $this->user->id,
            'amount' => 123.123,
            'comment' => 'hello'
        ]);
        $this->assertDatabaseHas('transactions', [
            'to_user_id' => $this->user->id,
            'amount'     =>  123.123,
            'type'       => TransactionType::DEPOSIT,
            'comment' => 'hello'
        ]);
        $this->assertDatabaseHas('balances', [
            'user_id' => $this->user->id,
            'balance' => 123.123,
        ]);

        $response->assertStatus(200);
    }
    public function test_with_bad_request()
    {

        $response = $this->post('/api/deposit', [
            'user_id' => $this->user->id + 1,
            'amount' => 123.123,
            'comment' => 'hello'
        ]);

        $response->assertStatus(302);
        $response->isRedirect();
    }
}
