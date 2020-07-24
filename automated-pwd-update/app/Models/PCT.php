<?php

namespace App\Models;


use App\Traits\Guzzle;
use Psr\Http\Message\ResponseInterface;
use App\Guzzle\Cookie\CookieJar;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

class PCT{

    use Guzzle;

    protected $cookie_jar;

    private $login_url='https://clients.pacificcoasttitle.com/Login.aspx?officeid=1';

    private $change_password_url='https://clients.pacificcoasttitle.com/ChangePassword.aspx';
    
    //public $user_name='cmorales@broadwayescrow.net'; //User Not Approved

    public $user_name='jeannette.abarca@bankerdirectescrow.com'; //Users company is disabled

    // public $user_name='harold@smartchoicerealtyinc.com'; //Working User    

    public $password='Pacific1';

    public $new_password='Pacific1';    

    // public $password='OE35cnIm';

    // public $new_password='OE35cnIm';
    
    

    public function change_password(Request $request)
    { 

        if($request->has('user_name'))
        {
            $this->user_name=$request->get('user_name');
        }

        if($request->has('password'))
        {
            $this->password=$request->get('password');
        }

        if($request->has('new_password'))
        {
            $this->new_password=$request->get('new_password');
        }        
        

        if(is_null($this->cookie_jar))
        {
            return $this->login();
        }    


        
        

    }

    public function login()
    {
        $url=$this->login_url;

        $method='GET';
        
        $options=[];

        $options['on_headers'] = function (ResponseInterface $response) {
            $this->cookie_jar= $response->getHeader('Set-Cookie');            
            throw new \Exception('');            
        };

        $options['allow_redirects']=[
            'max' => 1 ,
            'track_redirects' => true,
        ];

        //First Send request to get cookies

        $this->sendSyncRequest($method,$url,$options);

        unset($options['on_headers']);

        // $options['on_headers'] = function (ResponseInterface $response) {
        //     //dd($response);
        // };
     

        $domain='clients.pacificcoasttitle.com';

        $this->cookie_jar=[
            "__RWLOGIN__/__" => ''
        ];          
             

        $cookie_jar = CookieJar::fromArray($this->cookie_jar, $domain);

        $options['cookies']=$cookie_jar;

        $login_page=$this->sendSyncRequest($method,$url,$options);

        $this->cookie_jar=[];

        $login_page_cookies=$login_page['headers']['Set-Cookie'];        

        foreach($login_page_cookies as $cookie)
        {
            $cookie_array=explode(';',$cookie);

            $cookie_data=$cookie_array[0];

            $cookie_data=explode('=',$cookie_data);

            $this->cookie_jar[$cookie_data[0]]=$cookie_data[1];

            
        }

        libxml_use_internal_errors(true);

        $login_from_page_dom = new \DomDocument;

        $login_from_page_dom->loadHTML($login_page['data']);

        $login_from_page_dom_xpath = new \DomXPath($login_from_page_dom);        

        $view_state = $login_from_page_dom_xpath->query('//*[@id="__VIEWSTATE"]');

        foreach ($view_state as $i => $node) {
            $view_state=$node->getAttribute('value');            
        }

        $view_state_generator = $login_from_page_dom_xpath->query('//*[@id="__VIEWSTATEGENERATOR"]');

        foreach ($view_state_generator as $i => $node) {
            $view_state_generator=$node->getAttribute('value');            
        }

        $hidden_field = $login_from_page_dom_xpath->query('//*[@id="ctl00_ScriptManager1_HiddenField"]');

        foreach ($hidden_field as $i => $node) {
            $hidden_field=$node->getAttribute('value');            
        }       
        
        $anti_forgery_token=$login_from_page_dom_xpath->query('//*[@id="hiddenAntiforgeryToken"]');

        foreach ($anti_forgery_token as $i => $node) {
            $anti_forgery_token=$node->getAttribute('value');            
        }       
               
               
        $cookie_jar = CookieJar::fromArray($this->cookie_jar, $domain);

        $options['cookies']=$cookie_jar;

        $form_params=[];

        // $form_params['ctl00$ContentPlaceHolder1$tbUsername'] = 'jeff';
        // $form_params['ctl00$ContentPlaceHolder1$tbPassword'] = 'jeff';
        $form_params['ctl00_ScriptManager1_HiddenField']= $hidden_field;
        $form_params['__EVENTTARGET']= '';
        $form_params['__EVENTARGUMENT']= '';
        $form_params['__LASTFOCUS']= '';
        $form_params['__VIEWSTATE']= $view_state;
        $form_params['__VIEWSTATEGENERATOR']= $view_state_generator;
        $form_params['__VIEWSTATEENCRYPTED'] = '';
        $form_params['ctl00$hiddenAntiforgeryToken'] =$anti_forgery_token; 
        $form_params['ctl00$ContentPlaceHolder1$tbUsername']= $this->user_name;
        $form_params['ctl00$ContentPlaceHolder1$tbPassword']= $this->password;
        $form_params['ctl00$ContentPlaceHolder1$Button1']=  'Go -->';

        $options['form_params']=$form_params;

        $method='POST';

        $login_attempt=$this->sendSyncRequest($method,$url,$options);

        if(empty($login_attempt['effective_url']))
        {

            $login_attempt_dom = new \DomDocument;

            $login_attempt_dom->loadHTML($login_attempt['data']);

            $login_attempt_xpath = new \DomXPath($login_attempt_dom);   

            $message = $login_attempt_xpath->query('//*[@id="ctl00_ContentPlaceHolder1_lMessage"]');
        
            foreach ($message as $i => $node) {
                $message=$node->nodeValue;            
            }

            $response=[];

            $response['message']=$message;

            return response()->json($response);

        }

        dd($login_attempt);

        $method='GET';

        unset($options['form_params']);   

        $url=$this->change_password_url;
        
        $change_password_page=$this->sendSyncRequest($method,$url,$options);

        $change_password_page_dom = new \DomDocument;

        $change_password_page_dom->loadHTML($change_password_page['data']);

        $change_password_page_xpath = new \DomXPath($change_password_page_dom);        

        $view_state = $change_password_page_xpath->query('//*[@id="__VIEWSTATE"]');

        foreach ($view_state as $i => $node) {
            $view_state=$node->getAttribute('value');            
        }

        $view_state_generator = $change_password_page_xpath->query('//*[@id="__VIEWSTATEGENERATOR"]');

        foreach ($view_state_generator as $i => $node) {
            $view_state_generator=$node->getAttribute('value');            
        }

        $hidden_field = $change_password_page_xpath->query('//*[@id="ctl00_ScriptManager1_HiddenField"]');

        foreach ($hidden_field as $i => $node) {
            $hidden_field=$node->getAttribute('value');            
        }       
        
        $anti_forgery_token=$change_password_page_xpath->query('//*[@id="hiddenAntiforgeryToken"]');

        foreach ($anti_forgery_token as $i => $node) {
            $anti_forgery_token=$node->getAttribute('value');            
        }
        
        $guid=$change_password_page_xpath->query('//*[@id="ctl00_ContentPlaceHolder1_hGUID"]');

        foreach ($guid as $i => $node) {
            $guid=$node->getAttribute('value');            
        }

        //$view_state='/wEPDwUJNzcxMTMzNzgyD2QWAmYPZBYCAgMPZBYCAgIPZBYEAgIPZBYCZg8WAh4HVmlzaWJsZWgWAgIBDxAPFgYeDURhdGFUZXh0RmllbGQFBE5hbWUeDkRhdGFWYWx1ZUZpZWxkBQhPZmZpY2VJRB4LXyFEYXRhQm91bmRnZBAVARtQYWNpZmljIENvYXN0IFRpdGxlIENvbXBhbnkVAQExFCsDAWcWAWZkAgMPZBYCAgEPZBYCAgEPDxYCHgRUZXh0BX5QYXNzd29yZHMgbXVzdCBiZSBhdCBsZWFzdCA2IGNoYXJhY3RlcnMgYW5kIG11c3QgaW5jbHVkZSBhdCBsZWFzdCBvbmUgdXBwZXIgY2FzZSBsZXR0ZXIsIG9uZSBsb3dlciBjYXNlIGxldHRlciBhbmQgb25lIG51bWJlci5kZGTVbs2dof74fp5XveDQ1zzwL5HMEEhT4P2VOzD41l55fQ==';
        //var_dump(strlen($view_state));
        
        $form_params=[];

        // $form_params['ctl00$ContentPlaceHolder1$tbUsername'] = 'jeff';
        // $form_params['ctl00$ContentPlaceHolder1$tbPassword'] = 'jeff';
        $form_params['ctl00_ScriptManager1_HiddenField']= $hidden_field;
        $form_params['__EVENTTARGET']= '';
        $form_params['__EVENTARGUMENT']= '';
        //$form_params['__LASTFOCUS']= '';
        $form_params['__VIEWSTATE']= $view_state;
        $form_params['__VIEWSTATEGENERATOR']= $view_state_generator;
        //$form_params['__VIEWSTATEENCRYPTED'] = '';
        $form_params['ctl00$hiddenAntiforgeryToken'] =$anti_forgery_token; 
        $form_params['ctl00$ContentPlaceHolder1$tbCurrentPassword']= $this->password;
        $form_params['ctl00$ContentPlaceHolder1$tbPassword']= $this->new_password;
        $form_params['ctl00$ContentPlaceHolder1$tbPasswordConfirm']= $this->new_password;
        $form_params['ctl00$ContentPlaceHolder1$bSubmitPassword']=  'Submit Password';
        $form_params['ctl00$ContentPlaceHolder1$hGUID']=$guid;        

        $options['form_params']=$form_params;        

        //dd($options);

        $method='POST';

        $change_password_attempt=$this->sendSyncRequest($method,$url,$options);
        
        //dd($change_password_attempt);

        //return $change_password_attempt['data'];


        $change_password_attempt_dom = new \DomDocument;

        $change_password_attempt_dom->loadHTML($change_password_attempt['data']);

        $change_password_attempt_xpath = new \DomXPath($change_password_attempt_dom);        

        $message = $change_password_attempt_xpath->query('//*[@id="ctl00_ContentPlaceHolder1_lMessage"]');
        
        foreach ($message as $i => $node) {
            $message=$node->nodeValue;            
        }

        $response=[];

        $response['message']=$message;

        return response()->json($response);

        // dump($view_state,$view_state_generator,$hidden_field);
        // dd("aa");

    }

}