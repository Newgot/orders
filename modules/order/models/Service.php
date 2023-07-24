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

    public static function getAllServices(): Query
    {
        return (new Query())
            ->from(Service::TABLE)
            ->select([
                Service::TABLE . '.id',
                Service::TABLE . '.name',
                'COUNT(*) as cnt'
            ])
            ->leftJoin(Order::TABLE, Service::TABLE . '.id = ' . Order::TABLE . '.service_id')
            ->groupBy(Service::TABLE . '.id');
    }

}