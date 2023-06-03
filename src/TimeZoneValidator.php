<?php
/**
 * Created by PhpStorm.
 * Author: Misha Serenkov
 * Email: mi.serenkov@gmail.com
 * Date: 10.03.2017 12:04
 */

namespace miserenkov\validators;


use miserenkov\widgets\InteractsWithTimezonesList;
use yii\validators\Validator;

class TimeZoneValidator extends Validator
{
    use InteractsWithTimezonesList;

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        if (!in_array($model->{$attribute}, self::getTimeZoneList())) {
            $this->addError($model, $attribute, 'Invalid time zone');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (!in_array($value, self::getTimeZoneList())) {
            return ['Invalid time zone', []];
        }

        return null;
    }
}
