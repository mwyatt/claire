<?php


/**
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Project extends Controller_Index
{


	public function run()
	{
		$this->single();
	}


	public function single()
	{

		// type/slug/
		if (! $this->url->getPathPart(1)) {
			$this->route('base');
		}

		// read by slug and type
		$json = new Json($this);
		$json->read('projects');
		$projects = $json->getData();
		foreach ($projects as $key => $project) {
			if ($project->slug != $this->url->getPathPart(1)) {
				unset($projects[$key]);
			}
		}
		if (! $project = reset($projects)) {
			$this->route('base');
		}

		// set view
		$this->view
			->setMeta(array(		
				'title' => $project->name
			))
			->setObject('project', $project)
			->getTemplate('project-single');
	}
}
