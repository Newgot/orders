<?php

namespace app\modules\order\models;

use order\helpers\OrderUrlHelper;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use order\models\User;
use order\models\Order;
/**
 * Order search model
 */
class OrderSearch extends Model
{
    public ?string $name = null;
    public ?int $quantity = null;
    public ?string $mode = null;
    public ?int $status = null;
    public ?int $service_id = null;
    public ?string $search = null;

    public  int $search_type;

    protected array $queryParams = [];



    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['mode', 'validateMode'],
            ['status', 'validateStatus'],
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
            return Order::scopeAll();
        }
        if (!empty($params['search_type']) && !empty($params['search'])) {
            $searchType = $params['search_type'];
            $search = trim($params['search']);
            if ($searchType === Order::SEARCH_NAME) {
                return Order::scopeAll()->andWhere(
                    'CONCAT(' . User::TABLE . '.first_name, " ", ' . User::TABLE . '.last_name) LIKE "%' . $search . '%"'
                );
            } elseif ($searchType === Order::SEARCH_ID) {
                return Order::scopeAll()->andWhere(['LIKE', Order::TABLE . '.id', $search]);
            } elseif ($searchType === Order::SEARCH_LINK) {
                return Order::scopeAll()->andWhere(['LIKE', Order::TABLE . '.link', $search]);
            }
        }
        return Order::scopeAll()->filterWhere(OrderUrlHelper::getRulesFilter(Order::FILTER_NAMES));
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
     * @param $attribute
     * @return void
     */
    public function  validateMode($attribute)
    {
        if (!in_array($this->$attribute, array_keys(Order::MODES))) {
            $this->addError($attribute, Yii::t('order', 'Not valid mode'));
        }
    }

    /**
     * @param $attribute
     * @return void
     */
    public function  validateStatus($attribute)
    {
        if (!in_array($this->$attribute, array_keys(Order::STATUSES))) {
            $this->addError($attribute, Yii::t('order', 'Not valid status'));
        }
    }
}