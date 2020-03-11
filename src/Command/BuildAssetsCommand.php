<?php

namespace SbS\AdminLTEBundle\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Yaml\Parser;

/**
 * Command copy AdminLTE Theme files into bundle public directory..
 */
class BuildAssetsCommand extends Command
{
    protected static $defaultName = 'sbs:admin-lte:build-assets';

    /**
     * @var string - Path to almasaeed2010 package in vendors folder
     */
    protected $package;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * BuildAssetsCommand constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Install AdminLTE assets into bundle public directory.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return null|int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('// Trying to build AdminLTE bundle assets.');

        /** @var Application $application */
        $application = $this->getApplication();
        /** @var Kernel $kernel */
        $kernel      = $application->getKernel();
        $resource    = $kernel->locateResource('@SbSAdminLTEBundle/Resources/');
        $resource    = \is_array($resource) ? $resource[0] : $resource;

        $yml           = new Parser();
        $assets        = $yml->parseFile($resource . 'config/assets.yml');
        $this->package = $kernel->getProjectDir() . $assets['package']['path'];

        if (!$this->filesystem->exists($this->package)) {
            $io->error('AdminLTE package should be installed first.');
            exit;
        }

        $this->processFiles("{$resource}public/styles/", $assets['css']);
        $this->processFiles("{$resource}public/js/", $assets['js']);

        $img = $this->processFolders((string) \realpath($this->package . $assets['images']));
        $this->processFiles("{$resource}public/img/", $img);

        $this->processPlugins($assets['plugins'], "{$resource}public/plugins");

        $io->success('All assets were successfully installed into bundle directory.');
    }

    /**
     * @param array  $folder
     * @param string $new_path
     */
    private function processPlugins(array $folder, $new_path): void
    {
        foreach ($folder as $sub_folder) {
            $name   = \mb_strrchr($sub_folder, '/');
            $result = $this->processFolders((string) \realpath($this->package . $sub_folder));
            $this->processFiles("{$new_path}{$name}/", $result);
        }
    }

    /**
     * Copy assets into bundle resource directory.
     *
     * @param string $path
     * @param array  $structure
     */
    private function processFiles($path, $structure): void
    {
        if ($this->filesystem->exists($path)) {
            $this->filesystem->remove($path);
        }
        foreach ($structure as $dir => $files) {
            $sub_dir = ('main' === $dir) ? $path : $path . $dir;
            $this->filesystem->exists($sub_dir) or $this->filesystem->mkdir($sub_dir);
            foreach ($files as $name => $file) {
                $file_path = \is_file($file) ? $file : \realpath($this->package . $file);
                $file_name = \is_string($name) ? $name : \basename($file_path);
                $this->filesystem->copy($file_path, $sub_dir . DIRECTORY_SEPARATOR . $file_name);
            }
        }
    }

    /**
     * Process folders and prepare structure for copy assets.
     *
     * @param string $path
     *
     * @return array
     */
    private function processFolders($path)
    {
        $finder = new Finder();
        $finder->files()->in($path);
        $files = [];
        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $key           = $file->getRelativePath();
            $files[$key][] = $file->getRealPath();
        }

        return $files;
    }
}
