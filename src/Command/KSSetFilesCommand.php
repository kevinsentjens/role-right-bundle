<?php

namespace KS\RoleRightBundle\Command;

use KS\RoleRightBundle\KSCommandHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class KSSetFilesCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'ks:set-files';
    private $ksCommandHelper;

    public function __construct(KSCommandHelper $ksCommandHelper, string $name = null)
    {
        $this->ksCommandHelper = $ksCommandHelper;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Set the necessary entities and repositories.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command is used to set the necessary entities and repositories. Without these files the service won\'t work.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Trying to set files...');

        if (empty($this->ksCommandHelper->getAppDirectory()))
        {
            $output->writeln('You forgot to configure the app directory. Please configure this in a .yaml file.');
            return Command::FAILURE;
        }

        if ($this->ksCommandHelper->generate() === false)
        {
            $output->writeln('Something went wrong when trying to create the files.');
            return Command::FAILURE;
        }

        $output->writeln('Files successfully generated!');
        return Command::SUCCESS;
    }
}