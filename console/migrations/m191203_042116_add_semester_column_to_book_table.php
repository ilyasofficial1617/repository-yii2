<?php

use \yii\db\Migration;

class m191203_042116_add_semester_column_to_book_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%book}}', 'semester', $this->integer()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%book}}', 'semester');
    }
}
