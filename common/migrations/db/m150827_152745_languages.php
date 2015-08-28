<?php

use yii\db\Migration;

class m150827_152745_languages extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%languages}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'locale' => $this->string(6)->notNull(),
            'active' => $this->boolean()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(500),
            'flag_base_url' => $this->string(1024),
            'flag_path' => $this->string(1024),
            'flag_type' => $this->string()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%languages}}');
    }
}
