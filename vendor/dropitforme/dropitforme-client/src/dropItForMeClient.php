<?php
/**
 * DropItForMe API Client Library for PHP
 *
 * @copyright 2017, Brian Tafoya.
 * @package   Ajax Class
 * @author    Brian Tafoya <btafoya@briantafoya.com>
 * @version   1.0.0
 * @license   MIT
 * @license   https://opensource.org/licenses/MIT The MIT License
 * @category  Web Application
 * @uses      https://packagist.org/packages/guzzlehttp/guzzle Guzzle is a PHP HTTP client library
 *
 * Copyright (c) 2017, Brian Tafoya
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Class dropItForMeClient
 */
class dropItForMeClient {


    /**
     * @var string API Key provided by https://dropitforme.com
     */
	public $api_key;


    /**
     * @var string API Endpoint
     */
	private $base_url = "https://dropitforme.com/";

    /**
     * dropItForMeClient constructor.
     *
     * @param $api_key
     */
	public function __construct($api_key) {
		$this->api_key = $api_key;
	}//end __construct()


    /**
     * validateEmail() Email address validation method
     *
     * @param $email
     *
     * @return array
     */
	public function validateEmail($email) {
		return $this->doRequest($this->base_url . "api/v1/validateEmail/json", array("api_key"=>$this->api_key,"email"=>$email));
	}//end validateEmail()


    /**
     * sendMessage() Send email method
     *
     * @param        $email_to
     * @param        $email_to_name
     * @param        $email_subject
     * @param        $email_body
     * @param        $email_body_type
     * @param        $email_from
     * @param        $email_from_name
     * @param string $attachment_path
     * @param string $attachment_base64
     * @param string $attachment_name
     * @param string $callback_url
     *
     * @return array
     */
	public function sendMessage($email_to, $email_to_name, $email_subject, $email_body, $email_body_type, $email_from, $email_from_name, $attachment_path = "", $attachment_base64 = "", $attachment_name = "", $callback_url = "") {

	    // process the attachment data
        if(!$attachment_base64) {
            if($attachment_path && file_exists($attachment_path)) {
                $attachment_base64 = base64_encode(file_get_contents($attachment_path));
            }
        }

        // perform the request
		return $this->doRequest($this->base_url . "api/v1/sendMessage/json", array(
			"api_key"=>$this->api_key,
			"email_to"=>$email_to,
			"email_to_name"=>$email_to_name,
			"email_subject"=>$email_subject,
			"email_body"=>$email_body,
			"email_body_type"=>$email_body_type,
			"email_from"=>$email_from,
            "email_from_name"=>$email_from_name,
			"callback_url"=>$callback_url,
            "attachment_base64"=>$attachment_base64,
            "attachment_name"=>$attachment_name
		));
	}//end sendMessage()


    /**
     * isHamEmail() Report a valid email address
     *
     * @param $email
     *
     * @return array
     */
	public function isHamEmail($email) {
		return $this->doRequest($this->base_url . "api/v1/isHamEmail/json", array("api_key"=>$this->api_key,"email"=>$email));
	}//end isHamEmail()


    /**
     * isSpamEmail() Report an ivalid email address
     *
     * @param $email
     *
     * @return array
     */
	public function isSpamEmail($email) {
		return $this->doRequest($this->base_url . "api/v1/isSpamEmail/json", array("api_key"=>$this->api_key,"email"=>$email));
	}//end isSpamEmail()


    /**
     * doRequest() Client API http method
     *
     * @param            $url
     * @param array|null $post
     *
     * @return array
     */
	private function doRequest($url, array $post = NULL) {

	    $client = new \GuzzleHttp\Client();
        $jar = new \GuzzleHttp\Cookie\CookieJar();
        $res = $client->request('POST', (string)$url, [
            'http_errors' => false,
            'verify' => false,
            'allow_redirects' => false,
            'form_params' => $post,
            'timeout' => 120,
            'connect_timeout' => 30,
            'cookies' => $jar
        ]);

        if($res->getStatusCode() == 200) {
            return array("statusCode"=>$res->getStatusCode(),"response"=>json_decode($res->getBody()));
        } else {
            return array("statusCode"=>$res->getStatusCode(),"response"=>$res->getReasonPhrase());
        }
	}//end doRequest()
}
