<?php

use yii\db\Migration;

class m150827_151646_hobbies extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%hobbies}}', [
            'id' => $this->primaryKey(),
            'active' => $this->boolean()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(500),
            'icon_base_url' => $this->string(1024),
            'icon_path' => $this->string(1024),
            'icon_type' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%hobbies_lang}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'language' => $this->string()->notNull(),
            'name' => $this->string(),
            'description' => $this->text()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%hobbies}}');
        $this->dropTable('{{%hobbies_lang}}');
    }
}
