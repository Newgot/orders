<?php

namespace app\modules\order\models;

use yii\db\ActiveRecord;

/**
 * User model
 */
class User extends ActiveRecord
{
    public const TABLE = 'users';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{' . self::TABLE . '}}';
    }

}