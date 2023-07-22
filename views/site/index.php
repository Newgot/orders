<?php
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">


    <div class="d-flex">
        <a href="<?= Url::to(['order/order/']) ?>" class="btn btn-primary">Go to Order</a>
    </div>
</div>
