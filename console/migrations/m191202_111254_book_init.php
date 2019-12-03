<?php

use yii\db\Migration;

class m191202_111254_book_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'subject_id' => $this->string()->notNull(),
            'book_name' => $this->string()->notNull(),
            'author' => $this->string()->notNull(),
            'release_year' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%book}}');
    }
}
