<?php

namespace App\Models;

use App\Core\Libraries\Logguer\Logguer;
use App\Core\Libraries\Traits\ModelManipulation;

/**
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Models
 */
class Model extends \ADOdb_Active_Record
{
    use ModelManipulation;
    /**
     * 
     * @var string
     */
    public $_table = "";

    /**
     * get data from model
     */
    public function getFieldsData()
    {
        $obj = new \stdClass();
        foreach ($this->GetAttributeNames() as $key => $value) {
            $obj->$value = $this->$value;
        }
        return $obj;
    }

    /**
     * save data on DB
     * @return void 
     */
    public function saveDb()
    {
        $this->Save();
        Logguer::success("[{$this->_table}] created successfully with data: " . json_encode($this->getFieldsData()));
    }
    /**
     * update data on DB
     */
    public function updateDb()
    {
        $this->Update();
        Logguer::success("[{$this->_table}] updated successfully with data: " . json_encode($this->getFieldsData()));
    }
}
