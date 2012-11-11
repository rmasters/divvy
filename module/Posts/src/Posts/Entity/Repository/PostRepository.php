<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Posts\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Query helper for Posts\Entity\Post
 *
 * @package Entities
 */
class PostRepository extends EntityRepository
{
    /**
     * Get posts in order of submission (reversed)
     * @param int $count Number of items to retrieve
     * @return 
     */
    public function findByNewest($count) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
            ->from('Posts\Entity\Post', 'p')
            ->orderBy('p.postedAt', 'DESC')
            ->setMaxResults($count);

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    /**
     * Get posts in order of submission
     */
    public function findByOldest($count) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
            ->from('Posts\Entity\Post', 'p')
            ->orderBy('p.postedAt', 'ASC')
            ->setMaxResults($count);

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    /**
     * Get the best scoring posts (all-time)
     * @todo Implement properly (score is not a database field)
     */
    public function findByBest($count) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
            ->from('Posts\Entity\Post', 'p')
            ->orderBy('p.score', 'ASC')
            ->setMaxResults($count);

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    /**
     * Get the worst scoring posts (all-time)
     * @todo Implement properly (score is not a database field)
     */
    public function findByWorst($count) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
            ->from('Posts\Entity\Post', 'p')
            ->orderBy('p.score', 'DESC')
            ->setMaxResults($count);

        return new ArrayCollection($qb->getQuery()->getResult());
    }

    /**
     * Get the top ranking posts for a given time
     * @todo Implement
     */
    public function findByCurrent($count, \DateTime $when) {
        return new ArrayCollection($this->findAll());
    }
}
