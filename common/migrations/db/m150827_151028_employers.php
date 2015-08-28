<?php

use yii\db\Migration;

class m150827_151028_employers extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%employers}}', [
            'id' => $this->primaryKey(),
            'active' => $this->boolean()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(500),
            'image_base_url' => $this->string(1024),
            'image_path' => $this->string(1024),
            'image_type' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%employers_lang}}', [
            'id' => $this->primaryKey(),
            'employer_id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'title' => $this->text(),
            'description' => $this->text(),
            'position' => $this->string(),
            'period' => $this->string()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%employers}}');
        $this->dropTable('{{%employers_lang}}');
    }
}
