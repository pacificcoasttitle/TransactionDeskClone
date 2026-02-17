<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
// require_once APPPATH . 'libraries/phrets/vendor/autoload.php';


use PHRETS\Configuration;
use PHRETS\Session;

class Rets
{
    private $rets;
    public function __construct()
    {
        $this->CI =& get_instance();  
        // $this->CI->load->library('PHRETS_Loader');
        // $config = new \PHRETS\Configuration;
        // $config->setLoginUrl('https://pt.rets.crmls.org/contact/rets/login')
        //     ->setUsername('OSCEND')
        //     ->setPassword('SIMPLYRETS')
        //     ->setRetsVersion('1.7.2');
        
        // $rets = new \PHRETS\Session($config);
        // $connect = $rets->Login();
        // echo APPPATH . 'third_party/phrets/vendor/autoload.php';die;
        // require_once(APPPATH . 'third_party/phrets/vendor/autoload.php');

        // $config = new Configuration;
        // $config->setLoginUrl('https://pt.rets.crmls.org/contact/rets/login')
        //        ->setUsername('OSCEND')
        //        ->setPassword('SIMPLYRETS')
        //        ->setRetsVersion('1.8');
               
        // $this->rets = new Session($config);
        
        // $config = new Configuration;
        // $config->setLoginUrl('https://pt.rets.crmls.org/contact/rets/login')
        //     ->setUsername('info_456z6zv2')
        //     ->setPassword('lm0182gh3pu6f827')
        //     ->setRetsVersion('1.8');
        // $this->rets = new \PHRETS\Session($config);
        // $this->rets->Login();
        // try {
        //     // $connect = $this->rets->Login();
        //     echo "Login successful!";die;
        // } catch (Exception $e) {
        //     echo "Login failed: " . $e->getMessage();die;
        // }
        
        // $this->rets = $connect;
        
    }

    public function callSimplyRets($endpoint = '', $body_params = '')
    {
        $login = $_ENV['RETS_API_USERNAME'];
        $password = $_ENV['RETS_API_PASSWORD'];
        
        // $req_endpoint = $_ENV['RETS_API_ENDPOINT'] . 'agents';
        $req_endpoint = $_ENV['RETS_API_ENDPOINT'] . 'properties';
        // $endpoint = "?q=CA&q=". urlencode('LA VERNE')."&status=sold";
        $endpoint = $req_endpoint . $endpoint;
        print_r($endpoint);
        echo "<br>";
        // die;
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($body_params)
            )
        );

        $result = curl_exec($ch);
        if ($result === false) {
            return json_encode(['error' => 'Something went wrong', 'message' => curl_error($ch)]);
        }
        return $result;
    }

    public function callSimplyRetsAgent($endpoint = '', $body_params = '')
    {
        $login = $_ENV['RETS_API_USERNAME'];
        $password = $_ENV['RETS_API_PASSWORD'];
        // $password = $_ENV['RETS_AGENT_API_PASSWORD'];
        
        $req_endpoint = $_ENV['RETS_API_ENDPOINT'] . 'agents';
        $req_endpoint = $_ENV['RETS_API_ENDPOINT'] . 'agents';
        // $endpoint = "?q=CA&q=". urlencode('LA VERNE')."&status=sold";
        $endpoint = $req_endpoint . $endpoint;
        print_r($endpoint);
        echo "<br>";
        // die;
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $body_params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($body_params)
            )
        );

        $result = curl_exec($ch);
        if ($result === false) {
            return json_encode(['error' => 'Something went wrong', 'message' => curl_error($ch)]);
        }
        return $result;
    }
}
