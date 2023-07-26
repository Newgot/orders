<?php

use order\helpers\OrderUrlHelper;
use order\models\Order;
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
                <li class="<?= OrderUrlHelper::ruleFilter('service_id', Order::FILTER_NAMES) === Order::SERVICES_ALL ? 'active' : '' ?>">
                    <a href="<?= Url::to(OrderUrlHelper::unset('order/', ['service_id'])); ?>">
                        <?= Yii::t('order', 'All') ?> (<?= $countServices ?>)
                    </a>
                </li>
                <?php foreach ($services as $service): ?>
                    <li class="<?= OrderUrlHelper::ruleFilter('service_id', Order::FILTER_NAMES) === $service['id'] ? 'active' : '' ?>">
                        <a href="<?= Url::to(OrderUrlHelper::set('order/', ['service_id' => $service['id']]), true) ?>">
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
                <li class="<?= OrderUrlHelper::ruleFilter('mode', Order::FILTER_NAMES) === Order::MODE_ALL ? 'active' : '' ?>">
                    <a href="<?= Url::to(OrderUrlHelper::unset('order/', ['mode'])) ?>">
                        <?= Yii::t('order', 'All') ?>
                    </a>
                </li>
                <?php foreach (Order::MODES as $modeId => $modeName): ?>
                    <li class="<?= OrderUrlHelper::ruleFilter('mode', Order::FILTER_NAMES) === $modeId ? 'active' : '' ?>">
                        <a href="<?= Url::to(OrderUrlHelper::set('order/', ['mode' => $modeId])) ?>">
                            <?= Yii::t('order', $modeName) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </th>
    <th><?= Yii::t('order', 'Created') ?></th>
</tr>
</thead>
