<?php

namespace OriginalAppName;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
interface DatabaseInterface
{


    /**
     * connects to the database
     * @return bool success
     */
    public function connect();


    /**
     * get id last inserted into the db
     * @return int
     */
    public function getLastInsertId();
}
