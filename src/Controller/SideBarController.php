<?php

namespace SbS\AdminLTEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $collapse = $request->get('collapse', 'false');
        $response = new JsonResponse($collapse);
        $response->headers->setCookie(new Cookie('sbs_adminlte_sidebar_collapse', $collapse, strtotime('now + 1 year')));

        return $response;
    }
}
