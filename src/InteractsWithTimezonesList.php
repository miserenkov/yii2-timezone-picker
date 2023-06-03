<?php

/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 03.06.2023 18:06
 */

namespace miserenkov\widgets;

use DateTimeZone;

trait InteractsWithTimezonesList
{
    /**
     * @var array
     */
    private static $_timeZoneList = null;

    /**
     * @return array
     */
    protected static function getTimeZoneList()
    {
        if (self::$_timeZoneList === null) {
            self::$_timeZoneList = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        }

        if (!in_array('Europe/Kiev', self::$_timeZoneList)) {
            self::$_timeZoneList[] = 'Europe/Kiev';
        }

        if (!in_array('Europe/Kyiv', self::$_timeZoneList)) {
            self::$_timeZoneList[] = 'Europe/Kyiv';
        }

        return self::$_timeZoneList;
    }
}
