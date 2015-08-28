<?php

use yii\db\Migration;

class m150827_151038_projects extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%projects_type}}', [
            'id' => $this->primaryKey(),
            'active' => $this->boolean()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(500),
            'icon_base_url' => $this->string(1024),
            'icon_path' => $this->string(1024),
            'icon_type' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%projects_type_lang}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'language' => $this->string()->notNull(),
            'name' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%projects}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer(),
            'active' => $this->boolean()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(500),
            'site_url' => $this->string(),
            'tools' => $this->text()
        ], $tableOptions);

        $this->createTable('{{%projects_lang}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull(),
            'title' => $this->text(),
            'description' => $this->text(),
            'case_url' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%projects_files}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'type' => $this->string(),
            'image_base_url' => $this->string(1024),
            'image_path' => $this->string(1024),
            'image_type' => $this->string()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%projects_type}}');
        $this->dropTable('{{%projects_type_lang}}');
        $this->dropTable('{{%projects}}');
        $this->dropTable('{{%projects_lang}}');
        $this->dropTable('{{%projects_files}}');
    }
}
