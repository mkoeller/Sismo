<?php
namespace Sismo;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Notifies builds to internal CustomBuilder
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class CustomNotifier extends Notifier
{
    public function notify(Commit $commit) {}
	
	public function displayToOutputInterface($output) {
		$formatter = new OutputFormatter(true, array(
			'title' => new OutputFormatterStyle('black', 'yellow')
		));
		
		$console    = new ConsoleOutput(
			\Symfony\Component\Console\Output\StreamOutput::VERBOSITY_NORMAL, 
			true, 
			$formatter
		);
		
		$lines = explode(PHP_EOL, $output);
		$console->writeln(PHP_EOL . 'OUT|');
		foreach($lines as $line) {
			$console->writeln('OUT| ' . $line);
		}
	}
}
