<?php

namespace common\models;

use backend\assets\BackendAsset;
use Codeception\Module\Yii2;
use Yii;
use dosamigos\translateable\TranslateableBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $locale
 * @property integer $active
 * @property integer $default
 * @property integer $sort
 * @property string $flag_base_url
 * @property string $flag_path
 * @property string $flag_type
 * @TODO Set default for first element if no one find and beforeDelete.
 * @TODO Create module and update this entity by composer//JS from app.js, css from here
 * @TODO Add lang params
 * @TODO Fork upload-kit and write image resize with gd (Flag, 16x11). Add image output options. Delete domain name in base url.
 */
class Languages extends \yii\db\ActiveRecord
{

    /**
     * @var array available system languages
     */
    protected static $languages = array();

    /**
     * @var array available system languages
     */
    protected static $languagesFlags = array();

    /**
     * @var string Default lang code
     */
    protected static $languagesDefault;

    /**
     * @var string Active lang
     */
    protected static $active;

    /**
     * @var array|null
     */
    public $flag;

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
     * Delete translated params.
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            LanguagesLang::deleteAll(['language_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->default == 1)
            Languages::updateAll(['default' => 0], 'id!=' . $this->id);
        Yii::$app->cache->delete('languages');
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(LanguagesLang::className(), ['language_id' => 'id']);
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'flag',
                'pathAttribute' => 'flag_path',
                'baseUrlAttribute' => 'flag_base_url',
                'typeAttribute' => 'flag_type'
            ],
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
    public static function tableName()
    {
        return '{{%languages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['locale', 'name'], 'required'],
            [['active', 'sort', 'default'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['locale'], 'string', 'max' => 6],
            [['flag_base_url', 'flag_path'], 'string', 'max' => 1024],
            [['flag_type'], 'string', 'max' => 255],
            ['flag', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common_languages', 'ID'),
            'name' => Yii::t('common_languages', 'Name'),
            'locale' => Yii::t('common_languages', 'Locale'),
            'flag' => Yii::t('common_languages', 'Flag'),
            'active' => Yii::t('common_languages', 'Active'),
            'default' => Yii::t('common_languages', 'Default language'),
            'sort' => Yii::t('common_languages', 'Sort'),
            'flag_base_url' => Yii::t('common_languages', 'Flag Base Url'),
            'flag_path' => Yii::t('common_languages', 'Flag Path'),
            'flag_type' => Yii::t('common_languages', 'Flag Type'),
        ];
    }

    /**
     * @param null $model
     * @return string
     */
    public function getFlagUrl($model = null)
    {
        if (empty($model))
            $model = $this;
        return !empty($model->flag_path) ? rtrim($model->flag_base_url, '/') . '/' . ltrim($model->flag_path, '/') : 'http://placehold.it/16x11';
    }


    /**
     * Return current flag for dynamic fields
     * @param $flagPic
     * @return string
     */
    private function getLangFieldFlagStyle($flagPic)
    {
        $flagClass = [
            'background-image' => "url(" . $flagPic . ")",
            'background-repeat' => 'no-repeat',
            'background-position' => '99% 10px',
            'background-size' => '16px 11px'
        ];
        return "<style> .mlang{" . Html::cssStyleFromArray($flagClass) . "}</style>";
    }

    /**
     * Load available languages.
     * @return array of language data
     * @TODO: Shouldn't get the current language
     */
    public static function getLanguages()
    {
        $key = 'languages';
        $data = Yii::$app->cache->get($key);
        if ($data === false) {
            $model = Languages::find()
                ->indexBy('id')
                ->orderBy('sort')
                ->all();
            foreach ($model as $lang) {
                if ($lang->active && !empty($lang->name)) {
                    $data['languages'][$lang->locale] = $lang->name;
                    $data['flags'][$lang->locale] = self::getFlagUrl($lang);
                }
                if ($lang->default)
                    $data['default'] = $lang->locale;
            }
            Yii::$app->cache->set($key, $data, 0);
        }
        self::$languages = $data['languages'] ? $data['languages'] : array();
        self::$languagesFlags = $data['flags'];
        self::$languagesDefault = $data['default'];
        return self::$languages;
    }

    /**
     * Return default locale
     * @return int
     */
    public static function getDefault()
    {
        self::getLanguages();
        return self::$languagesDefault;
    }

    /**
     * @return array with ids and names
     * @TODO: Styles to module file
     */
    public static function showSelectButtons()
    {
        self::getLanguages();
        $items = array();
        foreach (self::$languages as $lang_locale => $lang_name) {
            if ($lang_locale == Yii::$app->language) {
                $currentLangLabel = $lang_name;
                $currentLangFlag = self::$languagesFlags[$lang_locale];
                $_flagCssClass = self::getLangFieldFlagStyle($currentLangFlag);
            } else {
                $fullLangLabel = $lang_name;
                $items[] = [
                    'label' => $fullLangLabel,
                    'url' => Url::current(['lang_locale' => $lang_locale]),
                    'linkOptions' => ['style' => 'background: url(' . self::$languagesFlags[$lang_locale] . ') 2% 7px no-repeat rgb(255, 255, 255);padding-left: 26px;']
                ];
            }
        }
        $dropdown = (sizeof(self::$languages) < 1) ? 'disabled' : false;
        return $_flagCssClass . ButtonDropdown::widget([
            'label' => $currentLangLabel,
            'options' => [
                'style' => 'background-image: url(' . $currentLangFlag . '); background-repeat: no-repeat; background-position: 14px 9px; background-size: 16px 11px; padding-left: 26px;',
                'disabled' => $dropdown
            ],
            'dropdown' => [
                'items' => $items,
            ],
        ]);
    }

    /**
     * Function for select of system locale
     * @param currentLocale
     * @return array
     * @TODO Get actual locale list from somewhere ¯\_(ツ)_/¯
     */
    public static function getLocales($currentLocale = null)
    {
        return array_diff_key(array(
            'aa_DJ' => 'Afar (Djibouti)',
            'aa_ER' => 'Afar (Eritrea)',
            'aa_ET' => 'Afar (Ethiopia)',
            'af_ZA' => 'Afrikaans (South Africa)',
            'sq_AL' => 'Albanian (Albania)',
            'sq_MK' => 'Albanian (Macedonia)',
            'am_ET' => 'Amharic (Ethiopia)',
            'ar_DZ' => 'Arabic (Algeria)',
            'ar_BH' => 'Arabic (Bahrain)',
            'ar_EG' => 'Arabic (Egypt)',
            'ar_IN' => 'Arabic (India)',
            'ar_IQ' => 'Arabic (Iraq)',
            'ar_JO' => 'Arabic (Jordan)',
            'ar_KW' => 'Arabic (Kuwait)',
            'ar_LB' => 'Arabic (Lebanon)',
            'ar_LY' => 'Arabic (Libya)',
            'ar_MA' => 'Arabic (Morocco)',
            'ar_OM' => 'Arabic (Oman)',
            'ar_QA' => 'Arabic (Qatar)',
            'ar_SA' => 'Arabic (Saudi Arabia)',
            'ar_SD' => 'Arabic (Sudan)',
            'ar_SY' => 'Arabic (Syria)',
            'ar_TN' => 'Arabic (Tunisia)',
            'ar_AE' => 'Arabic (United Arab Emirates)',
            'ar_YE' => 'Arabic (Yemen)',
            'an_ES' => 'Aragonese (Spain)',
            'hy_AM' => 'Armenian (Armenia)',
            'as_IN' => 'Assamese (India)',
            'ast_ES' => 'Asturian (Spain)',
            'az_AZ' => 'Azerbaijani (Azerbaijan)',
            'az_TR' => 'Azerbaijani (Turkey)',
            'eu_FR' => 'Basque (France)',
            'eu_ES' => 'Basque (Spain)',
            'be_BY' => 'Belarusian (Belarus)',
            'bem_ZM' => 'Bemba (Zambia)',
            'bn_BD' => 'Bengali (Bangladesh)',
            'bn_IN' => 'Bengali (India)',
            'ber_DZ' => 'Berber (Algeria)',
            'ber_MA' => 'Berber (Morocco)',
            'byn_ER' => 'Blin (Eritrea)',
            'bs_BA' => 'Bosnian (Bosnia and Herzegovina)',
            'br_FR' => 'Breton (France)',
            'bg_BG' => 'Bulgarian (Bulgaria)',
            'my_MM' => 'Burmese (Myanmar [Burma])',
            'ca_AD' => 'Catalan (Andorra)',
            'ca_FR' => 'Catalan (France)',
            'ca_IT' => 'Catalan (Italy)',
            'ca_ES' => 'Catalan (Spain)',
            'zh_CN' => 'Chinese (China)',
            'zh_HK' => 'Chinese (Hong Kong SAR China)',
            'zh_SG' => 'Chinese (Singapore)',
            'zh_TW' => 'Chinese (Taiwan)',
            'cv_RU' => 'Chuvash (Russia)',
            'kw_GB' => 'Cornish (United Kingdom)',
            'crh_UA' => 'Crimean Turkish (Ukraine)',
            'hr_HR' => 'Croatian (Croatia)',
            'cs_CZ' => 'Czech (Czech Republic)',
            'da_DK' => 'Danish (Denmark)',
            'dv_MV' => 'Divehi (Maldives)',
            'nl_AW' => 'Dutch (Aruba)',
            'nl_BE' => 'Dutch (Belgium)',
            'nl_NL' => 'Dutch (Netherlands)',
            'dz_BT' => 'Dzongkha (Bhutan)',
            'en_AG' => 'English (Antigua and Barbuda)',
            'en_AU' => 'English (Australia)',
            'en_BW' => 'English (Botswana)',
            'en_CA' => 'English (Canada)',
            'en_DK' => 'English (Denmark)',
            'en_HK' => 'English (Hong Kong SAR China)',
            'en_IN' => 'English (India)',
            'en_IE' => 'English (Ireland)',
            'en_NZ' => 'English (New Zealand)',
            'en_NG' => 'English (Nigeria)',
            'en_PH' => 'English (Philippines)',
            'en_SG' => 'English (Singapore)',
            'en_ZA' => 'English (South Africa)',
            'en_GB' => 'English (United Kingdom)',
            'en_US' => 'English (United States)',
            'en_ZM' => 'English (Zambia)',
            'en_ZW' => 'English (Zimbabwe)',
            'eo' => 'Esperanto',
            'et_EE' => 'Estonian (Estonia)',
            'fo_FO' => 'Faroese (Faroe Islands)',
            'fil_PH' => 'Filipino (Philippines)',
            'fi_FI' => 'Finnish (Finland)',
            'fr_BE' => 'French (Belgium)',
            'fr_CA' => 'French (Canada)',
            'fr_FR' => 'French (France)',
            'fr_LU' => 'French (Luxembourg)',
            'fr_CH' => 'French (Switzerland)',
            'fur_IT' => 'Friulian (Italy)',
            'ff_SN' => 'Fulah (Senegal)',
            'gl_ES' => 'Galician (Spain)',
            'lg_UG' => 'Ganda (Uganda)',
            'gez_ER' => 'Geez (Eritrea)',
            'gez_ET' => 'Geez (Ethiopia)',
            'ka_GE' => 'Georgian (Georgia)',
            'de_AT' => 'German (Austria)',
            'de_BE' => 'German (Belgium)',
            'de_DE' => 'German (Germany)',
            'de_LI' => 'German (Liechtenstein)',
            'de_LU' => 'German (Luxembourg)',
            'de_CH' => 'German (Switzerland)',
            'el_CY' => 'Greek (Cyprus)',
            'el_GR' => 'Greek (Greece)',
            'gu_IN' => 'Gujarati (India)',
            'ht_HT' => 'Haitian (Haiti)',
            'ha_NG' => 'Hausa (Nigeria)',
            'iw_IL' => 'Hebrew (Israel)',
            'he_IL' => 'Hebrew (Israel)',
            'hi_IN' => 'Hindi (India)',
            'hu_HU' => 'Hungarian (Hungary)',
            'is_IS' => 'Icelandic (Iceland)',
            'ig_NG' => 'Igbo (Nigeria)',
            'id_ID' => 'Indonesian (Indonesia)',
            'ia' => 'Interlingua',
            'iu_CA' => 'Inuktitut (Canada)',
            'ik_CA' => 'Inupiaq (Canada)',
            'ga_IE' => 'Irish (Ireland)',
            'it_IT' => 'Italian (Italy)',
            'it_CH' => 'Italian (Switzerland)',
            'ja_JP' => 'Japanese (Japan)',
            'kl_GL' => 'Kalaallisut (Greenland)',
            'kn_IN' => 'Kannada (India)',
            'ks_IN' => 'Kashmiri (India)',
            'csb_PL' => 'Kashubian (Poland)',
            'kk_KZ' => 'Kazakh (Kazakhstan)',
            'km_KH' => 'Khmer (Cambodia)',
            'rw_RW' => 'Kinyarwanda (Rwanda)',
            'ky_KG' => 'Kirghiz (Kyrgyzstan)',
            'kok_IN' => 'Konkani (India)',
            'ko_KR' => 'Korean (South Korea)',
            'ku_TR' => 'Kurdish (Turkey)',
            'lo_LA' => 'Lao (Laos)',
            'lv_LV' => 'Latvian (Latvia)',
            'li_BE' => 'Limburgish (Belgium)',
            'li_NL' => 'Limburgish (Netherlands)',
            'lt_LT' => 'Lithuanian (Lithuania)',
            'nds_DE' => 'Low German (Germany)',
            'nds_NL' => 'Low German (Netherlands)',
            'mk_MK' => 'Macedonian (Macedonia)',
            'mai_IN' => 'Maithili (India)',
            'mg_MG' => 'Malagasy (Madagascar)',
            'ms_MY' => 'Malay (Malaysia)',
            'ml_IN' => 'Malayalam (India)',
            'mt_MT' => 'Maltese (Malta)',
            'gv_GB' => 'Manx (United Kingdom)',
            'mi_NZ' => 'Maori (New Zealand)',
            'mr_IN' => 'Marathi (India)',
            'mn_MN' => 'Mongolian (Mongolia)',
            'ne_NP' => 'Nepali (Nepal)',
            'se_NO' => 'Northern Sami (Norway)',
            'nso_ZA' => 'Northern Sotho (South Africa)',
            'nb_NO' => 'Norwegian Bokmål (Norway)',
            'nn_NO' => 'Norwegian Nynorsk (Norway)',
            'oc_FR' => 'Occitan (France)',
            'or_IN' => 'Oriya (India)',
            'om_ET' => 'Oromo (Ethiopia)',
            'om_KE' => 'Oromo (Kenya)',
            'os_RU' => 'Ossetic (Russia)',
            'pap_AN' => 'Papiamento (Netherlands Antilles)',
            'ps_AF' => 'Pashto (Afghanistan)',
            'fa_IR' => 'Persian (Iran)',
            'pl_PL' => 'Polish (Poland)',
            'pt_BR' => 'Portuguese (Brazil)',
            'pt_PT' => 'Portuguese (Portugal)',
            'pa_IN' => 'Punjabi (India)',
            'pa_PK' => 'Punjabi (Pakistan)',
            'ro_RO' => 'Romanian (Romania)',
            'ru_RU' => 'Russian (Russia)',
            'ru_UA' => 'Russian (Ukraine)',
            'sa_IN' => 'Sanskrit (India)',
            'sc_IT' => 'Sardinian (Italy)',
            'gd_GB' => 'Scottish Gaelic (United Kingdom)',
            'sr_ME' => 'Serbian (Montenegro)',
            'sr_RS' => 'Serbian (Serbia)',
            'sid_ET' => 'Sidamo (Ethiopia)',
            'sd_IN' => 'Sindhi (India)',
            'si_LK' => 'Sinhala (Sri Lanka)',
            'sk_SK' => 'Slovak (Slovakia)',
            'sl_SI' => 'Slovenian (Slovenia)',
            'so_DJ' => 'Somali (Djibouti)',
            'so_ET' => 'Somali (Ethiopia)',
            'so_KE' => 'Somali (Kenya)',
            'so_SO' => 'Somali (Somalia)',
            'nr_ZA' => 'South Ndebele (South Africa)',
            'st_ZA' => 'Southern Sotho (South Africa)',
            'es_AR' => 'Spanish (Argentina)',
            'es_BO' => 'Spanish (Bolivia)',
            'es_CL' => 'Spanish (Chile)',
            'es_CO' => 'Spanish (Colombia)',
            'es_CR' => 'Spanish (Costa Rica)',
            'es_DO' => 'Spanish (Dominican Republic)',
            'es_EC' => 'Spanish (Ecuador)',
            'es_SV' => 'Spanish (El Salvador)',
            'es_GT' => 'Spanish (Guatemala)',
            'es_HN' => 'Spanish (Honduras)',
            'es_MX' => 'Spanish (Mexico)',
            'es_NI' => 'Spanish (Nicaragua)',
            'es_PA' => 'Spanish (Panama)',
            'es_PY' => 'Spanish (Paraguay)',
            'es_PE' => 'Spanish (Peru)',
            'es_ES' => 'Spanish (Spain)',
            'es_US' => 'Spanish (United States)',
            'es_UY' => 'Spanish (Uruguay)',
            'es_VE' => 'Spanish (Venezuela)',
            'sw_KE' => 'Swahili (Kenya)',
            'sw_TZ' => 'Swahili (Tanzania)',
            'ss_ZA' => 'Swati (South Africa)',
            'sv_FI' => 'Swedish (Finland)',
            'sv_SE' => 'Swedish (Sweden)',
            'tl_PH' => 'Tagalog (Philippines)',
            'tg_TJ' => 'Tajik (Tajikistan)',
            'ta_IN' => 'Tamil (India)',
            'tt_RU' => 'Tatar (Russia)',
            'te_IN' => 'Telugu (India)',
            'th_TH' => 'Thai (Thailand)',
            'bo_CN' => 'Tibetan (China)',
            'bo_IN' => 'Tibetan (India)',
            'tig_ER' => 'Tigre (Eritrea)',
            'ti_ER' => 'Tigrinya (Eritrea)',
            'ti_ET' => 'Tigrinya (Ethiopia)',
            'ts_ZA' => 'Tsonga (South Africa)',
            'tn_ZA' => 'Tswana (South Africa)',
            'tr_CY' => 'Turkish (Cyprus)',
            'tr_TR' => 'Turkish (Turkey)',
            'tk_TM' => 'Turkmen (Turkmenistan)',
            'ug_CN' => 'Uighur (China)',
            'uk_UA' => 'Ukrainian (Ukraine)',
            'hsb_DE' => 'Upper Sorbian (Germany)',
            'ur_PK' => 'Urdu (Pakistan)',
            'uz_UZ' => 'Uzbek (Uzbekistan)',
            've_ZA' => 'Venda (South Africa)',
            'vi_VN' => 'Vietnamese (Vietnam)',
            'wa_BE' => 'Walloon (Belgium)',
            'cy_GB' => 'Welsh (United Kingdom)',
            'fy_DE' => 'Western Frisian (Germany)',
            'fy_NL' => 'Western Frisian (Netherlands)',
            'wo_SN' => 'Wolof (Senegal)',
            'xh_ZA' => 'Xhosa (South Africa)',
            'yi_US' => 'Yiddish (United States)',
            'yo_NG' => 'Yoruba (Nigeria)',
            'zu_ZA' => 'Zulu (South Africa)'
        ), array_diff_key(self::getLanguages(), [$currentLocale => true]));
    }
}
