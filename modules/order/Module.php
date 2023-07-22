<?php

namespace app\modules\order;
use Yii;
use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module
{
    public function init() {
        parent::init();
        $this->layout = 'main';
        Yii::setAlias('@order', __DIR__);
        Yii::$app->i18n->translations['order'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'en-US',
            'basePath' => '@order/messages',
        ];
    }
}