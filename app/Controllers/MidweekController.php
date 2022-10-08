<?php

namespace Apastorts\JWGetter\Controllers;

use PHPHtmlParser\Dom;
use Illuminate\Support\Carbon;
use Apastorts\JWGetter\Model\Schedule;
use Apastorts\JWGetter\Services\TalkService;

class MidweekController
{
    /**
     * Gets the Treasures Section from the Midweek Meeting
     *
     * @param Dom $html
     * @return Array
     */
    public static function getTreasures(Dom $html)
    {
        $treasures = [];

        $treasures['title'] = ['Title',$html->find('#section2')['0']->find('h2')[0]->find('strong')[0]->text];
        $treasures['talk'] = ['Talk' , TalkService::get($html->find('#section2')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[0]->find('#p6')[0])];
        $treasures['gems'] = [ 'Gems', TalkService::get($html->find('#section2')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[1]->find('#p7')[0])];
        $treasures['reading'] = ['Bible Reading', TalkService::get($html->find('#section2')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]->find('#p10')[0])];

        return $treasures;
    }

    /**
     * Gets the Becoming Better Teachers Sectuib from the midweek meeting
     *
     * @param Dom $html
     * @return Array
     */
    public static function getTeachers(Dom $html)
    {
        $teachers = [];

        $teachers['title'] = ['Title',$html->find('#section3')['0']->find('h2')[0]->find('strong')[0]->text];
        $teachers['video'] = ['Video', TalkService::get($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[0]->find('#p12')[0])];
        $teachers['assign'] = [ 'First Assignment', TalkService::get($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[1]->find('#p13')[0])];
        if($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]){
          $teachers['2assign'] = ['Second Assignment', TalkService::get($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]->find('#p14')[0])];
        }
        if($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[3]){
            $teachers['3assign'] = ['Third Assignment', TalkService::get($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[3]->find('#p15')[0])];
        }

        return $teachers;
    }

    /**
     * Gets the Living as Christians Section
     *
     * @param Dom $html
     * @return Array
     */
    public static function getLiving(Dom $html)
    {
        $living = [];
        $living['title'] = ['Title',$html->find('#section4')['0']->find('h2')[0]->find('strong')[0]->text];
        $living['talk'] = ['Talk', TalkService::get($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[1]->find('#p17')[0])];
        $living['second'] = ['Needs Or Book', TalkService::get($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]->find('#p18')[0])];
        if($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[4]){
            $living['book'] = ['Final or Book', TalkService::get($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[3]->find('#p19')[0])];
        }

        if($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[5]){
            $living['final'] = ['Final', TalkService::get($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[4]->find('#p20')[0])];
        }

        return $living;
    }

    /**
     * Saves the Meeting into the database
     *
     * @param Array $meeting
     * @param Carbon $date
     * @return void
     */
    public static function saveMeeting(Array $meeting, $date)
    {
        Schedule::firstOrCreate(['date' => $date->startOfWeek()],['metadata' => json_encode($meeting)]);
    }
}
