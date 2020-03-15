<?php

namespace SbS\AdminLTEBundle\Twig;

use SbS\AdminLTEBundle\Event\SidebarMenuEvent;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\TwigFunction;

/**
 * Class SideBarExtension.
 */
class SideBarExtension extends AdminLTE_Extension
{
    /**
     * @return array<TwigFunction>
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'sidebar_menu',
                [$this, 'sidebarMenu'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new TwigFunction(
                'sidebar_toggle_button',
                [$this, 'toggleButton'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new TwigFunction(
                'sidebar_collapse',
                [$this, 'sidebarCollapse'],
                ['is_safe' => ['html'], 'needs_environment' => false]
            ),
        ];
    }

    /**
     * @param Environment $environment
     * @param Request     $request
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return string
     */
    public function sidebarMenu(Environment $environment, Request $request)
    {
        if (false === $this->checkListener(SidebarMenuEvent::class)) {
            return '';
        }

        /** @var SidebarMenuEvent $menuEvent */
        $menuEvent = $this->getDispatcher()->dispatch(new SidebarMenuEvent($request));

        return $environment->render('@SbSAdminLTE/SideBar/menu.html.twig', ['menu' => $menuEvent->getItems()]);
    }

    /**
     * @param Environment $environment
     *
     * @return string
     */
    public function toggleButton(Environment $environment)
    {
        /** @var RoutingExtension $routing */
        $routing  = $environment->getExtension(RoutingExtension::class);
        $template = '<a class="nav-link sidebar-toggle" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>';

        try {
            $url = $routing->getPath('sbs_adminlte_sidebar_collapse');

            return $environment
                ->createTemplate($template . '<script>
                    $(function () {
                        $(document).on("click", ".sidebar-toggle", function (e) {
                            e.preventDefault();
                            $.post("{{ url }}", {collapse: $("body").hasClass("sidebar-collapse")} );
                        });
                    });</script>')->render(['url' => $url]);
        } catch (\Exception $e) {
            return $template;
        }
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function sidebarCollapse(Request $request)
    {
        return ('true' === $request->cookies->get('sbs_adminlte_sidebar_collapse', 'false')) ? 'sidebar-collapse' : '';
    }
}
