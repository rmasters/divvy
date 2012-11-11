<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Posts\Entity;

use Application\ModelBase;
use Users\Entity\User;

/**
 * A vote for a post
 *
 * @package Entities
 */
class Upvote extends Vote
{
    protected $score = 1;
}
