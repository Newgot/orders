<?php

use app\modules\order\helpers\OrderUrlHelper;
use app\modules\order\models\Order;
use yii\helpers\Url;

/** @var array $services */
/** @var int $countServices */
?>

<thead>
<tr>
    <th><?= Yii::t('order', 'ID') ?></th>
    <th><?= Yii::t('order', 'User') ?></th>
    <th><?= Yii::t('order', 'Link') ?></th>
    <th><?= Yii::t('order', 'Quantity') ?></th>
    <th class="dropdown-th">
        <div class="dropdown">
            <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <?= Yii::t('order', 'Service') ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="<?= Order::ruleFilter('service_id') === Order::SERVICES_ALL ? 'active' : '' ?>">
                    <a href="<?= Url::to(OrderUrlHelper::unset('index', ['service_id'])); ?>">
                        <?= Yii::t('order', 'All') ?> (<?= $countServices ?>)
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
    <th><?= Yii::t('order', 'Status') ?></th>
    <th class="dropdown-th">
        <div class="dropdown">
            <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <?= Yii::t('order', 'Mode') ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="<?= Order::ruleFilter('mode') === Order::MODE_ALL ? 'active' : '' ?>">
                    <a href="<?= Url::to(OrderUrlHelper::unset('index', ['mode'])) ?>">
                        <?= Yii::t('order', 'All') ?>
                    </a>
                </li>
                <li class="<?= Order::ruleFilter('mode') === Order::MODE_MANUAL ? 'active' : '' ?>">
                    <a href="<?= Url::to(OrderUrlHelper::set('index', ['mode' => '0'])) ?>">
                        <?= Yii::t('order', 'Manual') ?>
                    </a>
                </li>
                <li class="<?= Order::ruleFilter('mode') === Order::MODE_AUTO ? 'active' : '' ?>">
                    <a href="<?= Url::to(OrderUrlHelper::set('index', ['mode' => '1'])) ?>">
                        <?= Yii::t('order', 'Auto') ?>
                    </a>
                </li>
            </ul>
        </div>
    </th>
    <th><?= Yii::t('order', 'Created') ?></th>
</tr>
</thead>
