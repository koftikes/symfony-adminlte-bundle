<?php
namespace SbS\AdminLTEBundle\Twig;

use SbS\AdminLTEBundle\Event\TaskListEvent;
use SbS\AdminLTEBundle\Event\ThemeEvents;
use SbS\AdminLTEBundle\Event\UserEvent;
use SbS\AdminLTEBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;

class NavBarExtension extends \Twig_Extension
{
    protected $dispatcher;

    public function __construct(TraceableEventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
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

        $userEvent = $this->dispatcher->dispatch(ThemeEvents::USER, new UserEvent());
        $user      = $userEvent->getUser();

        if (!($user instanceof UserInterface)) {
            throw new \Exception("User should implement UserInterface class.");
        }

        return $environment->render('SbSAdminLTEBundle:NavBar:user.html.twig', ['user' => $user]);
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
