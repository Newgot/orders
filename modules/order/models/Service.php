<?php

namespace app\modules\order\models;

use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    public const TABLE = 'services';
    public static function tableName(): string
    {
        return '{{'. self::TABLE .'}}';
    }

}