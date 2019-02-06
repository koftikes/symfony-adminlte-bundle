<?php

namespace SbS\AdminLTEBundle\Model\Demo;

use SbS\AdminLTEBundle\Model\NotificationInterface;

/**
 * Class NotificationModel
 *
 * @package SbS\AdminLTEBundle\Model\Demo
 */
class NotificationModel implements NotificationInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $icon;

    /**
     * NotificationModel constructor.
     *
     * @param int    $id
     * @param string $message
     * @param string $type
     */
    public function __construct($id, $message, $type = self::TYPE_INFO)
    {
        $this->id      = $id;
        $this->message = $message;
        $this->setIcon($type);
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setIcon($type)
    {
        switch ($type) {
            case self::TYPE_SUCCESS:
                $this->icon = 'fa fa-check-circle text-green';
                break;
            case self::TYPE_WARNING:
                $this->icon = 'fa fa-exclamation-triangle text-yellow';
                break;
            case self::TYPE_DANGER:
                $this->icon = 'fa fa-times-circle text-red';
                break;
            case self::TYPE_INFO:
            default:
                $this->icon = 'fa fa-exclamation-circle text-blue';
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
