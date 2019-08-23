<?php

namespace SbS\AdminLTEBundle\Controller\Demo;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProfileController.
 */
class UserController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile()
    {
        return $this->render('@SbSAdminLTE/Default/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout()
    {
        return $this->render('@SbSAdminLTE/Default/index.html.twig');
    }
}
