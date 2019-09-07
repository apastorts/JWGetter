<?php

namespace Apastorts\JWGetter\Services;

class TalkService
{
    public static function get($talk)
    {
        return self::organize($talk);
    }

    public static function organize($talk)
    {
        $talk = $talk ? self::strip($talk) : '' ;

        $talk = str_replace(': video (', ' (', $talk);
        $talk = str_replace('the .', 'the video.', $talk);

        $talk = str_replace(': sample conversation (', ' (', $talk);
        $talk = str_replace('the ,', 'the sample conversation,', $talk);
        $talk = str_replace('the . ()', 'the sample conversation.', $talk);

        $talk = str_replace(': video (', ' (', $talk);
        $talk = str_replace('the .', 'the video.', $talk);

        $talk = str_replace('Ideas para conversar (', '(', $talk);
        $talk = str_replace('sección “”', 'sección "Ideas para conversar"', $talk);

        $talk = str_replace('()', '', $talk);
        $talk = str_replace('“', '', $talk);
        $talk = str_replace('“”', '', $talk);

        return $talk;
    }

    /**
     * Takes the talks titles and descriptions from the midweek meeting html.
     *
     * @param Array $talk
     * @return void
     */
    public static function strip($talk)
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
