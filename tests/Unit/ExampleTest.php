<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Socios;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testBasfdicTest()
    {
        $j = Socios::all();

        $this->assertEquals($j->count(), 1);
    }
}
