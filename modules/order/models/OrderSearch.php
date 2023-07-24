<?php

namespace app\modules\order\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * Order search model
 */
class OrderSearch extends Order
{

    /**
     * search for get params
     * @return ActiveQuery
     */
    public static function search(): ActiveQuery
    {
        $params = Yii::$app->request->queryParams;
        if (!empty($params['search-type']) && !empty($params['search'])) {
            $searchType = $params['search-type'];
            $search = trim($params['search']);
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
        return self::scopeAll()->filterWhere(Order::rulesFilter());
    }

}