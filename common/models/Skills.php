<?php

namespace common\models;

use common\models\SkillsLang;
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
            [['active'], 'required'],
            [['active', 'sort', 'mark'], 'integer'],
            [['type'], 'string', 'max' => 100],
            [['icon_name'], 'string', 'max' => 1024]
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
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
}
