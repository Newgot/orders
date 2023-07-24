<?php

namespace app\modules\order\controllers;

use app\modules\order\helpers\OrderUrlHelper;
use app\modules\order\services\OrderService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Base controller order module
 */
class OrderController extends Controller
{
    protected const HOME_URL = '/';
    protected ?OrderService $service = null;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = new OrderService();
    }

    /**
     * render main page
     * @param int $page
     * @return Response | string
     */
    public function actionIndex(int $page = 1)
    {
        if (Yii::$app->request->url === self::HOME_URL) {
            return $this->redirect(['order/index']);
        }

        $pagination = $this->service->getPagination();
        $orders = $this->service->getOrders($pagination->offset);
        $pageCount = $this->service->getPageCounts($page);
        $services = $this->service->getServiceOrders();
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
