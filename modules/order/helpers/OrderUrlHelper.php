<?php

namespace app\modules\order\helpers;

use Yii;

class OrderUrlHelper
{
    public static function set(string $route, array $newParams): array
    {
        $oldParams = Yii::$app->request->queryParams;
        return array_merge([$route], $oldParams, $newParams);
    }

    public static function unset(string $route, array $paramNames): array
    {
        $params = Yii::$app->request->queryParams;
        $res[0] = $route;
        foreach ($params as $key => $param) {
            if (!in_array($key, $paramNames)) {
                $res[$key] = $param;
            }
        }
        return $res;
    }
}