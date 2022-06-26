<?php

namespace App\Http\Controllers;

use App\Core\Libraries\Exceptions\TelecomException;
use App\Core\Libraries\Validator;
use App\Http\Response;
use App\Models\Collection;
use App\Models\Subscriptor;

/**
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Http\Controllers
 */
class NotificationsController extends BaseController
{
    /**
     * handle high notification
     * @return void 
     */
    public function high()
    {
        try {
            $rules = [
                'subscriptor_id' => 'required|numeric',
                'created_at' => 'required|date',
                'email' => 'required|email',
            ];
            $validator = Validator::make($this->request->all(), $rules);
            if ($validator->fails()) {
                throw new TelecomException($validator->errors(), Response::HTTP_BAD_REQUEST);
            }


            $subscriptor = new Subscriptor();
            $result = $subscriptor->Load(sprintf("id = %d", $this->request->get('subscriptor_id')));
            if ($result) {
                throw new \Exception("The record has exist !!!", Response::HTTP_CONFLICT);
            }
            $subscriptor->subscribe($this->request);

            Response::json([
                "status" => "success",
                "message" => ["the subscriptor has been created"],
            ]);
        } catch (TelecomException $e) {
            Response::json(["errors" => $e->getMessageAsArray()], $e->getCode());
        } catch (\Exception $e) {
            Response::json(["error" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * handle down notification
     * @return void 
     */
    public function down()
    {
        try {
            $rules = [
                'deleted_at' => 'required|date',
                'subscriptor_id' => 'required|numeric',
            ];
            $validator = Validator::make($this->request->all(), $rules);
            if ($validator->fails()) {
                throw new TelecomException($validator->errors(), Response::HTTP_BAD_REQUEST);
            }


            $subscriptor = new Subscriptor();
            $result = $subscriptor->Load(sprintf("id = %d", $this->request->get('subscriptor_id')));
            if (!$result) {
                throw new \Exception("The record not exist !!!", Response::HTTP_CONFLICT);
            }
            $subscriptor->unsubscribe($this->request);

            Response::json([
                "status" => "success",
                "message" => ["the subscriptor has been down"],
            ]);
        } catch (TelecomException $e) {
            Response::json(["errors" => $e->getMessageAsArray()], $e->getCode());
        } catch (\Exception $e) {
            Response::json(["error" => $e->getMessage()], $e->getCode());
        }
    }
    /**
     * handle payment notification
     * @return void 
     */
    public function payment()
    {
        try {
            $rules = [
                'collection_id' => 'required|numeric',
                'subscriptor_id' => 'required|numeric',
                'created_at' => 'required|date',
                'result' => 'required|enum:OK,KO',
                'amount' => 'required|numeric',
            ];
            $validator = Validator::make($this->request->all(), $rules);
            if ($validator->fails()) {
                throw new TelecomException($validator->errors(), Response::HTTP_BAD_REQUEST);
            }


            $collection = new Collection();
            $result = $collection->Load(sprintf("id = %d", $this->request->get('collection_id')));
            if ($result) {
                throw new \Exception("The record has exist !!!", Response::HTTP_CONFLICT);
            }
            $collection->payment($this->request);

            Response::json([
                "status" => "success",
                "message" => ["the subscriptor has been down"],
            ]);
        } catch (TelecomException $e) {
            Response::json(["errors" => $e->getMessageAsArray()], $e->getCode());
        } catch (\Exception $e) {
            Response::json(["error" => $e->getMessage()], $e->getCode());
        }
    }
}
