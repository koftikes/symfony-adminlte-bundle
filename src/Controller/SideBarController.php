<?php

namespace SbS\AdminLTEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SideBarController
 *
 * @package SbS\AdminLTEBundle\Controller
 */
class SideBarController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function collapse(Request $request)
    {
        $collapse = $request->get('collapse', false) === 'true';
        $session  = $request->getSession();
        if ($session instanceof SessionInterface) {
            $session->set('sbs_adminlte_sidebar_collapse', $collapse);
        }

        return new JsonResponse($collapse);
    }
}
