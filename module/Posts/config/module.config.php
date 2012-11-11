<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Posts;

return array(
    'router' => array(
        'routes' => array(
            'posts' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '[/:sorting]',
                    'constraints' => array(
                        'sorting' => '(best|worst|old|new|top)?',
                    ),
                    'defaults' => array(
                        'controller' => 'Posts\Controller\Post',
                        'action' => 'index',
                        'sorting' => 'top',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'view' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => ':id[/:slug]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                                'slug' => '[-_A-Za-z0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'view',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Posts\Controller\Post' => 'Posts\Controller\PostController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
    ),
);
