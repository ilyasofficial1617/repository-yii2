<?php

use \yii\db\Migration;

class m191203_042116_add_filename_column_to_book_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%book}}', 'filename', $this->string()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%book}}', 'filename');
    }
}
