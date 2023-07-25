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
    protected array $queryParams = [];

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
    public function search(): ActiveQuery
    {
        $params = $this->getQueryParams();
        $this->load($this->getQueryParams(), '');
        if (!$this->validate()) {
            return $this->scopeAll();
        }
        if (!empty($params['search_type']) && !empty($params['search'])) {
            $searchType = $params['search_type'];
            $search = ($params['search']);
            if ($searchType === self::SEARCH_NAME) {
                return $this->scopeAll()->andWhere(
                    'CONCAT(' . User::TABLE . '.first_name, " ", ' . User::TABLE . '.last_name) LIKE "%' . $search . '%"'
                );
            } elseif ($searchType === self::SEARCH_ID) {
                return  $this->scopeAll()->andWhere(['LIKE', Order::TABLE . '.id', $search]);
            } elseif ($searchType === self::SEARCH_LINK) {
                return  $this->scopeAll()->andWhere(['LIKE', Order::TABLE . '.link', $search]);
            }
        }
        return $this->scopeAll()->filterWhere($this->getRulesFilter());
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @param array $queryParams
     */
    public function setQueryParams(array $queryParams): void
    {
        $this->queryParams = $queryParams;
    }

    /**
     * get all filter rules from the order in the queryParam
     * @return array
     */
    protected function getRulesFilter(): array
    {
        $rules = [];
        foreach ($this->getQueryParams() as $keyParam => $param) {
            if (in_array($keyParam, self::FILTER_NAMES)) {
                $rules[$keyParam] = $param;
            }
        }
        return $rules;
    }
}