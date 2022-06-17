<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * A functional success test for creating a order test example with proper data.
     *
     * @return json data
     */
    public function test_can_create_order()
    {
        $response = $this->postJson('/api/orders', [
            'name' => 'Mallikarjun',
            'state' => 'KA',
            'amount'=>'100',
            'zip'=>'585101',
            'qty'=>'12',
            'item'=>'It123'
        ]);
        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * A functional fail test for creating a order test example without proper data.
     *
     * @return json data
     */
    public function test_create_order_fail()
    {
        $response = $this->postJson('/api/orders', [
            'name' => 'Mallikarjun',
            'state' => 'KA',
            'amount'=>'100',
            'zip'=>'585101',
            'qty'=>'12',
            'item'=>'I'
        ]);
        $response
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }

    /**
     * A functional success test for updating a order test example with proper data.
     *
     * @return json data
     */
    public function test_can_update_order() {

        $id = Order::get()->random()->id;
        $response = $this->putJson('/api/orders/'.$id, [
            'name' => 'Mallikarjun H',
            'state' => 'KA',
            'amount'=>'100',
            'zip'=>'585101',
            'qty'=>'12',
            'item'=>'It123'
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * A functional fail test for updating a order test example without proper data.
     *
     * @return json data
     */
    public function test_update_order_fail() {

        $id = Order::get()->random()->id;
        $response = $this->putJson('/api/orders/'.$id, [
            'name' => 'Mallikarjun H',
            'state' => 'KA',
            'amount'=>'100',
            'zip'=>'585101',
            'qty'=>'12',
            'item'=>'I'
        ]);
        $response
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }


    /**
     * A functional success test for listing a order with proper data.
     *
     * @return json data
     */
    public function test_can_list_orders()
    {
        $response = $this->getJson('/api/orders');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * A functional success test for listing a order for specific order with proper data.
     *
     * @return json data
     */
    public function test_can_list_specific_order()
    {
        $id = Order::get()->random()->id;
        $response = $this->getJson('/api/orders/'.$id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * A functional success test for deleting a order for specific order with proper data.
     *
     * @return json data
     */
    public function test_can_delete_order()
    {
        $id = Order::get()->random()->id;
        $response = $this->getJson('/api/orders/'.$id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * A functional success test for creating a CSV file from the data collected from DB of order table.
     *
     * @return json data
     */
    public function test_can_create_csv_file()
    {
        $response = $this->getJson('/api/create_csv/');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * A functional success test for page not found.
     *
     * @return void
     */
    public function test_can_url_not_found()
    {
        $response = $this->getJson('/api/');
        $response
            ->assertStatus(404);
    }

    /**
     * A functional success test for that record is present in the DB Table.
     *
     * @return void
     */
    public function test_can_database_has_records()
    {
        $this->assertDatabaseHas('orders', [
            'name' => 'Mallikarjun'
        ]);
    }

}
