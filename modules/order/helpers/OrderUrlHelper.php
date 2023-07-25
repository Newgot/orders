<?php

namespace app\modules\order\helpers;

use Yii;

/**
 * helper to generate url in order module
 */
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
                $res[$key] = trim($param);
            }
        }
        return $res;
    }

    public static function setCSVHeader(): void
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="exported_(' . date('H-i_d.m.Y') .').csv"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
    }

    /**
     * get rule value if exist
     * @param string $key
     * @param array $filters
     * @return string
     */
    public static function ruleFilter(string $key, array $filters): string
    {
        $params = Yii::$app->request->queryParams;
        return array_key_exists($key, $params) && in_array($key, $filters)
            ? $params[$key]
            : '';
    }
}