<?php
namespace SocialConnect\Service;

use SocialConnect\Config\FacebookConfig;
use Zend\Http\Client;
use Zend\Http\Request;
use ZendOAuth\Consumer;
use \Zend\Json\Json;

class TwitterService
//class TwitterService implements Provider
{
    /**
     * @var ZendService;
     */
    private $provider;

    /**
     * @var TwitterConfig;
     */
    private $config;

    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $consumerSecret;

    /**
     * @var array
     */
    private $returnUrlData = array();

    /**
     * @var bool
     */
    private $isValid = false;

    /**
     * @var array
     */
    private $getParams = array();

    /**
     * @var NormalizedData
     */
    private $data;

    /**
     * @param FacebookConfig $config
     */
    public function __construct(array $config, Request $request)
    {
        $this->getParams = $request->getQuery()->toArray();
        $error = $request->getQuery('error');

        if (!empty($error)) {
            $this->isValid = false;
            return;
        }

//        if (!$config->isEnabled())
//        {
//            throw new \Exception('Twitter is not enabled');
//        }

        $this->consumerKey = $config['consumer_key'];
        $this->consumerSecret= $config['consumer_secret'];
        $this->returnUrlData = $config['return_url'];
    }

    /**
     * @return array
     */
    public function getReturnUrlData()
    {
        return $this->returnUrlData;
    }

    /**
     * @param string $returnUrl
     *
     * @return string
     */
    public function getLoginUrl($returnUrl)
    {
        $config = array(
            'consumerKey'    => $this->consumerKey,
            'consumerSecret' => $this->consumerSecret,
            'callbackUrl'    => $returnUrl,
            'siteUrl'        => 'https://api.twitter.com/oauth',
            'authorizeUrl'   => 'https://api.twitter.com/oauth/authenticate',
        );

        $httpClientOptions = array(
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => array(
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ),
        );

        $consumer = new Consumer($config);
        $consumer->setHttpClient($consumer->getHttpClient()->setOptions($httpClientOptions));
        $token = $consumer->getRequestToken();

        $_SESSION['TWITTER_REQUEST_TOKEN'] = serialize($token);

        return $consumer->getRedirectUrl();
    }

    /**
     * @return bool|NormalizedData
     */
    public function getUserData()
    {
        if ($this->data) {
            return $this->data;
        }

        $config = array(
            'consumerKey'    => $this->consumerKey,
            'consumerSecret' => $this->consumerSecret,
            'siteUrl'        => 'https://api.twitter.com/oauth'
        );

        $httpClientOptions = array(
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => array(
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ),
        );

        $consumer = new Consumer($config);
        $consumer->setHttpClient($consumer->getHttpClient()->setOptions($httpClientOptions));

        if (!empty($this->getParams) && isset($_SESSION['TWITTER_REQUEST_TOKEN'])) {
            try {
                $token = $consumer->getAccessToken($this->getParams, unserialize($_SESSION['TWITTER_REQUEST_TOKEN']));
                unset($_SESSION['TWITTER_REQUEST_TOKEN']);

                $client = $token->getHttpClient($config, null, array('adapter' => new Client\Adapter\Curl()));
                $client->setUri('https://api.twitter.com/1.1/account/verify_credentials.json');
                $client->setMethod(Request::METHOD_GET);
                $adapter = new Client\Adapter\Curl();
                $adapter->setCurlOption(CURLOPT_SSL_VERIFYHOST, false);
                $adapter->setCurlOption(CURLOPT_SSL_VERIFYPEER, false);
                $client->setAdapter($adapter);

                $response = $client->send();

                $data = Json::decode($response->getBody(), Json::TYPE_ARRAY);
                $data['token'] = serialize($token);
                $this->isValid = true;
                return new NormalizedData(NormalizedData::PROVIDER_TYPE_TWITTER, $data);
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return !(bool) $this->isValid;
    }
}