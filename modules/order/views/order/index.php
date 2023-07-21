<?php

use app\modules\order\models\Order;
use yii\widgets\LinkPager;
use yii\data\Pagination;
use app\modules\order\Facades\Filter;

/** @var yii\web\View $this */
/** @var array $orders */
/** @var array $services */
/** @var int $countServices */
/** @var Pagination $pagination */
/** @var array $pageCount */

$this->title = 'Order'
?>

<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li class="<?= Order::ruleFilter('status') === '' ? 'active' : '' ?>">
            <a href="#">All orders</a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '1' ? 'active' : '' ?>">
            <a href="#">Pending</a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '2' ? 'active' : '' ?>">
            <a href="#">In progress</a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '3' ? 'active' : '' ?>">
            <a href="#">Completed</a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '4' ? 'active' : '' ?>">
            <a href="#">Canceled</a>
        </li>
        <li class="<?= Order::ruleFilter('status') === '5' ? 'active' : '' ?>">
            <a href="#">Error</a>
        </li>
        <li class="pull-right custom-search">
            <form class="form-inline" action="/admin/orders" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                    <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="1" selected="">Order ID</option>
              <option value="2">Link</option>
              <option value="3">Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"
                                                                aria-hidden="true"></span></button>
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
                            <a href="">All (<?= $countServices ?>)</a>
                        </li>
                        <?php foreach ($services as $service): ?>
                            <li class="<?= Order::ruleFilter('service_id') === $service['id'] ? 'active' : '' ?>">
                                <a href="<?= $service['id'] ?>">
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
                            <a href="">All</a>
                        </li>
                        <li class="<?= Order::ruleFilter('mode') === '0' ? 'active' : '' ?>">
                            <a href="">Manual</a>
                        </li>
                        <li class="<?= Order::ruleFilter('mode') === '1' ? 'active' : '' ?>">
                            <a href="">Auto</a>
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