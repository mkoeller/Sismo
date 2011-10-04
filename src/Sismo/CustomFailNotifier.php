<?php
namespace Sismo;

/**
 * Notifies builds to internal CustomBuilder
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CustomFailNotifier extends CustomNotifier
{
    public function notify(Commit $commit)
    {	
        if(!$commit->isSuccessful()) {
			$builder = new CustomBuilder($GLOBALS['app']['build.path'], $GLOBALS['app']['git.path'], $GLOBALS['app']['git.cmds']);
			$builder->init($commit->getProject());
			$process = $builder->build('fail');
			
			if(($process = $builder->build('fail')) !== null) {	
				$output = PHP_EOL . '<title>>>>> CustomFailNotifier taking place</title>' . PHP_EOL . $process->getOutput();
				$this -> displayToOutputInterface($output);

				$commit -> setOutput($commit ->getOutput() . $this->getFormatter()->format($output));
				$GLOBALS['app']['storage']->updateCommit($commit);
				
				return $output;
			}
		}
		
		return null;		
    }
}
