<?php

use app\modules\order\helpers\OrderUrlHelper;
use app\modules\order\models\Order;
use yii\helpers\Url;

/** @var array $queryParams */
/** @var array $errors */
?>

<ul class="nav nav-tabs p-b">
    <li class="<?= OrderUrlHelper::ruleFilter('status', Order::FILTER_NAMES) === '' ? 'active' : '' ?>">
        <a href="<?= Url::to(['order/']) ?>">
            <?= Yii::t('order', 'All orders') ?>
        </a>
    </li>
    <?php foreach (Order::STATUSES as $statusId => $statusName): ?>
        <li class="<?= OrderUrlHelper::ruleFilter('status', Order::FILTER_NAMES) === (string)$statusId ? 'active' : '' ?>">
            <a href="<?= Url::to(['order/', 'status' => $statusId]) ?>">
                <?= Yii::t('order', $statusName) ?>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="pull-right custom-search">
        <form
                class="form-inline"
                action="<?= Url::to(OrderUrlHelper::unset('order/', ['search', 'search_type'])) ?>"
                method="get"
        >
            <div class="input-group">
                <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="<?= trim($queryParams['search']) ?>"
                        placeholder="Search orders"
                >
                <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search_type">
                <?php foreach (Order::SEARCHES as $searchId => $searchName): ?>
                    <option
                            value="<?= $searchId ?>"
                      <?= $queryParams['searchType'] === (string)$searchId ? 'selected=""' : '' ?>
                  ><?= $queryParams['searchType'] === $searchId ?>
                        <?= Yii::t('order', $searchName) ?>
                  </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
            </div>
        </form>
    </li>
</ul>
<?php if (count($errors) > 0): ?>
    <div class="p-a bg-danger m-b">
        <?php foreach ($errors as $error): ?>
            <p class="text-danger"><?= $error[0] ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

