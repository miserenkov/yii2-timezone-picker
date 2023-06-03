<?php

/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 10.03.2017 12:03
 */

namespace miserenkov\widgets;


use kartik\select2\Select2;
use yii\widgets\InputWidget;

class TimeZonePicker extends InputWidget
{
    use InteractsWithTimezonesList;

    public $pluginOptions = [];

    public $groupTimezones = true;

    public $template = '{name} ({offset})';

    public function run()
    {
        $timeZones = [];

        $groupTimezones = $this->groupTimezones;
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        foreach (static::getTimeZoneList() as $timeZone) {
            $now->setTimezone(new \DateTimeZone($timeZone));
            $timeZoneExp = explode('/', $timeZone == 'UTC' ? 'UTC/UTC' : $timeZone);

            $content = preg_replace_callback("/{\\w+}/", function ($matches) use ($timeZone, $timeZoneExp, $now, $groupTimezones) {
                switch ($matches[0]) {
                    case '{name}':
                        return $groupTimezones ? $timeZoneExp[1] : $timeZone;
                    case '{offset}':
                        return $now->format('P');
                    default:
                        return $matches[0];
                }
            }, $this->template);

            if ($groupTimezones) {
                $timeZones[$timeZoneExp[0]][$timeZone] = $content;
            } else {
                $timeZones[$timeZone] = $content;
            }
        }

        if ($this->hasModel()) {
            echo Select2::widget([
                'model' => $this->model,
                'attribute' => $this->attribute,
                'data' => $timeZones,
                'options' => $this->options,
                'pluginOptions' => $this->pluginOptions,
            ]);
        } else {
            echo Select2::widget([
                'name' => !empty($this->name) ? $this->name : 'timezone-select',
                'data' => $timeZones,
                'options' => $this->options,
                'pluginOptions' => $this->pluginOptions,
            ]);
        }
    }
}
