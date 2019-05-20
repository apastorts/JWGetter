<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetMidweekTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function it_gets_trasures()
    {
        $this->artisan('get:midweek')
            ->expectsOutput('Meeting of '.now()->toDateTimeString())
            ->expectsOutput('TESOROS DE LA BIBLIA')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_gets_teachers()
    {
        $this->artisan('get:midweek')
            ->expectsOutput('Meeting of '.now()->toDateTimeString())
            ->expectsOutput('SEAMOS MEJORES MAESTROS')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_gets_living()
    {
        $this->artisan('get:midweek')
            ->expectsOutput('Meeting of '.now()->toDateTimeString())
            ->expectsOutput('SEAMOS MEJORES MAESTROS')
            ->assertExitCode(0);
    }

    
}
