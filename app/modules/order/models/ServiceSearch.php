<?php

namespace app\modules\order\models;

use yii\db\Query;

/**
 * Service search model
 */
class ServiceSearch extends Service
{
    /**
     * @return Query
     */
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
