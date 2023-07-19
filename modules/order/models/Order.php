<?php

namespace app\modules\order\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public const TABLE = 'orders';

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
}
