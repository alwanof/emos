<?php

namespace Tests\Feature;

use App\Configuration;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;



class ProductsTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    private $user;
    protected function setUp(): void
    {

        parent::setUp(); // TODO: Change the autogenerated stub
        Event::fake();
        $this->user=factory(User::class)->create();
        $this->actingAs($this->user);
    }
    /**
     * @test
     */
    public function indexProducts()
    {
        $response = $this->get('api/products/?api_token='.$this->user->api_token);
        $response->assertStatus(200);
    }

    /**
     * @test
     */

    public function storeProducts()
    {

        $data=[
            'title' => 'test title',
            'desc' => 'test description',
            'unit' => 'Container/s',
            'price' =>  75000,
        ];

        $response = $this->post('api/products/?api_token='.$this->user->api_token,$data);
        $response->assertStatus(200);
    }

    /**
     * @test
     */

    public function updateProducts()
    {

       $product=factory(Product::class)->create();
        $data=[
            'title' => 'edited test title',
            'desc' => 'edited test description',
            'unit' => 'Container',
            'price' =>  7000,
        ];

        $response = $this->put('api/products/'.$product->id.'/?api_token='.$this->user->api_token,$data);
        $response->assertStatus(200);

    }

    /**
     * @test
     */

    public function destroyProducts()
    {

        $product=factory(Product::class)->create();
        $response = $this->delete('api/products/'.$product->id.'/?api_token='.$this->user->api_token);
        $response->assertStatus(200);

    }

    /**
     * @test
     */

    public function searchProducts()
    {
        $this->withoutExceptionHandling();
        $productData1=factory(Product::class,20)->create();
        $targetproduct=Product::create([
            'title' => 'Iphone xs max',
            'desc' => 'connecting people',
            'unit' => 'Container',
            'price' =>  500,
        ]);
        $productData2=factory(Product::class,20)->create();
        $response = $this->get('api/search/products/?api_token='.$this->user->api_token.'&keywords=Iphone');
        $response->assertStatus(200)
        ->assertSeeText('Iphone xs max');;
    }


}
