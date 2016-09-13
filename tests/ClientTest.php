<?php
use App\Client;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientTest extends TestCase
{
    use DatabaseTransactions;

    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = factory(App\Client::class)->create();
        // $this->client = new Client(['name' => 'test client']);
    }

    /** @test */
    public function a_client_has_a_name()
    {
        $this->assertEquals('test client', $this->client->name);
    }
}
