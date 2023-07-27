<?php

namespace order\services;

use order\models\search\ServiceSearch;
use order\models\search\OrderSearch;
use Yii;
use yii\data\Pagination;

/**
 * Business-logic order module
 */
class OrderService
{
    protected const PAGINATION_LIMIT = 100;
    public OrderSearch $model;

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
}
