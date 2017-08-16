<?php

namespace SbS\AdminLTEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SideBarController
 * @package SbS\AdminLTEBundle\Controller
 */
class SideBarController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function collapseAction(Request $request)
    {
        $collapse = ($request->get('collapse', false) == "true") ? true : false;
        $request->getSession()->set('sbs_adminlte_sidebar_collapse', $collapse);

        return new JsonResponse($collapse);
    }
}
