<?php

namespace common\behaviors;

use Yii;
use yii\web\Application;
use yii\base\Behavior;
use common\models\Languages;

/**
 * Class LocaleBehavior
 * @package common\behaviors
 */
class LocaleBehavior extends Behavior
{
    /**
     * @var string
     */
    public $cookieName = '_locale';

    /**
     * @var bool
     */
    public $enablePreferredLanguage = true;

    /**
     * @return array
     */
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest'
        ];
    }

    /**
     * Resolve application language by checking user cookies, preferred language and profile settings
     */
    public function beforeRequest()
    {
        if (
            Yii::$app->getRequest()->getCookies()->has($this->cookieName)
            && !Yii::$app->session->hasFlash('forceUpdateLocale')
        ) {
            $userLocale = Yii::$app->getRequest()->getCookies()->getValue($this->cookieName);
        } else {
            $userLocale = Yii::$app->language;
            if (
                !Yii::$app->user->isGuest
                && Yii::$app->user->identity->userProfile->locale
                && array_key_exists(Yii::$app->user->identity->userProfile->locale, Languages::getLanguages())
            ) {
                $userLocale = Yii::$app->user->getIdentity()->userProfile->locale;
            } elseif ($this->enablePreferredLanguage) {
                $userLocale = Languages::getDefault();
            }
        }
        if (Yii::$app->getRequest()->get('lang_locale')) {
            $userLocale = Yii::$app->getRequest()->get('lang_locale');
        }
        Yii::$app->language = $userLocale;
    }
}
