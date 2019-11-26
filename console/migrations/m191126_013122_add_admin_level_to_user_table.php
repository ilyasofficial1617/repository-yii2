<?php

use \yii\db\Migration;

class m191126_013122_add_admin_level_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'admin_level', $this->string()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'admin_level');
    }
}
