<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use common\validators\JsonValidator;
use Yii;

/**
 * This is the model class for table "widget_menu".
 *
 * @property integer $id
 * @property string $key
 * @property string $title
 * @property integer $status
 */
class WidgetMenu extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_menu}}';
    }

    public function behaviors()
    {
        return [
            'cacheInvalidate' => [
                'class' => CacheInvalidateBehavior::className(),
                'keys' => [
                    function ($model) {
                        return [
                            get_class($model),
                            $model->key
                        ];
                    }
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'title'], 'required'],
            [['key'], 'unique'],
            [['status'], 'integer'],
            [['key'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(WidgetMenuItem::className(), ['menu_id' => 'id'])->orderBy("sort");
    }

    /**
     * @param array $items
     * @return bool
     * @TODO: Update only modified items
     */
    public function setItems($items = array())
    {
        if (empty($items)) {
            return true;
        }

        $_dbItemsIds = $_formItemsIds = array();
        //Get all current menu items from database
        $_dbItemsData = WidgetMenuItem::find()->where(['menu_id' => $this->id])->all();
        foreach ($_dbItemsData as $_dbItem) {
            $_dbItemsIds[] = $_dbItem->id;
            $_dbItems[$_dbItem->id] = $_dbItem;
        }
        foreach ($items['items'] as $item) {
            //Create new item
            if (empty($item['id'])) {
                $_newItem = new WidgetMenuItem();
                $_newItem->menu_id = $this->id;
                $_newItem->setAttributes($item, false);
                $_newItem->save();
                $item['id'] = $_newItem->id;
                $_dbItems[$item['id']] = $_newItem;
            }
            //Update item
            //$_wmItem = WidgetMenuItem::find()->where(['id' => $item['id']])->one();
            $_dbItems[$item['id']]->updateAttributes($item);
            $_dbItems[$item['id']]->save();
            $_formItemsIds[] = $item['id'];
        }
        //Check elements for deleting
        $_deleteItems = array_diff($_dbItemsIds, $_formItemsIds);
        if (sizeof($_deleteItems) > 0) {
            WidgetMenuItem::deleteAll(['id' => $_deleteItems]);
        }
        return true;
    }

    /**
     * Delete items.
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            //Bad performance, but it's the only method to active triggers and delete lang params
            foreach (WidgetMenuItem::find()->where(['menu_id' => $this->id])->all() as $item) {
                $item->delete();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'key' => Yii::t('common', 'Key'),
            'title' => Yii::t('common', 'Title'),
            'status' => Yii::t('common', 'Status')
        ];
    }

    public static function getMenuLinks($key, $additionalLinks)
    {
        if (!($model = WidgetMenu::findOne(['key' => $key, 'status' => WidgetMenu::STATUS_ACTIVE]))) {
            throw new InvalidConfigException;
        }

        $links = array();
        foreach ($model->items as $item) {
            if (WidgetMenuItem::STATUS_ACTIVE == $item->active && !empty($item->name) && $item->url) {
                $links[] = ['label' => $item->name, 'url' => [$item->url]];
            }
        }

        if (!empty($additionalLinks) && is_array($additionalLinks)) {
            $links = array_merge($links, $additionalLinks);
        }

        return $links;
    }
}
