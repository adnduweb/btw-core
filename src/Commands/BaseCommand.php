<?php

declare(strict_types=1);

namespace Btw\Core\Commands;

use CodeIgniter\CLI\BaseCommand as FrameworkBaseCommand;
use CodeIgniter\CLI\Commands;
use CodeIgniter\CLI\CLI;
use Psr\Log\LoggerInterface;

abstract class BaseCommand extends FrameworkBaseCommand
{
    protected static ?InputOutput $io = null;

    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Btw';

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        parent::__construct($logger, $commands);
    }

    /**
     * Asks the user for input.
     *
     * @param string       $field      Output "field" question
     * @param array|string $options    String to a default value, array to a list of options (the first option will be the default value)
     * @param array|string $validation Validation rules
     *
     * @return string The user input
     */
    protected function prompt(string $field, $options = null, $validation = null): string
    {
        return CLI::prompt($field, $options, $validation);
    }

    /**
     * Outputs a string to the cli on its own line.
     */
    protected function write(
        string $text = '',
        ?string $foreground = null,
        ?string $background = null
    ): void {
        CLI::write($text, $foreground, $background);
    }

    /**
     * Outputs an error to the CLI using STDERR instead of STDOUT
     */
    protected function error(
        string $text,
        string $foreground = 'light_red',
        ?string $background = null
    ): void {
        CLI::error($text, $foreground, $background);
    }
}
