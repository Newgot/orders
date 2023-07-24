<?php

use app\modules\order\helpers\OrderUrlHelper;
use app\modules\order\models\Order;
use yii\helpers\Url;

/** @var array $queryParams */
?>

<ul class="nav nav-tabs p-b">
    <?php foreach (Order::STATUSES as $statusId => $statusName): ?>
        <li class="<?= Order::ruleFilter('status') === $statusId ? 'active' : '' ?>">
            <a href="<?= Url::to(['index', 'status' => $statusId]) ?>">
                <?= Yii::t('order', $statusName) ?>
            </a>
        </li>
    <?php endforeach; ?>

    <li class="pull-right custom-search">
        <form
                class="form-inline"
                action="<?= Url::to(OrderUrlHelper::unset('index', ['search', 'search-type'])) ?>"
                method="get"
        >
            <div class="input-group">
                <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="<?= $queryParams['search'] ?>"
                        placeholder="Search orders"
                >
                <span class="input-group-btn search-select-wrap">
            <select class="form-control search-select" name="search-type">
              <option
                      value="1"
                  <?= $queryParams['searchType'] === Order::SEARCH_ID ? 'selected=""' : '' ?>
              >
                  <?= Yii::t('order', 'Order ID') ?>
              </option>
              <option
                      value="2"
              <?= $queryParams['searchType'] === Order::SEARCH_LINK ? 'selected=""' : '' ?>
              >
                  <?= Yii::t('order', 'Link') ?>
              </option>
              <option value="3"
              <?= $queryParams['searchType'] === Order::SEARCH_NAME ? 'selected=""' : '' ?>
              >
                  <?= Yii::t('order', 'Username') ?>
              </option>
            </select>
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
            </div>
        </form>
    </li>
</ul>
