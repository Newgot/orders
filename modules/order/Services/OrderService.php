<?php

namespace app\modules\order\Services;

use app\modules\order\models\Order;
use app\modules\order\models\Service;
use Yii;
use yii\data\Pagination;
use yii\db\Query;

class OrderService
{
    protected const PAGINATION_LIMIT = 100;

    /**
     * get order list
     * @param int $offset
     * @return array
     */
    public function getOrders(int $offset = 0): array
    {
        $orderQuery = Order::scopeAll()
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
        $count = Order::search(Order::scopeOrdersQuery())->count();
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
            'all' => Order::search(Order::scopeOrdersQuery())->count(),
            'start' => self::PAGINATION_LIMIT * ($page - 1) + 1,
            'end' => self::PAGINATION_LIMIT * $page,
        ];
    }

    /**
     * get csv file
     * @return string
     */
    public function csv(): string
    {
        $file = $this->getCSVHead();
        foreach (Order::search(Order::scopeAll())->all() as $order) {
            /** @var Order $order */
            $created = date('Y-m-d H:i:s');
            $file .= "$order->id, $order->name, $order->link, $order->quantity, ";
            $file .= "{$order->service->name}, $order->statusName, $order->modeName, $created" . PHP_EOL;
        }
        return $file;
    }

    /**
     * get names line from csv
     * @return string
     */
    protected function getCSVHead(): string
    {
        return
            Yii::t('order', 'ID') . ', ' .
            Yii::t('order', 'User') . ', ' .
            Yii::t('order', 'Link') . ', ' .
            Yii::t('order', 'Quantity') . ', ' .
            Yii::t('order', 'Service') . ', ' .
            Yii::t('order', 'Status') . ', ' .
            Yii::t('order', 'Mode') . ', ' .
            Yii::t('order', 'Created') . PHP_EOL;
    }
}
