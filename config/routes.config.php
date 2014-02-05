<?php
return array(
    'router' => array(
        'routes' => array(
            'social-connect' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/social-connect/[:controller[/][:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'SocialConnect\Controller',
                        'controller'    => 'index',
                        'action'        => 'index'
                    )
                ),
            )
        )
    ),
);