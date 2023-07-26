<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m230718_065016_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'link' => $this->string(300)->notNull(),
            'quantity' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger(1)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'mode' => $this->tinyInteger(1)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
