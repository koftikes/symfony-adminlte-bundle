<?php

namespace SbS\AdminLTEBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
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
class BuildAssetsCommand extends ContainerAwareCommand
{
    protected $package;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("sbs:admin-lte:build-assets")
            ->setDescription("Install AdminLTE assets into bundle public directory.");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->text("// Trying to build AdminLTE bundle assets.");

        $yml = new Parser();
        $fs  = new Filesystem();
        /** @var Kernel $kernel */
        $kernel = $this->getContainer()->get("kernel");

        $resource      = $kernel->locateResource("@SbSAdminLTEBundle/Resources/");
        $assets        = $yml->parse(file_get_contents($resource . "config/assets.yml"));
        $this->package = $kernel->getRootDir() . $assets["package"]["path"];

        if (!$fs->exists($this->package)) {
            $io->error("AdminLTE package should be installed first.");
            exit;
        }

        $this->processFiles($fs, "{$resource}public/styles/", $assets["css"]);
        $this->processFiles($fs, "{$resource}public/js/", $assets["js"]);

        $img = $this->processFolders(realpath($this->package . $assets["images"]));
        $this->processFiles($fs, "{$resource}public/images/", $img);

        foreach ($assets["plugins"] as $plugin) {
            $plg = $this->processFolders(realpath($this->package . $plugin));
            $this->processFiles($fs, "{$resource}public{$plugin}/", $plg);
        }
        $io->success("All assets were successfully installed into bundle directory.");
    }

    /**
     * Copy assets into bundle resource directory
     * @param Filesystem $fs
     * @param $path
     * @param $structure
     */
    private function processFiles(Filesystem $fs, $path, $structure)
    {
        if ($fs->exists($path)) {
            $fs->remove($path);
        }

        foreach ($structure as $dir => $files) {
            $sub_dir = ($dir == "main") ? $path : $path . $dir;
            $fs->exists($sub_dir) or $fs->mkdir($sub_dir);
            foreach ($files as $name => $file) {
                $file_path = is_file($file) ? $file : realpath($this->package . $file);
                $file_name = (is_string($name)) ? $name : basename($file_path);
                $fs->copy($file_path, $sub_dir . DIRECTORY_SEPARATOR . $file_name);
            }
        }
    }

    /**
     * Process folders and prepare structure for copy assets.
     * @param $path
     * @return array
     */
    private function processFolders($path)
    {
        $finder = new Finder();
        $finder->files()->in($path);
        $files = array();
        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $key           = ($file->getRelativePath()) ? $file->getRelativePath() : "main";
            $files[$key][] = $file->getRealPath();
        }
        return $files;
    }
}
