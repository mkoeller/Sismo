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
	private $formatter;
	
    public function notify(Commit $commit) {}
	
	public function getFormatter() {
		if(is_null($this->formatter)) {
			$this->formatter = new OutputFormatter(true, array(
				'title' => new OutputFormatterStyle('black', 'yellow')
			));
		}
		
		return $this->formatter;
	}
	
	public function displayToOutputInterface($output) {		
		if(!in_array('--verbose', $_SERVER['argv']) && !in_array('-v', $_SERVER['argv'])) return;
		
		$console    = new ConsoleOutput(
			\Symfony\Component\Console\Output\StreamOutput::VERBOSITY_NORMAL, 
			true, 
			$this->getFormatter()
		);
		
		$lines = explode(PHP_EOL, $output);
		$console->writeln(PHP_EOL . 'OUT|');
		foreach($lines as $line) {
			$console->writeln('OUT| ' . $line);
		}
	}
}