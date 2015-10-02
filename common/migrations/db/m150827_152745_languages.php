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
            'locale' => $this->string(6)->notNull(),
            'active' => $this->boolean(),
            'default' => $this->boolean(),
            'sort' => $this->integer()->notNull()->defaultValue(500),
            'flag_base_url' => $this->string(1024),
            'flag_path' => $this->string(1024),
            'flag_type' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%languages_lang}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'language_id' => $this->integer()->notNull(),
            'language' => $this->string(5)->notNull()
        ], $tableOptions);

        $this->insert('{{%languages}}', [
            'id' => 1,
            'locale' => 'ru_RU',
            'active' => 1,
            'default' => 1,
            'sort' => 500
        ]);

        $this->insert('{{%languages_lang}}', [
            'name' => 'Русский',
            'language_id' => 1,
            'language' => 'ru_RU'
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%languages}}');
        $this->dropTable('{{%languages_lang}}');
        $this->delete('{{%languages}}', [
            'locale' => 'ru_RU'
        ]);
        $this->delete('{{%languages_lang}}', [
            'language_id' => 1
        ]);
    }
}
