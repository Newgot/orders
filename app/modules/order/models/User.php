<?php

namespace order\models;

use yii\db\ActiveRecord;

/**
 * User model
 * @property int $id
 * @property string $first_name
 * @property string $last_name
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