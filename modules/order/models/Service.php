<?php

namespace app\modules\order\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * Service model
 */
class Service extends ActiveRecord
{
    public const TABLE = 'services';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{'. self::TABLE .'}}';
    }



}