<?php
namespace Sismo;

use Symfony\Component\Process\Process;

class CustomBuilder extends Builder {
	public function build($command = null)
    {		
		if(!is_null($command) && $this->project->getCommand($command) != '') {
			file_put_contents($this->buildDir.'/sismo-build-custom-' . $command . '.sh', str_replace(array("\r\n", "\r"), "\n", $this->project->getCommand($command)));

			$process = new Process('sh sismo-build-custom-' . $command . '.sh', $this->buildDir);
			$process->setTimeout(3600);
			$process->run();		

			return $process;
		}
		
		return null;
    }
	
	public function init(Project $project, $callback = null)
    {
        $this->project  = $project;
        $this->buildDir = $GLOBALS['app']['build.path'].'/'.substr(md5($project->getRepository()), 0, 6);
		
		return parent::init($project, $callback);
    }
}

?>
