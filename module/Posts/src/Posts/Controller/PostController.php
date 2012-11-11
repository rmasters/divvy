<?php

namespace Posts\Controller;

use \Zend\View\Model\ViewModel;

class PostController extends \Zend\Mvc\Controller\AbstractActionController
{
    public function indexAction() {
        // @todo Make this configurable
        $perPage = 30;

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default'); 

        $repo = $em->getRepository('Posts\Entity\Post');
        switch ($this->params()->fromRoute('sorting', 'top')) {
            case 'new':
                $posts = $repo->findByNewest($perPage);
                break;
            case 'old':
                $posts = $repo->findByOldest($perPage);
                break;
            case 'best':
                $posts = $repo->findByBest($perPage);
                break;
            case 'worst':
                $posts = $repo->findByWorst($perPage);
                break;
            case 'top':
                $posts = $repo->findByCurrent($perPage, new \DateTime);
                break;
            default:
                // 404
                $this->getResponse()->setStatusCode(404);
                return;
        }

        return new ViewModel(array('posts' => $posts));
    }

    public function viewAction() {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default'); 

        // Find a post from the url id param
        $post = $em->getRepository('Posts\Entity\Post')
            ->find($this->params()->fromRoute('id'));

        // If we couldn't find the post, 404
        if (null === $post) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel(array('post' => $post));
    }
}
