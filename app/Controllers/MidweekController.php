<?php

namespace Apastorts\JWGetter\Controllers;

use PHPHtmlParser\Dom;
use Illuminate\Support\Carbon;
use Apastorts\JWGetter\Model\Meeting;

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
        $treasures['talk'] = ['Talk' , self::getTalk($html->find('#section2')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[0]->find('#p6')[0])];
        $treasures['gems'] = [ 'Gems', self::getTalk($html->find('#section2')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[1]->find('#p10')[0])];
        $treasures['reading'] = ['Bible Reading', self::getTalk($html->find('#section2')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]->find('#p15')[0])];
        $treasures['lesson'] = $html->find('#section2')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]->find('#p15')[0]->find('a')[1]->find('em')[0]->text;
        $treasures['lesson'] = ['Lesson to Work', $treasures['lesson'].$html->find('#section2')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]->find('#p15')[0]->find('a')[1]->text];
        
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
        $teachers['video'] = ['Video', self::getTalk($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[0]->find('#p17')[0])];
        $teachers['assign'] = [ 'First Assignment', self::getTalk($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[1]->find('#p18')[0])];
        $teachers['2assign'] = ['Second Assignment', self::getTalk($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]->find('#p19')[0])];
        
        if($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[3]){
            $teachers['3assign'] = ['Third Assignment', self::getTalk($html->find('#section3')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[3]->find('#p20')[0])];    
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
        $living['talk'] = ['Talk', self::getTalk($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[1]->find('#p22')[0])];
        $living['second'] = ['Needs Or Book', self::getTalk($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[2]->find('#p23')[0])];

        if($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[4]){
            $living['book'] = ['Final or Book', self::getTalk($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[3]->find('#p24')[0])];
        }

        if($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[5]){
            $living['final'] = ['Final', self::getTalk($html->find('#section4')['0']->find('.pGroup')[0]->find('ul')[0]->find('li')[4]->find('#p25')[0])];
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
        Meeting::firstOrCreate(['date' => $date],['metadata' => json_encode($meeting)]);
    }

    /**
     * Takes the talks titles from the living as christian section depending.
     *
     * @param Array $talk
     * @return void
     */
    private static function getTalk($talk)
    {
        if(($talk->find('strong') && $talk->find('strong')->count() > 0 ) && ($talk->find('a') && $talk->find('a')->count() > 0)){
            if($talk->text){
                if($talk->find('strong')[0]->find('em') && $talk->find('strong')[0]->find('em')->count() > 0){
                    if($talk->find('a')[0]->find('strong') && $talk->find('a')[0]->find('strong')->count() > 0){
                        return $talk->find('strong')[0]->find('em')[0]->text.$talk->find('a')[0]->find('strong')[0]->text.$talk->text;
                    }
                    else{
                        if($talk->find('a')[0]->find('em') && $talk->find('a')[0]->find('em')->count() > 0){
                            return $talk->find('strong')[0]->find('em')[0]->text.$talk->find('a')[0]->find('em')[0]->text.$talk->text;
                        }
                        else{
                            return $talk->find('strong')[0]->find('em')[0]->text.$talk->find('a')[0]->text.$talk->text;
                        }
                    } 
                }
                else{
                    if($talk->find('a')[0]->find('strong')  && $talk->find('a')[0]->find('strong')->count() > 0){
                        return $talk->find('strong')[0]->text.$talk->find('a')[0]->find('strong')[0]->text.$talk->text;
                    }
                    else{
                        return $talk->find('strong')[0]->text.$talk->find('a')[0]->text.$talk->text;
                    } 
                }  
            }
            else{
                if($talk->find('strong')[0]->find('em') && $talk->find('strong')[0]->find('em')->count() > 0){
                    if($talk->find('a')[0]->find('strong') && $talk->find('a')[0]->find('strong')->count() > 0){
                        return $talk->find('strong')[0]->find('em')[0]->text.$talk->find('a')[0]->find('strong')[0]->text;
                    }
                    else{
                        if($talk->find('a')[0]->find('em') && $talk->find('a')[0]->find('em')->count() > 0){
                            return $talk->find('strong')[0]->find('em')[0]->text.$talk->find('a')[0]->find('em')[0]->text;
                        }
                        else{
                            return $talk->find('strong')[0]->find('em')[0]->text.$talk->find('a')[0]->text;
                        }
                    } 
                }
                else{
                    if($talk->find('a')[0]->find('strong')  && $talk->find('a')[0]->find('strong')->count() > 0){
                        return $talk->find('strong')[0]->text.$talk->find('a')[0]->find('strong')[0]->text;
                    }
                    else{
                        return $talk->find('strong')[0]->text.$talk->find('a')[0]->text;
                    } 
                }  
            }
        }
        elseif(!($talk->find('strong') && $talk->find('strong')->count() > 0 ) && !($talk->find('a') && $talk->find('a')->count() > 0)){
            return $talk->text;
        }
        elseif(!($talk->find('strong') && $talk->find('strong')->count() > 0 ))
        {
            if($talk->text){
                if($talk->find('a')[0]->find('strong')[0]->find('em')){
                    return $talk->find('a')[0]->find('strong')[0]->find('em')[0]->text.$talk->text;
                }
                else{
                    return $talk->find('a')[0]->find('strong')[0]->text.$talk->text;
                }
            }
            else{
                if($talk->find('a')[0]->find('strong')[0]->find('em')){
                    return $talk->find('a')[0]->find('strong')[0]->find('em')[0]->text;
                }
                else{
                    return $talk->find('a')[0]->find('strong')[0]->text;
                }
            }
        }
        elseif(!($talk->find('a') && $talk->find('a')->count() > 0)){
            if($talk->text){
                if($talk->find('strong')[0]->find('em') && $talk->find('strong')[0]->find('em')->count() > 0){
                    return $talk->find('strong')[0]->find('em')[0]->text.$talk->text;
                }
                else{
                    return $talk->find('strong')[0]->text.$talk->text;
                }
            }
            else{
                if($talk->find('strong')[0]->find('em') && $talk->find('strong')[0]->find('em')->count() > 0){
                    return $talk->find('strong')[0]->find('em')[0]->text;
                }
                else{
                    return $talk->find('strong')[0]->text;
                }
            }
        }
    }
}