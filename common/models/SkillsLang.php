<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skills_lang".
 *
 * @property integer $id
 * @property integer $skill_id
 * @property string $language
 * @property string $title
 * @property string $description
 */
class SkillsLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skills_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['skill_id', 'language'], 'required'],
            [['skill_id'], 'integer'],
            [['title', 'description'], 'string'],
            [['language'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'skill_id' => Yii::t('backend', 'Skill ID'),
            'language' => Yii::t('backend', 'Language'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
        ];
    }
}
