<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'facebookConnect' => 'SocialConnect\Service\Factory\FacebookServiceFactory',
            'twitterConnect'  => 'SocialConnect\Service\Factory\TwitterServiceFactory',
        )
    )
);