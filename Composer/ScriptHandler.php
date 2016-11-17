<?php
namespace SbS\AdminLTEBundle\Composer;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;
use Composer\Script\Event;

class ScriptHandler
{
    /**
     * Composer variables are declared static so that an event could update
     * a composer.json and set new options, making them immediately available
     * to forthcoming listeners.
     */
    private static $options = [
        'symfony-app-dir' => 'app'
    ];

    /**
     * @param Event $event
     * @return bool
     */
    public static function buildAssets(Event $event)
    {
        $options    = self::getOptions($event);
        $consoleDir = self::getConsoleDir($event, "installing bundle assets");

        if (null === $consoleDir) {
            return false;
        }

        static::executeCommand($event, $consoleDir, 'sbs:admin-lte:build-assets', $options['process-timeout']);
    }

    /**
     * @param Event $event
     * @return array
     */
    protected static function getOptions(Event $event)
    {
        $options                    = array_merge(static::$options, $event->getComposer()->getPackage()->getExtra());
        $options['process-timeout'] = $event->getComposer()->getConfig()->get('process-timeout');

        return $options;
    }

    /**
     * Returns a relative path to the directory that contains the `console` command.
     *
     * @param Event $event The command event
     * @param string $actionName The name of the action
     *
     * @return string|null The path to the console directory, null if not found.
     */
    protected static function getConsoleDir(Event $event, $actionName)
    {
        $options = static::getOptions($event);

        if (static::useNewDirectoryStructure($options)) {
            if (!static::hasDirectory($event, 'symfony-bin-dir', $options['symfony-bin-dir'], $actionName)) {
                return false;
            }
            return $options['symfony-bin-dir'];
        }

        if (!static::hasDirectory($event, 'symfony-app-dir', $options['symfony-app-dir'], 'execute command')) {
            return false;
        }
        return $options['symfony-app-dir'];
    }

    /**
     * Returns true if the new directory structure is used.
     *
     * @param array $options Composer options
     *
     * @return bool
     */
    protected static function useNewDirectoryStructure(array $options)
    {
        return isset($options['symfony-var-dir']) && is_dir($options['symfony-var-dir']);
    }

    protected static function hasDirectory(Event $event, $configName, $path, $actionName)
    {
        if (!is_dir($path)) {
            $event->getIO()->write(sprintf('The %s (%s) specified in composer.json was not found in %s, can not %s.',
                $configName, $path, getcwd(), $actionName));
            return false;
        }
        return true;
    }

    protected static function executeCommand(Event $event, $consoleDir, $cmd, $timeout = 300)
    {
        $php     = escapeshellarg(static::getPhp(false));
        $phpArgs = implode(' ', array_map('escapeshellarg', static::getPhpArguments()));
        $console = escapeshellarg($consoleDir . '/console');
        if ($event->getIO()->isDecorated()) {
            $console .= ' --ansi';
        }

        $process = new Process($php . ($phpArgs ? ' ' . $phpArgs : '') . ' ' . $console . ' ' . $cmd, null, null, null,
            $timeout);
        $process->run(function ($type, $buffer) use ($event) {
            $event->getIO()->write($buffer, false);
        });
        if (!$process->isSuccessful()) {
            throw new \RuntimeException(sprintf("An error occurred when executing the \"%s\" command:\n\n%s\n\n%s.",
                escapeshellarg($cmd), $process->getOutput(), $process->getErrorOutput()));
        }
    }

    protected static function getPhpArguments()
    {
        $arguments = array();

        $phpFinder = new PhpExecutableFinder();
        if (method_exists($phpFinder, 'findArguments')) {
            $arguments = $phpFinder->findArguments();
        }

        if (false !== $ini = php_ini_loaded_file()) {
            $arguments[] = '--php-ini=' . $ini;
        }

        return $arguments;
    }

    protected static function getPhp($includeArgs = true)
    {
        $phpFinder = new PhpExecutableFinder();
        if (!$phpPath = $phpFinder->find($includeArgs)) {
            throw new \RuntimeException('The php executable could not be found, add it to your PATH environment variable and try again');
        }

        return $phpPath;
    }
}
