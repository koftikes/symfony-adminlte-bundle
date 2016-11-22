<?php
namespace SbS\AdminLTEBundle\Twig;

use SbS\AdminLTEBundle\EventListener\UserEventListener;

class UserExtension extends \Twig_Extension
{
    protected $listener;

    public function __construct(UserEventListener $listener)
    {
        $this->listener = $listener;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'avatar',
                [$this, 'AvatarFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'UserAccount',
                [$this, 'UserAccountFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    public function AvatarFunction(\Twig_Environment $environment, $image = "", $alt = "", $class = "img-circle")
    {
        if (empty($image)) {
            $image = 'bundles/sbsadminlte/img/avatar.png';
        }

        return $environment
            ->createTemplate("<img src='{{ asset(image) }}' class='{{ class }}' alt='{{ alt }}'/>")
            ->render([
                'image' => $image,
                'class' => $class,
                'alt' => $alt,
            ]);
    }

    public function UserAccountFunction(\Twig_Environment $environment)
    {
        return $environment->render('SbSAdminLTEBundle:NavBar:user.html.twig', ['user' => $this->listener->getUser()]);
    }

}
