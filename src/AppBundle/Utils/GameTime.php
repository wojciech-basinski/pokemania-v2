<?php
namespace AppBundle\Utils;

class GameTime
{
    public static function time2string(int $timeline)
    {
        $periods = ['dni' => 86400, 'godzin' => 3600, 'minut' => 60, 'sekund' => 1];
        $ret = '';
        foreach ($periods as $name => $seconds) {
            $num = floor($timeline / $seconds);
            $timeline -= ($num * $seconds);
            if ($num) {
                $ret .= "{$num} {$name} ";
            }
        }
        return trim($ret);
    }
}
