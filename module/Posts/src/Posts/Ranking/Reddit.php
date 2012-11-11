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
 * The 'hot' ranking algorithm used by reddit for posts
 *
 * Essential reading: http://amix.dk/blog/post/19588
 */
class Reddit
{
    private $constant = 45000;

    public function score(Post $post, \DateTime $now=null) {
        $score = $post->getScore();

        $order = log(max(abs($score), 1), 10);

        // score > 0: 1,  score < 0: -1,  score = 0: 0
        $sign = $score > 0 ? 1 : $score < 0 ? -1 : 0;

        return round($order + $sign * $post->postedAt->getTimestamp() / $this->constant, 7);
    }
}
