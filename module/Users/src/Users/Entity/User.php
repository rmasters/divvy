<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Users\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\ModelBase;
use Zend\Crypt\Password\Bcrypt;
use Zend\InputFilter\InputFilter;

/**
 * A user account
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @package Entities
 */
class User extends ModelBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Displayed name - must be unique (case-insensitive)
     * @ORM\Column(type="string", length=40, unique=true)
     * @todo Afaik this will add a case-sensitive unique constraint - we want insensitive, but this is still useful
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $emailAddress;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $passwordHash;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $registeredAt;

    /**
     * Constructor
     *
     * @param string|null $username
     * @param string|null $emailAddress
     */
    public function __construct($username=null, $emailAddress=null) {
        $this->setRegisteredAt(new \DateTime);

        $this->setUsername($username);
        $this->setEmailAddress($emailAddress);
    }

    /**
     * Set a new password for the user
     *
     * Stores a bcrypt hash of the given password using the default Zend settings.
     *
     * @param string $password New password to set
     * @return $this
     */
    public function setPassword($password) {
        $bcrypt = new Bcrypt;
        $this->setPasswordHash($bcrypt->create($password));

        return $this;
    }

    /**
     * Checks a given password against the stored hash.
     *
     * @param string $password Password to check
     * @return bool True if they match
     */
    public function checkPassword($password) {
        $bcrypt = new Bcrypt;
        return $bcrypt->verify($password, $this->getPasswordHash());
    }

    /**
     * Returns username (or an empty string if not set)
     *
     * @return string
     */
    public function __toString() {
        return $this->getUsername() ?: '';
    }

    /**
     * InputFilter for Zend\Form
     *
     * @return Zend\InputFilter\InputFilter
     * @todo Complete
     */
    public function getInputFilter() {
        return new InputFilter;
    }
}
