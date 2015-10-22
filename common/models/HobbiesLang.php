<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hobbies_lang".
 *
 * @property integer $id
 * @property integer $hobby_id
 * @property string $language
 * @property string $name
 * @property string $description
 */
class HobbiesLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hobbies_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hobby_id', 'language'], 'required'],
            [['hobby_id'], 'integer'],
            [['description'], 'string'],
            [['language', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'hobby_id' => Yii::t('backend', 'Hobby ID'),
            'language' => Yii::t('backend', 'Language'),
            'name' => Yii::t('backend', 'Name'),
            'description' => Yii::t('backend', 'Description'),
        ];
    }
}
