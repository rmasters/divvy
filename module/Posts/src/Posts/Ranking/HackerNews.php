<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Posts\Ranking;

use Posts\Entity\Post;

/**
 * The Hacker News ranking algorithm
 *
 * Essential reading: http://amix.dk/blog/post/19574
 *
 * @package Ranking
 */
class HackerNews
{
    private $gravity = 1.8;

    public function __construct($gravity=null) {
        if (null !== $gravity) {
            $this->setGravity($gravity);
        }
    }

    public function setGravity($gravity) {
        $this->gravity = $gravity;
    }

    public function getGravity() {
        return $this->gravity;
    }

    public function score(Post $post, \DateTime $now=null) {
        // Find the age of the post in hours
        $now = null === $now ? new \DateTime : $now;
        $diff = $now->getTimestamp() - $post->postedAt->getTimestamp();
        $hours = floor($diff / 3600);

        return $post->score / pow($hours + 2, $this->getGravity());
    }
}
