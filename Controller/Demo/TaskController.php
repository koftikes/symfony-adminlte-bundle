<?php

namespace SbS\AdminLTEBundle\Controller\Demo;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TaskController
 *
 * @package SbS\AdminLTEBundle\Controller\Demo
 */
class TaskController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function main()
    {
        return $this->render('@SbSAdminLTE/Default/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function task()
    {
        return $this->render('@SbSAdminLTE/Default/index.html.twig');
    }
}
