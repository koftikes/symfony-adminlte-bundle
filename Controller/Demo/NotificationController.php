<?php

namespace SbS\AdminLTEBundle\Controller\Demo;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class NotificationController
 *
 * @package SbS\AdminLTEBundle\Controller\Demo
 */
class NotificationController extends Controller
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
    public function notice()
    {
        return $this->render('@SbSAdminLTE/Default/index.html.twig');
    }
}
