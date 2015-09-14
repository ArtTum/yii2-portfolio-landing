<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "widget_menu_item_lang".
 *
 * @property integer $id
 * @property integer $widget_menu_item_id
 * @property string $language
 * @property string $name
 * @property string $url
 */
class WidgetMenuItemLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_menu_item_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_menu_item_id', 'language'], 'required'],
            [['widget_menu_item_id'], 'integer'],
            [['language'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 1024],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'widget_menu_item_id' => 'Widget Menu Item ID',
            'language' => 'Language',
            'name' => 'Name',
            'url' => 'Url',
        ];
    }
}
