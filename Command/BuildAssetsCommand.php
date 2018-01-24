<?php

namespace SbS\AdminLTEBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Parser;

/**
 * Command copy AdminLTE Theme files into bundle public directory..
 */
class BuildAssetsCommand extends Command
{
    protected static $defaultName = 'sbs:admin-lte:build-assets';

    protected $package;

    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription("Install AdminLTE assets into bundle public directory.");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->text("// Trying to build AdminLTE bundle assets.");

        /** @var Kernel $kernel */
        $kernel = $this->getApplication()->getKernel();
        $resource = $kernel->locateResource("@SbSAdminLTEBundle/Resources/");

        $yml           = new Parser();
        $assets        = $yml->parse(file_get_contents($resource . "config/assets.yml"));
        $this->package = $kernel->getRootDir() . $assets["package"]["path"];

        if (!$this->filesystem->exists($this->package)) {
            $io->error("AdminLTE package should be installed first.");
            exit;
        }

        $this->processFiles("{$resource}public/styles/", $assets["css"]);
        $this->processFiles("{$resource}public/js/", $assets["js"]);

        $img = $this->processFolders(realpath($this->package . $assets["images"]));
        $this->processFiles("{$resource}public/img/", $img);

        foreach ($assets["plugins"] as $plugin) {
            $name = strrchr($plugin, "/");
            $plg  = $this->processFolders(realpath($this->package . $plugin));
            $this->processFiles("{$resource}public/plugins{$name}/", $plg);
        }

        $io->success("All assets were successfully installed into bundle directory.");
    }

    /**
     * Copy assets into bundle resource directory
     *
     * @param            $path
     * @param            $structure
     */
    private function processFiles($path, $structure)
    {
        if ($this->filesystem->exists($path)) {
            $this->filesystem->remove($path);
        }

        foreach ($structure as $dir => $files) {
            $sub_dir = ($dir == "main") ? $path : $path . $dir;
            $this->filesystem->exists($sub_dir) or $this->filesystem->mkdir($sub_dir);
            foreach ($files as $name => $file) {
                $file_path = is_file($file) ? $file : realpath($this->package . $file);
                $file_name = (is_string($name)) ? $name : basename($file_path);
                $this->filesystem->copy($file_path, $sub_dir . DIRECTORY_SEPARATOR . $file_name);
            }
        }
    }

    /**
     * Process folders and prepare structure for copy assets.
     *
     * @param $path
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
            $key           = ($file->getRelativePath()) ? $file->getRelativePath() : "main";
            $files[$key][] = $file->getRealPath();
        }
        return $files;
    }
}
