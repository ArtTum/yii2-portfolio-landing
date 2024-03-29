<?php

namespace common\models;

use Yii;
use dosamigos\translateable\TranslateableBehavior;

/**
 * This is the model class for table "skills".
 *
 * @property integer $id
 * @property string $type
 * @property integer $active
 * @property integer $sort
 * @property string $icon_name
 * @property integer $mark
 */
class Skills extends \yii\db\ActiveRecord
{

    public static $TYPES = [
        "Block",
        "Mark",
        "Description"
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skills';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'title'], 'required'],
            [['active', 'sort', 'mark'], 'integer'],
            [['type'], 'string', 'max' => 100],
            [['icon_name'], 'string', 'max' => 1024],
            [['description'], 'string', 'max' => 1500]
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
                    'title',
                    'description'
                ]
            ]
        ];
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'title' => Yii::t('backend', 'Name'),
            'description' => Yii::t('backend', 'Description'),
            'type' => Yii::t('backend', 'Type'),
            'active' => Yii::t('backend', 'Active'),
            'sort' => Yii::t('backend', 'Sort'),
            'icon_name' => Yii::t('backend', 'Icon Name'),
            'mark' => Yii::t('backend', 'Mark'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(SkillsLang::className(), ['skill_id' => 'id']);
    }

    /**
     * Delete translated params.
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            SkillsLang::deleteAll(['skill_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }
}
