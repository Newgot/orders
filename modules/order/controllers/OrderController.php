<?php

namespace app\modules\order\controllers;

use app\modules\order\helpers\OrderUrlHelper;
use app\modules\order\models\Order;
use app\modules\order\Services\OrderService;
use Yii;
use yii\web\Controller;

class OrderController extends Controller
{
    protected ?OrderService $service = null;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = new OrderService();
    }

    /**
     * render main page
     * @param int $page
     * @return string
     */
    public function actionIndex(int $page = 1): string
    {
        $pagination = $this->service->getPagination();
        $orders = $this->service->getOrders($pagination->offset);
        $pageCount = $this->service->getPageCounts($page);
        $services = $this->service->getServices();
        $countServices = $this->service->countService($services);
        return $this->render('index', [
            'orders' => $orders,
            'services' => $services,
            'countServices' => $countServices,
            'pagination' => $pagination,
            'pageCount' => $pageCount,
            'queryParams' => [
                'search' => Yii::$app->request->queryParams['search'] ?? '',
                'searchType' => Yii::$app->request->queryParams['search-type'] ?? '',
            ],
        ]);
    }

    /**
     * generate csv file
     * @return string
     */
    public function actionLoad(): string
    {
        ini_set('memory_limit', '2G');
        OrderUrlHelper::setCSVHeader();
        return $this->service->csv();
    }
}
