<?php

use yii\db\Migration;

class m150827_150911_widget_menu_item extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%widget_menu_item}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'active' => $this->boolean()->defaultValue(1),
            'sort' => $this->integer()->notNull()->defaultValue(500)
        ], $tableOptions);

        $this->createTable('{{%widget_menu_item_lang}}', [
            'id' => $this->primaryKey(),
            'widget_menu_item_id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'name' => $this->string(1024),
            'url' => $this->string()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%widget_menu_item}}');
        $this->dropTable('{{%widget_menu_item_lang}}');
    }
}
