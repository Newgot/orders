<?php

use app\modules\order\helpers\OrderUrlHelper;
use app\modules\order\models\Order;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\data\Pagination;

/** @var yii\web\View $this */
/** @var array $orders */
/** @var array $services */
/** @var int $countServices */
/** @var Pagination $pagination */
/** @var array $pageCount */
/** @var array $queryParams */

$this->title = 'Order'
?>

<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li class="<?= Order::ruleFilter('status') === '' ? 'active' : '' ?>">
            <a href="<?= Url::to(['index']) ?>">
                All orders
            </a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '0' ? 'active' : '' ?>">
            <a href="<?= Url::to(['index', 'status' => 0]) ?>">
                Pending
            </a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '1' ? 'active' : '' ?>">
            <a href="<?= Url::to(['index', 'status' => 1]) ?>">
                In progress
            </a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '2' ? 'active' : '' ?>">
            <a href="<?= Url::to(['index', 'status' => 2]) ?>">
                Completed
            </a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '3' ? 'active' : '' ?>">
            <a href="<?= Url::to(['index', 'status' => 3]) ?>">
                Canceled
            </a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '4' ? 'active' : '' ?>">
            <a href="<?= Url::to(['index', 'status' => 4]) ?>">
                Error
            </a>
        </li>
        <?php var_dump($queryParams);?>

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
                  Order ID
              </option>
              <option
                      value="2"
              <?= $queryParams['searchType'] === Order::SEARCH_LINK ?: 'selected=""' ?>
              >
                  Link
              </option>
              <option value="3"
              <?= $queryParams['searchType'] === Order::SEARCH_NAME ?: 'selected=""' ?>
              >
                  Username
              </option>
            </select>
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
                </div>
            </form>
        </li>
    </ul>
    <table class="table order-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Link</th>
            <th>Quantity</th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Service
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="<?= Order::ruleFilter('service_id') === '' ? 'active' : '' ?>">
                            <a href="<?= Url::to(OrderUrlHelper::unset('index', ['service_id'])); ?>">
                                All (<?= $countServices ?>)
                            </a>
                        </li>
                        <?php foreach ($services as $service): ?>
                            <li class="<?= Order::ruleFilter('service_id') === $service['id'] ? 'active' : '' ?>">
                                <a href="<?= Url::to(OrderUrlHelper::set('index', ['service_id' => $service['id']]), true) ?>">
                                    <span class="label-id"><?= $service['cnt'] ?></span>
                                    <?= $service['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </th>
            <th>Status</th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Mode
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="<?= Order::ruleFilter('mode') === '' ? 'active' : '' ?>">
                            <a href="<?= Url::to(OrderUrlHelper::unset('index', ['mode'])) ?>">
                                All
                            </a>
                        </li>
                        <li class="<?= Order::ruleFilter('mode') === '0' ? 'active' : '' ?>">
                            <a href="<?= Url::to(OrderUrlHelper::set('index', ['mode' => '0'])) ?>">
                                Manual
                            </a>
                        </li>
                        <li class="<?= Order::ruleFilter('mode') === '1' ? 'active' : '' ?>">
                            <a href="<?= Url::to(OrderUrlHelper::set('index', ['mode' => '1'])) ?>">
                                Auto
                            </a>
                        </li>
                    </ul>
                </div>
            </th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order->id ?></td>
                <td><?= $order->user->first_name ?> <?= $order->user->last_name ?></td>
                <td class="link"><?= $order->link ?></td>
                <td><?= $order->quantity ?></td>
                <td class="service">
                    <span class="label-id"><?= $services[$order->service->id]['cnt'] ?></span>
                    <?= $order->service->name ?>
                </td>
                <td><?= $order->statusName ?></td>
                <td><?= $order->modeName ?></td>
                <td>
                    <span class="nowrap"><?= $order->createdDate[0] ?></span>
                    <span class="nowrap"><?= $order->createdDate[1] ?></span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-8">
            <nav>
                <?= LinkPager::widget([
                    'pagination' => $pagination
                ]) ?>
            </nav>
        </div>
        <div class="col-sm-4 pagination-counters">
            <?= $pageCount['start'] ?> to <?= $pageCount['end'] ?> of <?= $pageCount['all'] ?>
        </div>
    </div>

</div>