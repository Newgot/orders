<?php

namespace app\modules\order;
class Module extends \yii\base\Module
{
    public function init() {
        parent::init();
        $this->layout = 'main';
    }
}