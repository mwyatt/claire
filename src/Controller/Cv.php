<?php

namespace Mwyatt\Portfolio\Controller;

class Cv extends \Mwyatt\Portfolio\Controller
{


	public function single($request) {
		$name = $request->getUrlVar('name');
		if (!in_array($name, ['martin', 'claire'])) {
			return $this->redirect('cv.single', ['name' => 'martin']);
		}

		$config = json_decode(file_get_contents(PATH_BASE . "json/cv/$name-config.json"));
		$panels = json_decode(file_get_contents(PATH_BASE . "json/cv/$name-cv.json"));

		$this->view->data->offsetSet('panels', $panels);
		$this->view->data->offsetSet('config', $config);
		return $this->response($this->view->getTemplate('cv/single.bundle'));
	}
}
