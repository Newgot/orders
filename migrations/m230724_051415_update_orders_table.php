<?php

use yii\db\Migration;

class m230724_051415_update_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx_orders_link',
            '{{%orders}}',
            'link'
        );

        $this->createIndex(
            'idx_orders_status',
            '{{%orders}}',
            'status'
        );

        $this->createIndex(
            'idx_orders_mode',
            '{{%orders}}',
            'mode'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx_orders_link',
            '{{%orders}}'
        );

        $this->dropIndex(
            'idx_orders_status',
            '{{%orders}}'
        );

        $this->dropIndex(
            'idx_orders_mode',
            '{{%orders}}'
        );

        return false;
    }
}
