<?php

namespace order\helpers;

use Yii;

/**
 * helper to generate url in order module
 */
class OrderUrlHelper
{
    /**
     * set param to route array
     * @param string $route
     * @param array $newParams
     * @return array
     */
    public static function set(string $route, array $newParams): array
    {
        $oldParams = Yii::$app->request->queryParams;
        return array_merge([$route], $oldParams, $newParams);
    }

    /**
     * unset param to route array
     * @param string $route
     * @param array $paramNames
     * @return array
     */
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

    /**
     * @return void
     */
    public static function setCSVHeader(): void
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="exported_(' . date('H-i_d.m.Y') . ').csv"');
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

    /**
     * get all filter rules from the order in the queryParam
     * @param $filters
     * @return array
     */
    public static function getRulesFilter($filters): array
    {
        $rules = [];
        foreach (Yii::$app->request->queryParams as $keyParam => $param) {
            if (in_array($keyParam, $filters)) {
                $rules[$keyParam] = $param;
            }
        }
        return $rules;
    }
}