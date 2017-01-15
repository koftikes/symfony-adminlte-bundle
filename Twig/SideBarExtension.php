<?php

namespace SbS\AdminLTEBundle\Twig;

use SbS\AdminLTEBundle\Event\SidebarMenuEvent;
use SbS\AdminLTEBundle\Event\ThemeEvents;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SideBarExtension
 * @package SbS\AdminLTEBundle\Twig
 */
class SideBarExtension extends AdminLTE_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'side_bar_menu',
                [$this, 'SidebarMenuFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    public function SidebarMenuFunction(\Twig_Environment $environment, Request $request)
    {
        if ($this->checkListener(ThemeEvents::SIDEBAR_MENU) == false) {
            return "";
        }

        /** @var SidebarMenuEvent $menuEvent */
        $menuEvent = $this->getDispatcher()->dispatch(ThemeEvents::SIDEBAR_MENU, new SidebarMenuEvent($request));

        return $environment->render('SbSAdminLTEBundle:SideBar:menu.html.twig', ['menu' => $menuEvent->getItems()]);
    }
}
