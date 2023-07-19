<?php

namespace app\modules\order\Facades;

class Filter
{
    protected const FILTER_NAMES = ['service_id', 'mode', 'status'];

    public static function rules(): array
    {
        $params = \Yii::$app->request->queryParams;
        $rules = [];
        foreach ($params as $keyParam => $param) {
            if (in_array($keyParam, self::FILTER_NAMES)) {
                $rules[$keyParam] = $param;
            }
        }
        return $rules;
    }

    public static function rule(string $key): string
    {
        $params = \Yii::$app->request->queryParams;
        return array_key_exists($key, $params) && in_array($key, self::FILTER_NAMES)
            ? $params[$key]
            : '';
    }
}