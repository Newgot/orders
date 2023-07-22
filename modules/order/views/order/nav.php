<?php

use app\modules\order\helpers\OrderUrlHelper;
use app\modules\order\models\Order;
use yii\helpers\Url;

/** @var array $queryParams */
?>

<ul class="nav nav-tabs p-b">
    <li class="<?= Order::ruleFilter('status') === '' ? 'active' : '' ?>">
        <a href="<?= Url::to(['index']) ?>">
            <?= Yii::t('order', 'All orders') ?>
        </a>
    </li>
    <li class="<?= Order::ruleFilter('status') === '0' ? 'active' : '' ?>">
        <a href="<?= Url::to(['index', 'status' => 0]) ?>">
            <?= Yii::t('order', 'Pending') ?>
        </a>
    </li>
    <li class="<?= Order::ruleFilter('status') === '1' ? 'active' : '' ?>">
        <a href="<?= Url::to(['index', 'status' => 1]) ?>">
            <?= Yii::t('order', 'In progress') ?>
        </a>
    </li>
    <li class="<?= Order::ruleFilter('status') === '2' ? 'active' : '' ?>">
        <a href="<?= Url::to(['index', 'status' => 2]) ?>">
            <?= Yii::t('order', 'Completed') ?>
        </a>
    </li>
    <li class="<?= Order::ruleFilter('status') === '3' ? 'active' : '' ?>">
        <a href="<?= Url::to(['index', 'status' => 3]) ?>">
            <?= Yii::t('order', 'Canceled') ?>
        </a>
    </li>
    <li class="<?= Order::ruleFilter('status') === '4' ? 'active' : '' ?>">
        <a href="<?= Url::to(['index', 'status' => 4]) ?>">
            <?= Yii::t('order', 'Error') ?>
        </a>
    </li>
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
                  <?= $queryParams['searchType'] === Order::SEARCH_ID ?: 'selected=""' ?>
              >
                  <?= Yii::t('order', 'Order ID') ?>
              </option>
              <option
                  value="2"
              <?= $queryParams['searchType'] === Order::SEARCH_LINK ?: 'selected=""' ?>
              >
                  <?= Yii::t('order', 'Link') ?>
              </option>
              <option value="3"
              <?= $queryParams['searchType'] === Order::SEARCH_NAME ?: 'selected=""' ?>
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
