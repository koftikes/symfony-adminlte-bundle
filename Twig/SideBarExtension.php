<?php

namespace SbS\AdminLTEBundle\Twig;

use SbS\AdminLTEBundle\Event\SidebarMenuEvent;
use SbS\AdminLTEBundle\Event\ThemeEvents;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SideBarExtension
 *
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
                'sidebar_menu',
                [$this, 'SidebarMenuFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'sidebar_toggle_button',
                [$this, 'ToggleButtonFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'sidebar_collapse',
                [$this, 'SidebarCollapseFunction'],
                ['is_safe' => ['html'], 'needs_environment' => false]
            ),
        ];
    }

    public function SidebarMenuFunction(\Twig_Environment $environment, Request $request)
    {
        if ($this->checkListener(ThemeEvents::SIDEBAR_MENU) == false) {
            return '';
        }

        /** @var SidebarMenuEvent $menuEvent */
        $menuEvent = $this->getDispatcher()->dispatch(ThemeEvents::SIDEBAR_MENU, new SidebarMenuEvent($request));

        return $environment->render('@SbSAdminLTE/SideBar/menu.html.twig', ['menu' => $menuEvent->getItems()]);
    }

    /**
     * @param \Twig_Environment $environment
     *
     * @return string
     * @throws \Throwable
     * @throws \Twig_Error_Runtime
     */
    public function ToggleButtonFunction(\Twig_Environment $environment)
    {
        /** @var RoutingExtension $routing */
        $routing  = $environment->getExtension(RoutingExtension::class);
        $template = '<a href="#" class="sidebar-toggle" data-toggle="push-menu"><span class="sr-only">Toggle navigation</span></a>';

        try {
            $url = $routing->getUrl('sbs_adminlte_sidebar_collapse');

            return $environment
                ->createTemplate($template . '<script>
                    $(function () {
                        $(document).on("click", ".sidebar-toggle", function () {
                            event.preventDefault();
                            $.post("{{ url }}", {collapse: $("body").hasClass("sidebar-collapse")} );
                        });
                    });</script>')->render(['url' => $url]);
        } catch (\Exception $e) {
            return $template;
        }
    }

    /**
     * @param Session $session
     *
     * @return string
     */
    public function SidebarCollapseFunction(Session $session)
    {
        if ($session->get('sbs_adminlte_sidebar_collapse') == true) {
            return 'sidebar-collapse';
        }

        return '';
    }
}
