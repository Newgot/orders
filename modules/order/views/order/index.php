<?php

use app\modules\order\Module;
use yii\data\Pagination;

/** @var yii\web\View $this */
/** @var array $orders */
/** @var array $services */
/** @var int $countServices */
/** @var Pagination $pagination */
/** @var array $pageCount */
/** @var array $queryParams */

$this->title = Module::TITLE
?>

<div class="container-fluid">
    <?= $this->render('nav', ['queryParams' => $queryParams]) ?>
    <table class="table order-table">
        <?= $this->render('table/head', [
            'services' => $services,
            'countServices' => $countServices,
        ])
        ?>
        <?= $this->render('table/body', [
            'services' => $services,
            'orders' => $orders,
        ])
        ?>
    </table>
    <?= $this->render('pagination', [
        'pagination' => $pagination,
        'pageCount' => $pageCount,
    ])
    ?>
</div>
