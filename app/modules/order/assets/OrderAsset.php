<?php

namespace order\assets;

use yii\web\AssetBundle;

/**
 * add assets
 */
class OrderAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/order/web';
    public $css = [
        'css/bootstrap.min.css',
        'css/custom.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
    ];
}
