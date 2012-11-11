<?php

namespace Posts\Controller;

use \Zend\View\Model\ViewModel;

class PostController extends \Zend\Mvc\Controller\AbstractActionController
{
    public function indexAction() {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default'); 

        $posts = $em->getRepository('Posts\Entity\Post')->findAll();

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
