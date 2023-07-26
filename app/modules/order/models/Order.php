<?php

namespace app\modules\order\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Order model
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string $quantity
 * @property string $serviceOrder
 * @property string $statusName
 * @property string $modeName,
 * @property array $createdDate
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
        '0' => 'Pending',
        '1' => 'In progress',
        '2' => 'Completed',
        '3' => 'Canceled',
        '4' => 'Fail',
    ];

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{' . self::TABLE . '}}';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $firstName = !empty($this->user->first_name) ? $this->user->first_name : '';
        $lastName = !empty($this->user->last_name) ? $this->user->last_name : '';
        return "$firstName $lastName";
    }

    /**
     * @return string
     */
    public function getStatusName(): string
    {
        return array_key_exists($this->status, self::STATUSES)
            ? self::STATUSES[$this->status]
            : '';
    }

    /**
     * @return string
     */
    public function getModeName(): string
    {
        return array_key_exists($this->mode, self::MODES)
            ? self::MODES[$this->mode]
            : '';
    }

    /**
     * @return array
     */
    public function getCreatedDate(): array
    {
        $date = date('Y-m-d H:i:s', $this->created_at);
        return explode(' ', $date);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getServiceOrder(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
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
            ->joinWith(['serviceOrder' => function ($query) {
                $query->from(Service::TABLE);
            }]);
    }

    /**
     * generate sql from orders table
     * @return ActiveQuery
     */
    protected static function scopeOrdersQuery(): ActiveQuery
    {
        return self::find()
            ->select([
                Order::TABLE . '.*',
                User::TABLE . '.first_name',
                User::TABLE . '.last_name',
                Service::TABLE . '.name',
            ]);
    }
}
