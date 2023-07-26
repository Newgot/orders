<?php

namespace order;
use Yii;
use yii\i18n\PhpMessageSource;

/**
 * initial order module
 */
class Module extends \yii\base\Module
{
    const TITLE = 'Order';

    public function init(): void
    {
        parent::init();
        $this->layout = 'main';
    }
}