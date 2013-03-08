<?php

namespace OD\TicketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commande de chargement des fichiers Incoming Call.
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class LoadIcCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('vdm:load-ic')
            ->setDescription('Load a csv file of incoming calls')
            ->addArgument('file', InputArgument::REQUIRED, 'The file to read')
            ->setHelp(<<<EOT
The command <info>vdm:load-ic</info> load a csv file of incoming calls:

  <info>php app/console vdm:load-ic file </info>
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
        $loader->setSkipLines(1);
        $loader->setSeparator(',');
        $loader->setFile($file);

        $loader->load();

        echo "Done " . $loader->parsed . "/" . $loader->count . " lines loaded\n";
    }

}