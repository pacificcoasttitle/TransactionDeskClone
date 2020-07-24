<?php

namespace App\Traits;
use Log;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Provides access to Nishat Hotel API with sync and async API Requests
 */
trait Guzzle
{

    /**
     * Laravel Request Object
     * @param Illuminate\Http\Request Request
     */
    public $request;

    /**
     * Set it to false to received array
     *
     * @var boolean
     */
    public $json_response = true;

    /**
     * Guzzle Connect Time out Confiugration
     * @var int
     */
    protected $connect_timeout = 10;

    /**
     * Guzzle Time out Confiugration
     * @var int
     */
    protected $timeout = 10;

    /**
     * Guzzle Api JSON Response Conversion
     * @var int
     */
    protected $api_response_json_decode = false;

    /**
     * Guzzle User agent
     * @var string
     */
    protected $user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36';

    /**
     * Consider Request Success full if status code matches
     *
     * @var array
     */
    protected $accepted_success_status_codes = [200, 201];

       /**
     * Send Sync HTTP Request to API Server
     *
     * @param  string HTTP Verb
     * @param  string Request URL
     * @param  array Guzzle Client Options
     * @return array Response array
     */

    protected function sendSyncRequest($action = 'GET', $url, $options = array())
    {
        $result = array();

        //Init Guzzle

        $guzzle = new GuzzleClient();

        //Setup default required option if not set

        if (!array_key_exists('exceptions', $options)) {
            $options['exceptions'] = false;
        }

        if (!array_key_exists('connect_timeout', $options)) {
            $options['connect_timeout'] = $this->connect_timeout;
        }

        if (!array_key_exists('timeout', $options)) {
            $options['timeout'] = $this->timeout;
        }

        if (array_key_exists('header', $options)) {
            if (!array_key_exists('User-Agent', $options['headers'])) {
                $options['headers']['User-Agent'] = $this->user_agent;
            }

        } else {        
            $options['headers']['User-Agent'] = $this->user_agent;
        }
       

        //Hide HTTP Errors

        $options['http_errors'] = false;
        
        

        try {
            //Send request

            $response = $guzzle->request($action, $url, $options);
        } catch (\Exception $e) {

            if(array_key_exists('cookies',$options))
            {
                dd($e);
            }
            //Assume Null Response by default
            $response=null;

            //if there is an exception generate error array with sufficient
            //information to debug

            if(method_exists($e,'getResponse'))
            {
                $response = $e->getResponse();
            }            

            //Check if we were even able to get a reponse
            if (!is_null($response)) {
                //Get reponse Headers
                $response_headers = $response->getHeaders();

                //Get Status Code i.e 401,500
                $response_code = $response->getStatusCode();
            } else {
                //if we were unable to get a response assume 500 error!
                $response_headers = array();

                $response_code = 500; //
            }

            $result['status'] = 'error';

            $result['code'] = $response_code;

            $result['headers'] = $response_headers;

            $result['data'] = array();

            $result['errors'] = $e;

            $result['effective_url'] = $response->getHeader(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER);
            
            return $result;
        }        

        //If no exception we get the data

        $response_headers = $response->getHeaders();

        //Status code from there side

        $response_code = $response->getStatusCode();

        //Response        

        $data = (string) $response->getBody();

        $result['code'] = $response_code;
        $result['headers'] = $response_headers;

        

        //Json Decode API Request
        if ($this->api_response_json_decode) {
            $result['data'] = json_decode($data, true);
        } else {
            $result['data'] = $data;
        }

        $result['effective_url'] = $response->getHeader(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER);

        
        return $result;

    }

    /**
     * Send async HTTP Request to API Server
     *
     * @param  string HTTP Verb
     * @param  string Request URL
     * @param  array Guzzle Client Options
     * @return array Response array
     */
    protected function sendAsyncRequest($action = 'GET', $url, $options = array())
    {
        $result = array();

        //Init Guzzle

        $guzzle = new GuzzleClient();

        //Setup default required option if not set

        if (!array_key_exists('exceptions', $options)) {
            $options['exceptions'] = false;
        }

        if (!array_key_exists('connect_timeout', $options)) {
            $options['connect_timeout'] = $this->connect_timeout;
        }

        if (!array_key_exists('timeout', $options)) {
            $options['timeout'] = $this->timeout;
        }

        if (array_key_exists('header', $options)) {
            if (!array_key_exists('User-Agent', $options['headers'])) {
                $options['headers']['User-Agent'] = $this->user_agent;
            }

        } else {
            
            $options['headers']['User-Agent'] = $this->user_agent;
        }

        //Hide HTTP Errors

        $options['http_errors'] = false;

        try {
            $promise = $guzzle->requestAsync($action, $url, $options);

            return $promise;
        } catch (\Exception $e) {

            $this->exception($e);
            //TODO

            /* Handle async request exception */

        }

    }
    /**
     * Resolve AsyncRequest Promise
     *
     * @param GuzzleHttp\Promise\PromiseInterface $promise
     * @return array
     */
    public function resolveAsynctRequest($promise)
    {
        $result = array();

        try {
            //Synchronously wait for the promise to complete
            $response = $promise->wait();

        } catch (\Exception $e) {

            

            $response = $e->getResponse();

            //Check if we were even able to get a reponse
            if (!is_null($response)) {
                //Get reponse Headers
                $response_headers = $response->getHeaders();

                //Get Status Code i.e 401,500
                $response_code = $response->getStatusCode();
            } else {
                //if we were unable to get a response assume 500 error!
                $response_headers = array();

                $response_code = 500; //
            }

            $result['status'] = 'error';

            $result['code'] = $response_code;

            $result['headers'] = $response_headers;

            $result['data'] = array();

            $result['errors'] = $e;



            return $result;

        }

        //If no exception we get the data

        $response_headers = $response->getHeaders();

        //Status code from there side

        $response_code = $response->getStatusCode();

        //Response

        $data = (string) $response->getBody();

        //Check successfull requests
        if (in_array((int) $response_code, $this->accepted_success_status_codes)) {
            $result['status'] = 'success';
        } else {
            $result['status'] = 'error';
        }

        $result['code'] = $response_code;
        $result['headers'] = $response_headers;

        //Json Decode API Request
        if ($this->api_response_json_decode) {
            $result['data'] = json_decode($data, true);
        } else {
            $result['data'] = $data;
        }

        return $result;
    }
}