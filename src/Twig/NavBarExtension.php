<?php

namespace SbS\AdminLTEBundle\Twig;

use SbS\AdminLTEBundle\Event\NotificationListEvent;
use SbS\AdminLTEBundle\Event\TaskListEvent;
use SbS\AdminLTEBundle\Event\ThemeEvents;
use SbS\AdminLTEBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class NavBarExtension.
 */
class NavBarExtension extends AdminLTE_Extension
{
    /**
     * @var string - Dir of AdminLTE bundle
     */
    private $projectDir;

    /**
     * NavBarExtension constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param string                   $projectDir
     */
    public function __construct(EventDispatcherInterface $dispatcher, $projectDir)
    {
        $this->projectDir = $projectDir;
        parent::__construct($dispatcher);
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'nav_bar_notifications',
                [$this, 'showNotifications'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'nav_bar_tasks',
                [$this, 'showTasks'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'nav_bar_user_account',
                [$this, 'showUserAccount'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'user_avatar',
                [$this, 'showAvatar'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    /**
     * @param \Twig_Environment $environment
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function showNotifications(\Twig_Environment $environment)
    {
        if (false === $this->checkListener(ThemeEvents::NOTICES)) {
            return '';
        }

        /** @var NotificationListEvent $noticesEvent */
        $noticesEvent = $this->getDispatcher()->dispatch(ThemeEvents::NOTICES, new NotificationListEvent());

        return $environment->render('@SbSAdminLTE/NavBar/notifications.html.twig', [
            'notifications' => $noticesEvent->getNotifications(),
            'total'         => $noticesEvent->getTotal(),
        ]);
    }

    /**
     * @param \Twig_Environment $environment
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function showTasks(\Twig_Environment $environment)
    {
        if (false === $this->checkListener(ThemeEvents::TASKS)) {
            return '';
        }

        /** @var TaskListEvent $tasksEvent */
        $tasksEvent = $this->getDispatcher()->dispatch(ThemeEvents::TASKS, new TaskListEvent());

        return $environment->render('@SbSAdminLTE/NavBar/tasks.html.twig', [
            'tasks' => $tasksEvent->getTasks(),
            'total' => $tasksEvent->getTotal(),
        ]);
    }

    /**
     * @param \Twig_Environment $environment
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function showUserAccount(\Twig_Environment $environment)
    {
        if (false === $this->checkListener(ThemeEvents::USER)) {
            return '';
        }

        /** @var UserEvent $userEvent */
        $userEvent = $this->getDispatcher()->dispatch(ThemeEvents::USER, new UserEvent());

        return $environment->render('@SbSAdminLTE/NavBar/user.html.twig', ['user' => $userEvent->getUser()]);
    }

    /**
     * @param \Twig_Environment $environment
     * @param string            $image
     * @param string            $alt
     * @param string            $class
     *
     * @throws \Exception
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function showAvatar(\Twig_Environment $environment, $image, $alt = '', $class = 'img-circle')
    {
        if (!$image || !\file_exists($image)) {
            $image = $this->projectDir
                . (\version_compare(Kernel::VERSION, '4.0') < 0 ? '/web' : '/public')
                . '/bundles/sbsadminlte/img/avatar.png';
        }

        if ($image = \file_get_contents($image)) {
            $image = 'data:image/png;base64,' . \base64_encode($image);
        }

        return $environment
            ->createTemplate('<img src="{{ image }}" class="{{ class }}" alt="{{ alt }}"/>')
            ->render([
                'image' => $image,
                'class' => $class,
                'alt'   => $alt,
            ]);
    }
}
