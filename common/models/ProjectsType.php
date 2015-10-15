<?php

namespace common\models;

use Yii;

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
}
