<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Posts\Entity;

use PHPUnit_Framework_TestCase;

/**
 * Tests Posts\Entity\Post
 *
 * @package Tests
 */
class PostTest extends PHPUnit_Framework_TestCase
{
    public function testInitialState() {
        $postedAt = new \DateTime;
        $post = new Post;

        $this->assertNull($post->id);
        $this->assertNull($post->title);
        $this->assertNull($post->link);
        $this->assertNull($post->body);
        $this->assertEquals($post->postedAt->getTimestamp(),
            $postedAt->getTimestamp());
    }

    public function testConstructor() {
        $post = new Post('Test post, please ignore');

        $this->assertEquals($post->title, 'Test post, please ignore');
    }

    public function testToString() {
        $post = new Post('Test post, please ignore');
        $this->assertEquals((string) $post, 'Test post, please ignore');

        $post = new Post;
        $this->assertEquals((string) $post, '');
    }

    public function testInputFilter() {
        $post = new Post;

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $post->getInputFilter());
    }
}
