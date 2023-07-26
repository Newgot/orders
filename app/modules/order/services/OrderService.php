<?php

namespace app\modules\order\services;

use app\modules\order\models\Order;
use app\modules\order\models\OrderSearch;
use app\modules\order\models\ServiceSearch;
use Yii;
use yii\data\Pagination;

/**
 * Business-logic order module
 */
class OrderService
{
    protected const PAGINATION_LIMIT = 100;
    protected OrderSearch $model;

    public function __construct()
    {
        $this->model = new OrderSearch();
        $this->model->setQueryParams(Yii::$app->request->get());
    }

    /**
     * get order list
     * @param int $offset
     * @return array
     */
    public function getOrders(int $offset = 0): array
    {
        return $this->model->search()
            ->offset($offset)
            ->limit(self::PAGINATION_LIMIT)
            ->all();
    }

    /**
     * create pagination HTML
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        $count = $this->model->search()->count();
        return new Pagination([
            'totalCount' => $count,
        ]);
    }

    /**
     * get service's list
     * @return array
     */
    public function getServiceOrders(): array
    {
        $services = ServiceSearch::getAllServices()->all();
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
     * get validate errors
     * @return array
     */
    public function getErrors(): array
    {
        return $this->model->getErrors();
    }

    /**
     * get first, last and number of orders  per page
     * @param int $page
     * @return array
     */
    public function getPageCounts(int $page): array
    {
        return [
            'all' => $this->model->search()->count(),
            'start' => self::PAGINATION_LIMIT * ($page - 1) + 1,
            'end' => self::PAGINATION_LIMIT * $page,
        ];
    }

    /**
     * gut used query params
     * @return array
     */
    public function getQueryParams(): array
    {
        return [
            'search' => Yii::$app->request->queryParams['search'] ?? '',
            'searchType' => Yii::$app->request->queryParams['search_type'] ?? '',
        ];
    }

    /**
     * get csv file
     * @return string
     */
    public function csv(): string
    {
        $file = $this->getCSVHead();
        foreach ($this->model->search()->all() as $order) {
            /** @var Order $order */
            $file .= "$order->id, $order->name, $order->link, $order->quantity, ";
            $file .= "{$order->serviceOrder->name}, $order->statusName, $order->modeName, ";
            $file .= "{$order->createdDate['0']} {$order->createdDate['1']} " . PHP_EOL;
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
