<?php
namespace SbS\AdminLTEBundle\Event;

/**
 * Holds all events used by the theme
 */
class ThemeEvents
{
    /**
     * Used to receive notification data
     */
    const NOTICES = 'sbs.admin_lte.notifications';
    
    /**
     * Used to receive task data
     */
    const TASKS = 'sbs.admin_lte.tasks';

    /**
     * Used to receive the current user
     */
    const USER = 'sbs.admin_lte.user';

    /**
     * Used to receive the sidebar menu data
     */
    const SIDEBAR_MENU = 'sbs.admin_lte.sidebar_menu';
}
