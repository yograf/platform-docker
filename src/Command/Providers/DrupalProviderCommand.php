<?php

namespace mglaman\PlatformDocker\Command\Providers;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

class DrupalProviderCommand extends ProviderCommand
{
    function providerCommandName()
    {
        return 'drupal';
    }

    function providerName()
    {
        return 'Drupal using composer template (https://github.com/drupal-composer/drupal-project)';
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $builder = ProcessBuilder::create([
            'composer',
            'create-project',
            'drupal-composer/drupal-project:8.x-dev',
            $input->getArgument('project'),
            '--stability',
            'dev',
            '--no-interaction'
        ]);
        $builder->setTimeout(null);
        $builder->enableOutput();
        $process = $builder->getProcess();
        $process->run();

        if (!$process->isSuccessful()) {
            $output->writeln($process->getErrorOutput());
        } else {
            $output->writeln($process->getOutput());
        }

    }
}
