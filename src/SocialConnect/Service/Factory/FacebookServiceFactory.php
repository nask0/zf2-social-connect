<?php

namespace SocialConnect\Service\Factory;

use SocialConnect\Config\FacebookConfig;
use SocialConnect\Service\FacebookService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FacebookServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed|FacebookService
     * @throws \Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        if (!array_key_exists('social-connect', $config)) {
            throw new \Exception('You must copy the social-connect.local.php.dist file to your config/autoload directory.');
        }

        return new FacebookService(new FacebookConfig($config['social-connect']), $serviceLocator->get('request'));
    }
}