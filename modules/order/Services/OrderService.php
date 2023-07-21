<?php

namespace app\modules\order\Services;

use app\modules\order\models\Order;
use app\modules\order\models\Service;
use app\modules\order\models\User;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\Query;

class OrderService
{
    protected const PAGINATION_LIMIT = 100;

    /**
     * get order list
     * @param int $offset
     * @return array
     */
    public function getOrders(int $offset): array
    {
        $orderQuery = static::scopeOrdersQuery()
            ->joinWith(['user' => function ($query) {
                $query->from(User::TABLE);
            }])
            ->joinWith(['service' => function ($query) {
                $query->from(Service::TABLE);
            }])
            ->offset($offset)
            ->limit(self::PAGINATION_LIMIT);

        return Order::search($orderQuery)->all();
    }

    /**
     * create pagination HTML
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        $count = Order::search(static::scopeOrdersQuery())->count();
        return new Pagination([
            'pageSize' => self::PAGINATION_LIMIT,
            'totalCount' => $count,

        ]);
    }

    /**
     * get service's list
     * @return array
     */
    public function getServices(): array
    {
        $services = (new Query())
            ->from(Service::TABLE)
            ->select([
                Service::TABLE . '.id',
                Service::TABLE . '.name',
                'COUNT(*) as cnt'
            ])
            ->leftJoin(Order::TABLE, Service::TABLE . '.id = ' . Order::TABLE . '.service_id')
            ->groupBy(Service::TABLE . '.id')
            ->all();
        $res = [];
        foreach ($services as $service) {
            $res[$service['id']] = $service;
        }
        return $res;
    }

    /**
     * total number of services
     * @param array $services
     * @return int
     */
    public function countService(array $services): int
    {
        return array_reduce($services, function ($sum, $service) {
            return $sum + ((int)$service['cnt']);
        }, 0);
    }

    /**
     * get first, last and number of orders  per page
     * @param int $page
     * @return array
     */
    public function getPageCounts(int $page): array
    {
        return [
            'all' => Order::search(static::scopeOrdersQuery())->count(),
            'start' => self::PAGINATION_LIMIT * ($page - 1) + 1,
            'end' => self::PAGINATION_LIMIT * $page,
        ];
    }

    /**
     * scope of order query
     * @return ActiveQuery
     */
    protected static function scopeOrdersQuery(): ActiveQuery
    {
        return Order::find()
            ->select([
                Order::TABLE . '.*',
                User::TABLE . '.first_name',
                User::TABLE . '.last_name',
                Service::TABLE . '.name',
            ])
            ->filterWhere(Order::rulesFilter());
    }
}
