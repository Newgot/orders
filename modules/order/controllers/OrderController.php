<?php

namespace app\modules\order\controllers;

use app\modules\order\models\Order;
use app\modules\order\models\Service;
use app\modules\order\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\Controller;

class OrderController extends Controller
{
    /**
     * @throws InvalidArgumentException
     */
    public function actionIndex(): string
    {
        $orders = Order::find()
            ->select([
                Order::TABLE . '.*',
                User::TABLE . '.first_name',
                User::TABLE . '.last_name',
                Service::TABLE. '.name',
            ])
            ->joinWith(['user' => function ($query) {
                $query->from(User::TABLE);
            }])
            ->joinWith(['service' => function ($query) {
                $query->from(Service::TABLE);
            }])
            ->limit(100)
            ->all();
        Yii::error(print_r($orders[0], true));
        return $this->render('index', ['orders' => $orders]);
    }



}