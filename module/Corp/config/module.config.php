<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Corp\Controller\Corp' => 'Corp\Controller\CorpController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'corp' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/corp[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Corp\Controller\Corp',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'corp' => __DIR__ . '/../view',
        ),
    ),
);
