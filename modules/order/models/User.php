<?php

namespace app\modules\order\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public const TABLE = 'users';
    public static function tableName(): string
    {
        return '{{'. self::TABLE .'}}';
    }

}