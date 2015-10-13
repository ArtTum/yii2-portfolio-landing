<?php

use yii\db\Migration;

class m150827_151006_skills extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%skills}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(100),
            'active' => $this->boolean()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(500),
            'icon_name' => $this->string(1024),
            'mark' => $this->smallInteger(),
        ], $tableOptions);

        $this->createTable('{{%skills_lang}}', [
            'id' => $this->primaryKey(),
            'skill_id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'title' => $this->text(),
            'description' => $this->text()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%skills}}');
        $this->dropTable('{{%skills_lang}}');
    }
}
