<?php

namespace OriginalAppName;

/**
 * 200 - OK - Returns data or status string
 * 400 - Bad request - Server didn't recognise the request
 * 401 - Not authorised - API token missing or did not authenticate
 * 500 - Server Error - Message attached will provide details
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Response
{


    /**
     * @var string
     */
    public $content;


    /**
     * @var int
     */
    public $statusCode;


    /**
     * build response object when in controller
     * @param string  $content
     * @param integer $statusCode
     */
    public function __construct($content, $statusCode = 200)
    {
        $this->setContent($content);
        $this->setStatusCode($statusCode);
    }


    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    
    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    
    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}
