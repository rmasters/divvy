<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Application;

return array(
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
    ),
);
