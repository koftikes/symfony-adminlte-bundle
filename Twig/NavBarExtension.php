<?php

namespace SbS\AdminLTEBundle\Twig;

use SbS\AdminLTEBundle\Event\NotificationListEvent;
use SbS\AdminLTEBundle\Event\TaskListEvent;
use SbS\AdminLTEBundle\Event\ThemeEvents;
use SbS\AdminLTEBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class NavBarExtension
 *
 * @package SbS\AdminLTEBundle\Twig
 */
class NavBarExtension extends AdminLTE_Extension
{
    /**
     * @var string - Dir of AdminLTE bundle
     */
    private $bundleDir;

    /**
     * NavBarExtension constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param                          $bundleDir
     */
    public function __construct(EventDispatcherInterface $dispatcher, $bundleDir)
    {
        $this->bundleDir = $bundleDir;
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
                [$this, 'NotificationsFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'nav_bar_tasks',
                [$this, 'TasksFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'nav_bar_user_account',
                [$this, 'UserAccountFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'user_avatar',
                [$this, 'AvatarFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    /**
     * @param \Twig_Environment $environment
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function NotificationsFunction(\Twig_Environment $environment)
    {
        if ($this->checkListener(ThemeEvents::NOTICES) == false) {
            return "";
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
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function TasksFunction(\Twig_Environment $environment)
    {
        if ($this->checkListener(ThemeEvents::TASKS) == false) {
            return "";
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
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function UserAccountFunction(\Twig_Environment $environment)
    {
        if ($this->checkListener(ThemeEvents::USER) == false) {
            return "";
        }

        /** @var UserEvent $userEvent */
        $userEvent = $this->getDispatcher()->dispatch(ThemeEvents::USER, new UserEvent());

        return $environment->render('@SbSAdminLTE/NavBar/user.html.twig', ['user' => $userEvent->getUser()]);
    }

    /**
     * @param \Twig_Environment $environment
     * @param                   $image
     * @param string            $alt
     * @param string            $class
     *
     * @return string
     * @throws \Exception
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function AvatarFunction(\Twig_Environment $environment, $image, $alt = '', $class = 'img-circle')
    {
        if (!$image || !file_exists($image)) {
            $image = $this->bundleDir . '/img/avatar.png';
        }

        $image = "data:image/png;base64," . base64_encode(file_get_contents($image));

        return $environment
            ->createTemplate('<img src="{{ image }}" class="{{ class }}" alt="{{ alt }}"/>')
            ->render([
                'image' => $image,
                'class' => $class,
                'alt'   => $alt,
            ]);
    }
}
