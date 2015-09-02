<?php

namespace OriginalAppName\Controller;

/**
 * uniform method for responding to an ajax call, all things must be json
 * will this work?
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Ajax extends \OriginalAppName\Controller
{


    public $status;


    const STATUS_SUCCESS = 'success';


    const STATUS_FAIL = 'fail';


    const STATUS_ERROR = 'error';


    public function __construct()
    {
        parent::__construct();
        $this->status = $this::STATUS_ERROR;
    }


    /**
     * passed back to pass to the route and use as the response
     * new standard for all ajax calls
     * @param   $data
     * @return object
     */
    public function getResponse($data)
    {
        $response = [
            'status' => $this->status
        ];

        // needed?
        if ($this->status == $this::STATUS_ERROR) {
            $response['message'] = $data;
        } else {
            $response['data'] = $data;
        }
        return new \OriginalAppName\Response(json_encode($response));
    }
}
