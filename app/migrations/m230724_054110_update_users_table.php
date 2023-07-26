<?php

use yii\db\Migration;

class m230724_054110_update_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx_user_name',
            '{{%users}}',
            ['first_name', 'last_name'],
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx_user_name',
            '{{%users}}'
        );
    }
}
