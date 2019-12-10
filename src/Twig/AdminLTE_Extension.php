<?php

namespace SbS\AdminLTEBundle\Twig;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Twig\Extension\AbstractExtension;

/**
 * Class AdminLTE_Extension.
 */
abstract class AdminLTE_Extension extends AbstractExtension
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * AdminLTE_Extension constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return EventDispatcherInterface
     */
    protected function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param null|string $listener
     *
     * @return bool
     */
    protected function checkListener($listener)
    {
        return $this->dispatcher->hasListeners($listener);
    }
}
