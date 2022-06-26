<?php

namespace App\Models;

use App\Core\Router\Request;

/**
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Models
 */
class Subscriptor extends Model
{
    const STATUS_ONLINE = "ONLINE";
    const STATUS_DELETED = "DELETED";

    public $_table = "subscriptors";

    /**
     * 
     * @var intenger
     */
    protected $id;
    /**
     * 
     * @var string
     */
    protected $created_at;
    /**
     * 
     * @var string
     */
    protected $email;
    /**
     * 
     * @var string
     */
    protected $status;
    /**
     * 
     * @var string
     */
    protected $deleted_at;
    /**
     * 
     * @var intenger
     */
    protected $total_collected_cumulated;

    /**
     * setId
     * @var intenger $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * getId
     * @return intenger $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * setCreatedAt
     * @var string $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    /**
     * getCreatedAt
     * @return string $created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    /**
     * setEmail
     * @var string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * getEmail
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * setStatus
     * @var string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    /**
     * getStatus
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * setDeletedAt
     * @var string $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }
    /**
     * getDeletedAt
     * @return string $deleted_at
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }
    /**
     * setTotalCollectedCumulated
     * @var float $total_collected_cumulated
     */
    public function setTotalCollectedCumulated($total_collected_cumulated)
    {
        $this->total_collected_cumulated = $total_collected_cumulated;
        return $this;
    }
    /**
     * getTotalCollectedCumulated
     * @return float $total_collected_cumulated
     */
    public function getTotalCollectedCumulated()
    {
        return $this->total_collected_cumulated;
    }


    /**
     * create new subscription
     * @param Request $request
     * return this
     */
    public function subscribe(Request $request)
    {
        $this->setId($request->get('subscriptor_id'));
        $this->setCreatedAt($request->get('created_at'));
        $this->setEmail($request->get('email'));
        $this->setStatus(Subscriptor::STATUS_ONLINE);
        $this->setTotalCollectedCumulated(0);
        $this->Save();
        return $this;
    }
    /**
     * down subscription
     * @param Request $request
     * return this
     */
    public function unsubscribe(Request $request)
    {
        $this->setDeletedAt($request->get('deleted_at'));
        $this->setStatus(Subscriptor::STATUS_DELETED);
        $this->Save();
        return $this;
    }
}
