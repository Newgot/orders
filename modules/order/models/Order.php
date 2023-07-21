<?php

namespace app\modules\order\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public const TABLE = 'orders';
    public const FILTER_NAMES = ['service_id', 'mode', 'status'];
    protected const SEARCH_NAME = 'name';
    protected const SEARCH_ID = 'id';
    protected const SEARCH_LINK = 'link';
    protected const STATUSES = [
        '0' => 'Pending',
        '1' => 'In progress',
        '2' => 'Completed',
        '3' => 'Canceled',
        '4' => 'Fail',
    ];
    protected const MODES = [
        '0' => 'Manual',
        '1' => 'Auto'
    ];

    public static function tableName(): string
    {
        return '{{' . self::TABLE . '}}';
    }

    public function getName(): string
    {
        $firstName = !empty($this->first_name) ? $this->first_name : '';
        $lastName = !empty($this->last_name) ? $this->last_name : '';
        return "$firstName $lastName";
    }

    public function getStatusName(): string
    {
        return array_key_exists($this->status, self::STATUSES)
            ? self::STATUSES[$this->status]
            : '';
    }

    public function getModeName(): string
    {
        return array_key_exists($this->mode, self::MODES)
            ? self::MODES[$this->mode]
            : '';
    }

    public function getCreatedDate(): array
    {
        $date = date('Y-m-d H:i:s', $this->created_at);
        return explode(' ', $date);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * get all filter rules from the order in the queryParam
     * @return array
     */
    public static function rulesFilter(): array
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

    /**
     * get rule value if exist
     * @param string $key
     * @return string
     */
    public static function ruleFilter(string $key): string
    {
        $params = Yii::$app->request->queryParams;
        return array_key_exists($key, $params) && in_array($key, self::FILTER_NAMES)
            ? $params[$key]
            : '';
    }

    public static function search(ActiveQuery $query): ActiveQuery
    {
        $params = Yii::$app->request->queryParams;
        foreach ($params as $keyParam => $param) {
            if ($keyParam === self::SEARCH_NAME) {
                $query->where(
                    'CONCAT(' . User::TABLE . '.first_name, " ", ' . User::TABLE . '.last_name) LIKE "%' . $param . '%"'
                );
            } elseif ($keyParam === self::SEARCH_ID) {
                $query->where(['LIKE', Order::TABLE . '.id', $param]);
            } elseif ($keyParam === self::SEARCH_LINK) {
                $query->where(['LIKE', Order::TABLE . '.link', $param]);
            }
        }
        return $query;
    }
}
