<?php

namespace SocialConnect\Service\Factory;

use SocialConnect\Service\TwitterService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwitterServiceFactory implements FactoryInterface
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

        return new TwitterService($config['social-connect']['twitter'], $serviceLocator->get('request'));
    }
}