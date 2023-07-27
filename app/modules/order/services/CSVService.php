<?php

namespace order\services;

use order\models\Order;
use order\models\search\OrderSearch;
use Yii;


/**
 * cvs rendering service
 */
class CSVService
{

    public OrderSearch $model;

    public function __construct()
    {
        $this->model = new OrderSearch();
    }

    /**
     * render loaded csv
     * @return void
     */
    public function load(): void
    {
        ob_start();
        $file = fopen('php://output', 'w');
        $this->setCSVHead($file);
        $this->setOrders($file);
        ob_end_flush();
    }

    /**
     * render orders used flush buffer's
     * @param $file
     * @return void
     */
    protected function setOrders($file): void
    {
        $i = 0;
        $limit = 1000;
        do {

            $orders = $this->model->search()
                ->offset($i * $limit)
                ->limit($limit)
                ->all();
            foreach ($orders as $order) {
                /** @var Order $order */
                fputcsv($file, [
                    $order->id,
                    $order->name,
                    $order->link,
                    $order->quantity,
                    $order->serviceOrder->name,
                    $order->statusName,
                    $order->modeName,
                    date('Y-m-d H:i:s', $order->created_at),
                ]);
            }
            $i++;
            ob_flush();
            flush();
        } while (count($orders));
        fclose($file);

    }

    /**
     * get names line from csv
     * @param $file
     * @return void
     */
    protected function setCSVHead($file): void
    {
        fputcsv($file, [
            Yii::t('order', 'ID'),
            Yii::t('order', 'User'),
            Yii::t('order', 'Link'),
            Yii::t('order', 'Quantity'),
            Yii::t('order', 'Service'),
            Yii::t('order', 'Status'),
            Yii::t('order', 'Mode'),
            Yii::t('order', 'Created'),
        ]);
    }
}