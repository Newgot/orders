<?php

namespace app\modules\order\models;

use app\modules\order\helpers\OrderUrlHelper;
use yii\base\Model;
use yii\db\Query;

/**
 * Service search model
 */
class ServiceSearch extends Model
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
            ->groupBy(Service::TABLE . '.id')
            ->filterWhere(OrderUrlHelper::getRulesFilter(Order::FILTER_NAMES));
    }
}
