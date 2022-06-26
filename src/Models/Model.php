<?php

namespace App\Models;

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
}
