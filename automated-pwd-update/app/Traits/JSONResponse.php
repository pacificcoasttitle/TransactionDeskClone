<?php

namespace App\Traits;

trait JSONResponse
{   
    /**
     * Default Status Code Set to 200 
     *
     * @var integer
     */
    public $status_code = 200;

    /**
     * Change Status Code to 
     *
     * @param integer $code
     * @return object
     */

    public function setHttpCode($code)
    {
        $this->status_code = $code;

        return $this;
    }

    /**
     * Send Error Response in JSOn
     *
     * @param string $msg
     * @return string
     */
    public function sendErrorJsonResponse($msg = '')
    {
        $data = [];

        $data['status'] = 'error';
        $data['message'] = $msg;

        return $this->sendJsonResponse($data);
    }

    /**
     * Send Success Response in JSOn
     *
     * @param string $msg
     * @return string
     */
    public function sendSuccessJsonResponse($msg = '')
    {
        $data = [];

        $data['status'] = 'success';
        $data['message'] = $msg;

        return $this->sendJsonResponse($data);
    }

    /**
     * Send JSON Response
     *
     * @param string $msg
     * @return string
     */
    public function sendJsonResponse($data)
    {
        return response()->json($data)->setStatusCode($this->status_code);
    }
}
