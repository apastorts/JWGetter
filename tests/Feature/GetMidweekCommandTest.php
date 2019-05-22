<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetMidweekCommandTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function it_gets_trasures()
    {
        $this->artisan('get:midweek ')
            ->expectsOutput('Meeting of '.now()->toDateTimeString())
            ->expectsOutput('TREASURES FROM GOD’S WORD')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_gets_teachers()
    {
        $this->artisan('get:midweek')
            ->expectsOutput('Meeting of '.now()->toDateTimeString())
            ->expectsOutput('APPLY YOURSELF TO THE FIELD MINISTRY')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_gets_living()
    {
        $this->artisan('get:midweek')
            ->expectsOutput('Meeting of '.now()->toDateTimeString())
            ->expectsOutput('LIVING AS CHRISTIANS')
            ->assertExitCode(0);
    }

    
}
