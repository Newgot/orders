<?php

namespace order\controllers;

use JetBrains\PhpStorm\NoReturn;
use order\helpers\OrderUrlHelper;
use order\services\CSVService;
use order\services\OrderService;
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
    protected ?CSVService $csvService = null;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = new OrderService();
        $this->csvService = new CSVService();
    }

    /**
     * render main page
     * @param int $page
     * @return Response | string
     */
    public function actionIndex(int $page = 1): string|Response
    {
        if (Yii::$app->request->url === self::HOME_URL) {
            return $this->redirect(['order/']);
        }

        $pagination = $this->service->getPagination();
        $orders = $this->service->getOrders($pagination->offset);
        $errors = $this->service->getErrors();
        $pageCount = $this->service->getPageCounts($page);
        $services = $this->service->getServiceOrders();
        $countServices = $this->service->countService($services);
        $queryParams = $this->service->getQueryParams();
        return $this->render('index', [
            'orders' => $orders,
            'errors' => $errors,
            'services' => $services,
            'countServices' => $countServices,
            'pagination' => $pagination,
            'pageCount' => $pageCount,
            'queryParams' => $queryParams,
        ]);
    }

    /**
     * generate csv file
     * @return void
     */
    #[NoReturn] public function actionLoad(): void
    {
        $this->layout = '';
        OrderUrlHelper::setCSVHeader();
        $this->csvService->load();
        exit();
    }
}