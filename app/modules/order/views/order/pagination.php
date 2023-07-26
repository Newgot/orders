<?php

use yii\data\Pagination;
use yii\widgets\LinkPager;

/** @var Pagination $pagination */
/** @var array $pageCount */
?>

<div class="row">
    <div class="col-sm-8">
        <nav>
            <?= LinkPager::widget([
                'pagination' => $pagination
            ]) ?>
        </nav>
    </div>
    <div class="col-sm-4 pagination-counters">

        <?= Yii::t('order', '{start} to {end} of {all}', $pageCount) ?>
    </div>
</div>
