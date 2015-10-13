<?php

namespace common\models;

use Yii;
use dosamigos\translateable\TranslateableBehavior;


/**
 * This is the model class for table "widget_menu_item".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $active
 * @property integer $sort
 */
class WidgetMenuItem extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'active'], 'required'],
            [['menu_id', 'active', 'sort'], 'integer'],
            ['sort', 'default', 'value' => 500]
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'trans' => [
                'class' => TranslateableBehavior::className(),
                'translationAttributes' => [
                    'name',
                    'url'
                ]
            ]
        ];
    }

    /**
     * Delete translated params.
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            WidgetMenuItemLang::deleteAll(['widget_menu_item_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(WidgetMenuItemLang::className(), ['widget_menu_item_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common_widget_menu_item', 'ID'),
            'active' => Yii::t('common_widget_menu_item', 'Active'),
            'sort' => Yii::t('common_widget_menu_item', 'Sort'),
        ];
    }
}
