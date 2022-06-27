<?php

namespace App\Models;

use App\Core\Router\Request;
use App\Http\Response;
use Exception;

/**
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Models
 */
class Collection extends Model
{
    const RESULT_OK = "OK";
    const RESULT_KO = "KO";

    public $_table = "collections";

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
    protected $result;
    /**
     * 
     * @var intenger
     */
    protected $amount;

    /**
     * 
     * @var intenger
     */
    protected $subscriptor_id;

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
     * setResult
     * @var string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }
    /**
     * getResult
     * @return string $result
     */
    public function getResult()
    {
        return $this->result;
    }
    /**
     * setAmount
     * @var float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
    /**
     * getAmount
     * @return float $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }
    /**
     * setSubscriptorId
     * @var intenger $subscriptor_id
     */
    public function setSubscriptorId($subscriptor_id)
    {
        $this->subscriptor_id = $subscriptor_id;
        return $this;
    }
    /**
     * getSubscriptorId
     * @return intenger $subscriptor_id
     */
    public function getSubscriptorId()
    {
        return $this->subscriptor_id;
    }

    /**
     * 
     * @return Subscriptor | null
     */
    public function getSubscriptor()
    {
        $subscriptor = new Subscriptor();
        if ($subscriptor->Load("id = " . $this->subscriptor_id)) {
            return $subscriptor;
        }
        return null;
    }

    /**
     * Handler the payment logic
     * @param Request $request 
     * @return $this 
     * @throws Exception 
     */
    public function payment(Request $request)
    {

        $this->setId($request->get('collection_id'));
        $this->setResult($request->get('result'));
        $this->setAmount($request->get('amount'));
        $this->setSubscriptorId($request->get('subscriptor_id'));
        $this->setCreatedAt($request->get('created_at'));
        $subscriptor = $this->getSubscriptor();
        if (!$subscriptor) {
            throw new \Exception("Subscriptor not exist", Response::HTTP_CONFLICT);
        }
        $this->saveDb();

        // updating the total collected cumulated for the subscriptor
        if ($this->getResult() == self::RESULT_OK) {
            $subscriptor->recalculateColletedAcumulated();
        }
        return $this;
    }
}
