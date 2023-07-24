<?php

/** @var array $orders */
/** @var array $services */

?>

<tbody>
<?php foreach ($orders as $order): ?>
    <tr>
        <td><?= $order->id ?></td>
        <td><?= $order->user->first_name ?> <?= $order->user->last_name ?></td>
        <td class="link"><?= $order->link ?></td>
        <td><?= $order->quantity ?></td>
        <td class="service">
            <span class="label-id"><?= $services[$order->serviceOrder->id]['cnt'] ?></span>
            <?= $order->serviceOrder->name ?>
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
