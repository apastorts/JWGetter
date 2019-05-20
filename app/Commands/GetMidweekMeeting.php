<?php

namespace Apastorts\JWGetter\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Apastorts\JWGetter\Controllers\MidweekController;
use Carbon;
use PHPHtmlParser\Dom;

class GetMidweekMeeting extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'get:midweek {date?} {language?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Gets the midweek meeting of that day';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = $this->argument('date') ?  new Carbon\Carbon($this->argument('date'))  : now();
        $language = $this->argument('language') ?  $this->argument('language')  : 'en';
        if($language == 'en'){
            $url = 'https://wol.jw.org/'.$language.'/wol/dt/r1/lp-e/'.$date->year.'/'.$date->month.'/'.$date->day;
        }
        else{
            $url = 'https://wol.jw.org/'.$language.'/wol/dt/r4/lp-s/'.$date->year.'/'.$date->month.'/'.$date->day;
        }
        
        $html = (new Dom())->loadFromUrl($url);
        
        $meeting['treasures'] = MidweekController::getTreasures($html);
        $meeting['teachers'] = MidweekController::getTeachers($html);
        $meeting['living'] = MidweekController::getLiving($html);

        $this->line('Meeting of '. $date->toDateTimeString());
        $this->line($meeting['treasures']['title']);

        $headers = ['Talk', 'Title'];

        $this->table($headers, $meeting['treasures']);

        $this->line($meeting['teachers']['title']);

        $headers = ['Talk', 'Title'];

        $this->table($headers, $meeting['teachers']);

        $this->line($meeting['living']['title']);

        $headers = ['Talk', 'Title'];

        $this->table($headers, $meeting['living']);

        MidweekController::saveMeeting($meeting, $date);

    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
