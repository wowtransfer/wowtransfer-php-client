<?php

class FrontEndController extends BaseController
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * Return menu data
     *
     * @return array
     */
    public function getMainMenuItems()
    {
        $menu = [];

        $menu[] = [
            'label' => Yii::t('app', 'Site'),
            'url' => Config::getInstance()->getSiteUrl(),
            'icon' => 'home',
            'visible' => Config::getInstance()->getSiteUrl() != '/',
        ];
        if (!Yii::app()->user->isGuest) {
            $menu[] = [
                'label' => Yii::t('app', 'Requests'), 'url' => ['/transfers'],
                'icon' => 'list', 'active' => $this->id == 'transfers',
            ];
        }
        $menu[] = ['label' => Yii::t('app', 'Help'), 'url' => ['/site/page'], 'icon' => 'info-sign'];

        return $menu;
    }

    public function getRightMenuItems()
    {
        $lang = Yii::app()->user->lang;
        $items = [
            [
                'label' => 'A',
                'url' => Yii::app()->request->baseUrl . '/admin.php/transfers/index',
                'visible' => Yii::app()->user->isAdmin(),
                'icon' => 'cog',
                'htmlOptions' => ['title' => Yii::t('app', 'Administration')],
                'linkOptions' => ['id' => 'to-backend'],
            ],
            [
                'label' => '<span class="spr flag-' . $lang . '"></span>',
                'items' => [
                    [
                        'url' => ['/site/lang', 'lang' => 'ru'],
                        'label' => '<span class="spr flag-ru"></span>',
                        'active' => $lang === 'ru',
                    ],
                    [
                        'url' => ['/site/lang', 'lang' => 'en'],
                        'label' => '<span class="spr flag-en"></span>',
                        'active' => $lang === 'en',
                    ],
                ]
            ],
            [
                'label' => Yii::app()->user->name,
                'visible' => !Yii::app()->user->isGuest,
                'items' => [
                    [
                        'url' => ['/site/logout'],
                        'label' => Yii::t('app', 'Logout'),
                        'icon' => 'log-out',
                    ],
                ]
            ],
            [
                'url' => ['/site/login'],
                'label' => Yii::t('app', 'Login'),
                'visible' => Yii::app()->user->isGuest && $this->route !== 'site/login',
                'icon' => 'log-in',
            ],
        ];

        return $items;
    }

    public function registerCssAndJs()
    {
        parent::registerCssAndJs();

        $cs = Yii::app()->clientScript;
        $baseUrl = Yii::app()->request->baseUrl;

        Yii::app()->bootstrap->register();

        if (YII_DEBUG) {
            $cssDir = '/css_dev';

            $cs->registerCssFile($baseUrl . $cssDir . '/common/main.css', 'screen, projection');
            $cs->registerCssFile($baseUrl . $cssDir . '/common/print.css', 'print');
            $cs->registerCssFile($baseUrl . $cssDir . '/common/form.css');
            $cs->registerCssFile($baseUrl . $cssDir . '/common/common.css');
            $cs->registerCssFile($baseUrl . $cssDir . '/common/icons.css');
            $cs->registerCssFile($baseUrl . $cssDir . '/common/sprite_main.css');

            $cs->registerCssFile($baseUrl . $cssDir . '/frontend/frontend.css');

            $cs->registerScriptFile($baseUrl . '/js_dev/common.js', CClientScript::POS_END);
            $cs->registerScriptFile($baseUrl . '/js_dev/frontend/main.js', CClientScript::POS_END);
        } else {
            $cs->registerCssFile($baseUrl . '/css/frontend.css');

            $cs->registerScriptFile($baseUrl . '/js/frontend.min.js', CClientScript::POS_END);
        }
    }

}
