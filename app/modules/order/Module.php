<?php

namespace order;

/**
 * initial order module
 */
class Module extends \yii\base\Module
{
    const TITLE = 'Order';
    public $controllerNamespace = 'order\controllers';
    public function init(): void
    {
        parent::init();
        $this->layout = 'main';
    }
}