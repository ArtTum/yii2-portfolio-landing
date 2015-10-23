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
 * @property string $icon_base_url
 * @property string $icon_path
 * @property string $icon_type
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
            [['active', 'sort'], 'integer'],
            [['icon_base_url', 'icon_path'], 'string', 'max' => 1024],
            [['icon_type'], 'string', 'max' => 255]
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
            'sort' => Yii::t('backend', 'Sort'),
            'icon_base_url' => Yii::t('backend', 'Icon Base Url'),
            'icon_path' => Yii::t('backend', 'Icon Path'),
            'icon_type' => Yii::t('backend', 'Icon Type'),
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
     * Delete translated params.
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            ProjectsTypeLang::deleteAll(['type_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

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
