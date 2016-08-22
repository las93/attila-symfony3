<?php

namespace Las\Attila\Symfony;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Attila\Batch\Entity as BatchEntity;

class AttilaCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('attila:generate:scaffolding')
            ->setDescription('We create entity and database from configuration file')
            ->setHelp("'We create entity and database from configuration file.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$input->hasArgument('p')) { $input->setArgument('p', 'Batch'); }

        if (!$input->hasArgument('b')) { $input->setArgument('b', json_encode(Config::get('Db', $input->getArgument('p')))); }

        $input->setArgument('g', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$input->getArgument('p').DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Entity'.DIRECTORY_SEPARATOR);

        $input->setArgument('h', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$input->getArgument('p').DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Model'.DIRECTORY_SEPARATOR);


        if (!defined('ENTITY_NAMESPACE')) { define('ENTITY_NAMESPACE', '\Venus\src\\'.$input->getArgument('p').'\Entity'); }

        if (!defined('MODEL_NAMESPACE')) { define('MODEL_NAMESPACE', '\Venus\src\\'.$input->getArgument('p').'\Model'); }

        $oBatch = new BatchEntity;
        $oBatch->runScaffolding($input->getArguments());
    }
}
