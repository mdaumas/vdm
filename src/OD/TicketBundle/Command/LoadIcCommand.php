<?php

namespace OD\TicketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commande de chargement des fichiers Incoming Call.
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class LoadIcCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('vdm:load-ic')
            ->setDescription('Load a csv file of incoming calls')
            ->addArgument('file', InputArgument::REQUIRED, 'The file to read')
            ->addOption('skip', null, InputOption::VALUE_OPTIONAL, 'The number of file to skip.')
            ->addOption('sep', null, InputOption::VALUE_OPTIONAL, 'The field separator character.')
            ->setHelp(<<<EOT
The command <info>vdm:load-ic</info> load a csv file of incoming calls:

  <info>php app/console vdm:load-ic [--skip=n] [--separator=c] file </info>

Optionaly you can specify the number of line to skip before loading. Default is 1<comment>--skip</comment>:
Optionaly you can specify the field separator character. Default is ','<comment>--sep</comment>:

  <info>php app/console vdm:load-ic file --skip=1 --sep=,</info>
EOT
        );
    }

    /**
     * Load a csv file of incoming calls
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @SuppressWarnings(PHPMD)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $application = $this->getApplication();
        $container = $application->getKernel()->getContainer();
        $file = $input->getArgument('file');

        echo "Loading " . $file . "\n";

        $loader = $container->get('incoming.loader');
        $skip = $input->getOption('skip');
        $sep = $input->getOption('sep');
        $loader->setSkipLines($skip ? $skip : 1);
        $loader->setSeparator($sep ? $sep : ',');
        $loader->setFile($file);

        $loader->load();

        echo "Done " . $loader->parsed . "/" . $loader->count . " lines loaded\n";
    }

}