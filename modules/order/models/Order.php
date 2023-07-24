<?php

namespace app\modules\order\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Order model
 */
class Order extends ActiveRecord
{
    public const TABLE = 'orders';
    public const FILTER_NAMES = ['service_id', 'mode', 'status'];
    public const SEARCH_ID = '1';
    public const SEARCH_LINK = '2';
    public const SEARCH_NAME = '3';
    public const SEARCHES = [
        self::SEARCH_ID => 'Order Id',
        self::SEARCH_LINK => 'Link',
        self::SEARCH_NAME => 'Username',
    ];
    public const SERVICES_ALL = '';
    public const MODE_ALL = '';
    public const MODES = [
        '0' => 'Manual',
        '1' => 'Auto'
    ];
    public const STATUSES = [
        '' => 'All orders',
        '0' => 'Pending',
        '1' => 'In progress',
        '2' => 'Completed',
        '3' => 'Canceled',
        '4' => 'Fail',
    ];

    public static function tableName(): string
    {
        return '{{' . self::TABLE . '}}';
    }

    public function getName(): string
    {
        $firstName = !empty($this->user->first_name) ? $this->user->first_name : '';
        $lastName = !empty($this->user->last_name) ? $this->user->last_name : '';
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

    /**
     * generate sql from orders table jons users and services table
     * @return ActiveQuery
     */
    public static function scopeAll(): ActiveQuery
    {
        return self::scopeOrdersQuery()
            ->joinWith(['user' => function ($query) {
                $query->from(User::TABLE);
            }])
            ->joinWith(['service' => function ($query) {
                $query->from(Service::TABLE);
            }]);
    }

    /**
     * generate sql from orders table
     * @return ActiveQuery
     */
    protected static function scopeOrdersQuery(): ActiveQuery
    {
        return Order::find()
            ->select([
                Order::TABLE . '.*',
                User::TABLE . '.first_name',
                User::TABLE . '.last_name',
                Service::TABLE . '.name',
            ]);
    }
}
