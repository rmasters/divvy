<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Users\Entity;

use PHPUnit_Framework_TestCase;

/**
 * Tests Users\Entity\User
 *
 * @package Tests
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    public function testInitialState() {
        $userCreatedAt = new \DateTime;
        $user = new User;

        $this->assertNull($user->id);
        $this->assertNull($user->username);
        $this->assertNull($user->emailAddress);
        $this->assertNull($user->passwordHash);
        $this->assertEquals($user->registeredAt->getTimestamp(),
            $userCreatedAt->getTimestamp());
    }

    public function testConstructor() {
        $user = new User('rmas', 'ross@example.com');

        $this->assertEquals($user->username, 'rmas');
        $this->assertEquals($user->emailAddress, 'ross@example.com');
    }

    public function testToString() {
        $user = new User('rmas');
        $this->assertEquals((string) $user, 'rmas');

        $user = new User;
        $this->assertEquals((string) $user, '');
    }

    public function testInputFilter() {
        $user = new User;

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $user->getInputFilter());
    }

    public function testPassword() {
        $user = new User;

        $user->setPassword('password');
        $this->assertTrue($user->checkPassword('password'));

        // Check case sensitivity works
        $user->setPassword('pAsSwOrD');
        $this->assertTrue($user->checkPassword('pAsSwOrD'));
        $this->assertFalse($user->checkPassword('password'));
    }
}
