<?php

$entityPath = function ($module) {
    return __DIR__ . "/../../module/$module/src/$module/Entity";
};

return array(
    'doctrine' => array(
        'driver' => array(
            'orm_default' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    $entityPath('Users'),
                    $entityPath('Posts'),
                ),
            ),
        ),
    ),
);
