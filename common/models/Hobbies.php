<?php

namespace common\models;

use Yii;
use dosamigos\translateable\TranslateableBehavior;

/**
 * This is the model class for table "hobbies".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $sort
 * @property string $icon_base_url
 * @property string $icon_path
 * @property string $icon_type
 */
class Hobbies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hobbies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'name'], 'required'],
            [['active', 'sort'], 'integer'],
            [['icon_name'], 'string', 'max' => 50],
            [['description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Name'),
            'description' => Yii::t('backend', 'Description'),
            'active' => Yii::t('backend', 'Active'),
            'sort' => Yii::t('backend', 'Sort'),
            'icon_name' => Yii::t('backend', 'Icon name'),
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
                    'description'
                ]
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(HobbiesLang::className(), ['hobby_id' => 'id']);
    }

    /**
     * Delete translated params.
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            HobbiesLang::deleteAll(['hobby_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Init function
     * @defaultParam sort = 500
     */
    public function init()
    {
        if (empty($this->sort))
            $this->sort = 500;
        parent::init();
    }
}
