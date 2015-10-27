<?php

namespace common\models;

use Yii;
use dosamigos\translateable\TranslateableBehavior;

/**
 * This is the model class for table "projects_type".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $sort
 */
class ProjectsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active'], 'required'],
            [['active', 'sort'], 'integer']
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
                    'name'
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
            'active' => Yii::t('backend', 'Active'),
            'sort' => Yii::t('backend', 'Sort')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ProjectsTypeLang::className(), ['type_id' => 'id']);
    }


    /**
     * Labels dor dropdown
     * @return array
     */
    public static function getTypeLabels()
    {
        $labels = array();
        $types = ProjectsType::find()
                    ->orderBy("sort")
                    ->all();
        foreach($types as $type)
        {
            $labels[$type->id] = $type->name;
        }

        return $labels;
    }
}
