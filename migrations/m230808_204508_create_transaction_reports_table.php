<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaction_reports}}`.
 */
class m230808_204508_create_transaction_reports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction_reports}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transaction_reports}}');
    }
}
