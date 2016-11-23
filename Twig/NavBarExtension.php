<?php
namespace SbS\AdminLTEBundle\Twig;

use SbS\AdminLTEBundle\Event\TaskListEvent;
use SbS\AdminLTEBundle\Event\ThemeEvents;
use SbS\AdminLTEBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class NavBarExtension extends \Twig_Extension
{
    /**
     * @var $dispatcher EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(ContainerInterface $container)
    {
        $this->dispatcher = $container->get("event_dispatcher");
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'navbar_tasks',
                [$this, 'TasksFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'navbar_user_account',
                [$this, 'UserAccountFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'user_avatar',
                [$this, 'AvatarFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            )
        ];
    }

    public function TasksFunction(\Twig_Environment $environment)
    {
        if ($this->checkListener(ThemeEvents::TASKS) == false) {
            return "";
        }

        /** @var TaskListEvent $tasksEvent */
        $tasksEvent = $this->dispatcher->dispatch(ThemeEvents::TASKS, new TaskListEvent());

        return $environment->render('SbSAdminLTEBundle:NavBar:tasks.html.twig', [
            'tasks' => $tasksEvent->getTasks(),
            'total' => $tasksEvent->getTotal(),
        ]);

    }

    /**
     * @param \Twig_Environment $environment
     * @return string
     * @throws \Exception
     */
    public function UserAccountFunction(\Twig_Environment $environment)
    {
        if ($this->checkListener(ThemeEvents::USER) == false) {
            return "";
        }

        /** @var UserEvent $userEvent */
        $userEvent = $this->dispatcher->dispatch(ThemeEvents::USER, new UserEvent());

        return $environment->render('SbSAdminLTEBundle:NavBar:user.html.twig', ['user' => $userEvent->getUser()]);
    }


    /**
     * Show User Avatar
     * @param \Twig_Environment $environment
     * @param $image
     * @param string $alt
     * @param string $class
     * @return string
     */
    public function AvatarFunction(\Twig_Environment $environment, $image, $alt = '', $class = 'img-circle')
    {
        if (!$image) {
            $image = 'bundles/sbsadminlte/img/avatar.png';
        }

        return $environment
            ->createTemplate('<img src="{{ asset(image) }}" class="{{ class }}" alt="{{ alt }}"/>')
            ->render([
                'image' => $image,
                'class' => $class,
                'alt'   => $alt,
            ]);
    }

    /**
     * @param $listener
     * @return bool
     */
    private function checkListener($listener)
    {
        return $this->dispatcher->hasListeners($listener);
    }
}
