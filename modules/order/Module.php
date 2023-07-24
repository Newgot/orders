<?php

namespace app\modules\order;
use Yii;
use yii\i18n\PhpMessageSource;

/**
 * initial order module
 */
class Module extends \yii\base\Module
{
    const TITLE = 'Order';

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