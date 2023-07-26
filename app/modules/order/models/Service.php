<?php

namespace order\models;

use yii\db\ActiveRecord;

/**
 * Service model
 * @property int $id
 * @property string $name
 */
class Service extends ActiveRecord
{
    public const TABLE = 'services';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{' . self::TABLE . '}}';
    }
}
