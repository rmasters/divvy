<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Posts\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\ModelBase;
use Zend\InputFilter\InputFilter;
use Users\Entity\User;

/**
 * A vote for or against a post
 *
 * @ORM\Entity
 * @ORM\Table(name="vote")
 * @package Entities
 */
class Vote extends ModelBase
{
    /**
     * Post voted upon
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Posts\Entity\Post", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $post;

    /**
     * Voting user
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Users\Entity\User", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * When the vote was added
     * @ORM\Column(type="datetime")
     */
    protected $votedAt;

    /**
     * The score this vote gives
     * @ORM\Column(type="smallint")
     */
    protected $score;

    /**
     * Constructor
     *
     * @param Posts\Entity\Post $post
     * @param Users\Entity\User $user
     */
    public function __construct(Post $post=null, User $user=null) {
        $this->setVotedAt(new \DateTime);

        $this->setPost($post);
        $this->setUser($user);
    }

    /**
     * Set the voted timestamp
     *
     * @param DateTime|string $timestamp DateTime or strtotime()-valid text
     * @throws Exception If a string not acceptable by DateTime's constructor is passed
     * @return $this
     */
    public function setVotedAt($timestamp) {
        if (!$timestamp instanceof \DateTime) {
            $timestamp = new \DateTime($timestamp);
        }
        $this->votedAt = $timestamp;

        return $this;
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
