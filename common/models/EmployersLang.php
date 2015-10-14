<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employers_lang".
 *
 * @property integer $id
 * @property integer $employer_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property string $position
 * @property string $period
 */
class EmployersLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employers_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_id', 'language'], 'required'],
            [['employer_id'], 'integer'],
            [['title', 'description'], 'string'],
            [['language'], 'string', 'max' => 5],
            [['position', 'period'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'employer_id' => Yii::t('backend', 'Employer ID'),
            'language' => Yii::t('backend', 'Language'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
            'position' => Yii::t('backend', 'Position'),
            'period' => Yii::t('backend', 'Period'),
        ];
    }
}
