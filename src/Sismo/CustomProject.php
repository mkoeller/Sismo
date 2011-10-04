<?php
namespace Sismo;

class CustomProject extends Project {
	private $project;
	private $customCommands;
	
	public function __construct(Project $project) {		
		$this -> project = $project;
	}
	
	public function __toString()
    {
        return (string) $this->project;
    }

    public function setBuilding($bool)
    {
        return $this->project->setBuilding($bool);
    }

    public function isBuilding()
    {
        return $this->project->isBuilding();
    }

    public function addNotifier(Notifier $notifier)
    {
        return $this->project->addNotifier($notifier);
    }

    public function getNotifiers()
    {
        return $this->project->getNotifiers();
    }

    public function setBranch($branch)
    {
        return $this->project->setBranch($branch);
    }

    public function getBranch()
    {
        return $this->project->getBranch();
    }

    public function setCommits(array $commits = array())
    {
        return $this->project->setCommits($commits);
    }

    public function getCommits()
    {
        return $this->project->getCommits();
    }

    public function getLatestCommit()
    {
        return $this->project->getLatestCommit();
    }

    public function getStatusCode()
    {
        return $this->project->getStatusCode();
    }

    public function getStatus()
    {
        return $this->project->getStatus();
    }

    public function getCCStatus()
    {
        return $this->project->getCCStatus();
    }

    public function getCCActivity()
    {
        return $this->project->getCCActivity();
    }

    public function getName()
    {
        return $this->project->getName();
    }

    public function getShortName()
    {
        return $this->project->getShortName();
    }

    public function getSubName()
    {
        return $this->project->getSubName();
    }

    public function getSlug()
    {
        return $this->project->getSlug();
    }

    public function setSlug($slug)
    {
        return $this->project->setSlug($slug);
    }

    public function getRepository()
    {
        return $this->project->getRepository();
    }

    public function setRepository($url)
    {
        return $this->project->setRepository($url);
    }

    public function getCommand($which = null)
    {		
		if(!is_null($which)) {
			return $this->customCommands[$which];
		} else {
			return $this->project->getCommand();
		}
    }

    public function setCommand($command, $which = null)
    {
		if(!is_null($which)) {
			$this->customCommands[$which] = $command;
			return $this;
		} else {
			return $this->project->setCommand($command);
		}
    }

    public function getUrlPattern()
    {
        return $this->project->getUrlPattern();
    }

    public function setUrlPattern($pattern)
    {
        return $this->project->setUrlPattern($pattern);
    }

    // code derived from http://php.vrana.cz/vytvoreni-pratelskeho-url.php
    private function slugify($text)
    {
        return $this->project->slugify($text);
    }
}

?>
