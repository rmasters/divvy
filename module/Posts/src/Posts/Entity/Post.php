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

/**
 * A post to the site
 *
 * @ORM\Entity(repositoryClass="Posts\Entity\Repository\PostRepository")
 * @ORM\Table(name="post")
 * @package Entities
 */
class Post extends ModelBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Post title (required)
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * Main post link (optional)
     * @ORM\Column(type="string", length=500, nullable=true)
     * @todo How long can a link be? Use a variable text field?
     */
    protected $link;

    /**
     * Post body (optional)
     * This will be raw Markdown source
     * @ORM\Column(type="text", nullable=true)
     */
    protected $body;

    /**
     * URL slug (optional)
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $urlSlug;

    /**
     * When the post was created
     * @ORM\Column(type="datetime")
     */
    protected $postedAt;

    /**
     * The score of the post, as calculated by database triggers on vote
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $score = 0;

    /**
     * When the score field was updated, by database triggers
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $scoreUpdatedAt;

    /**
     * Votes for this post
     * @ORM\OneToMany(targetEntity="Posts\Entity\Vote", mappedBy="post")
     */
    protected $votes;

    /**
     * Constructor
     *
     * @param string|null Post title
     */
    public function __construct($title=null) {
        $this->setPostedAt(new \DateTime);

        $this->setTitle($title);
    }

    public function hasLink() {
        return null !== $this->getLink();
    }

    public function getDomain() {
        return parse_url($this->getLink(), PHP_URL_HOST);
    }

    /**
     * Set the post creation timestamp
     *
     * @param DateTime|string $timestamp DateTime or strtotime()-valid text
     * @throws Exception If a string not acceptable by DateTime's constructor is passed
     * @return $this
     */
    public function setPostedAt($timestamp) {
        if (!$timestamp instanceof \DateTime) {
            $timestamp = new \DateTime($timestamp);
        }
        $this->postedAt = $timestamp;

        return $this;
    }

    /**
     * Get positive votes for this post
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPositiveVotes() {
        return $this->getVotes()->filter(function ($v) {
            return $v->getScore() > 0;
        });
    }

    /**
     * Get positive score
     *
     * Generally this will be count($this->getPositiveVotes()), unless some
     * weighted voting scheme is used (where vote.score != 1).
     */
    public function getPositiveScore() {
        $score = 0;
        foreach ($this->getPositiveVotes() as $vote) {
            $score += $vote->getScore();
        }
        return $score;
    }

    /**
     * Get negative votes for this post
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNegativeVotes() {
        return $this->getVotes()->filter(function ($v) {
            return $v->getScore() < 0;
        });
    }

    /**
     * Get negative score
     *
     * Generally this will be count($this->getNegativeVotes()), unless some
     * weighted voting scheme is used (where vote.score != -1).
     */
    public function getNegativeScore() {
        $score = 0;
        foreach ($this->getNegativeVotes() as $vote) {
            $score += $vote->getScore();
        }
        return $score;
    }

    /**
     * Get the score for the post
     *
     * @return int
     */
    public function getActualScore() {
        $score = 0;
        foreach ($this->getVotes() as $vote) {
            $score += $vote->getScore();
        }
        return $score;
    }

    /**
     * Returns the title of the post (or an empty string)
     * @return string
     */
    public function __toString() {
        return $this->getTitle() ?: '';
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
