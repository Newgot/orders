<?php

namespace app\modules\order\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * Order search model
 */
class OrderSearch extends Order
{
    public $search;
    public $search_type;
    public const FILTER_NAMES = ['service_id', 'mode', 'status'];
    public function rules(): array
    {
        return [
            ['mode', 'integer', 'max' => 1],
            ['status', 'integer', 'max' => 4],
            ['service_id', 'integer'],
            ['search', 'required', 'when' => fn($model) => !empty($model->search_type)],
            ['search_type', 'required', 'when' => fn($model) => !empty($model->search)],
        ];
    }

    /**
     * search for get params
     * @return ActiveQuery
     */
    public static function search(): ActiveQuery
    {
        $model = (new self);
        $model->load(Yii::$app->request->get(), '');
        if (!$model->validate()) {
            Yii::$app->params['error'] = $model->getErrors();
            return self::scopeAll();
        }
            $params = Yii::$app->request->queryParams;
        if (!empty($params['search_type']) && !empty($params['search'])) {
            $searchType = $params['search_type'];
            $search = ($params['search']);
            if ($searchType === self::SEARCH_NAME) {
                return self::scopeAll()->andWhere(
                    'CONCAT(' . User::TABLE . '.first_name, " ", ' . User::TABLE . '.last_name) LIKE "%' . $search . '%"'
                );
            } elseif ($searchType === self::SEARCH_ID) {
                return  self::scopeAll()->andWhere(['LIKE', Order::TABLE . '.id', $search]);
            } elseif ($searchType === self::SEARCH_LINK) {
                return  self::scopeAll()->andWhere(['LIKE', Order::TABLE . '.link', $search]);
            }
        }
        return self::scopeAll()->filterWhere(self::getRulesFilter());
    }


    /**
     * get all filter rules from the order in the queryParam
     * @return array
     */
    protected static function getRulesFilter(): array
    {
        $params = Yii::$app->request->queryParams;
        $rules = [];

        foreach ($params as $keyParam => $param) {
            if (in_array($keyParam, self::FILTER_NAMES)) {
                $rules[$keyParam] = $param;
            }
        }
        return $rules;
    }
}