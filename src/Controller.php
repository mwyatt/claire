<?php

namespace Mwyatt\Portfolio;

class Controller extends \Mwyatt\Core\Controller
{


	public function home() {
		$projects = json_decode(file_get_contents(PATH_BASE . 'json/projects.json'));
		$skills = json_decode(file_get_contents(PATH_BASE . 'json/skills.json'));
		$url = $this->get('Url');

		// menu primary
		$menuPrimary = [
			(object) [
				'name' => 'Home',
				'url' => $url->generate('home') . '#top'
			],
			(object) [
				'name' => 'About me',
				'url' => $url->generate('home') . '#about-me'
			],
			(object) [
				'name' => 'View CV',
				'url' => $url->generate('home') . 'cv/martin/'
			],
			(object) [
				'name' => 'Projects',
				'url' => $url->generate('home') . '#projects'
			],
			(object) [
				'name' => 'Skills',
				'url' => $url->generate('home') . '#skills'
			],
			(object) [
				'name' => 'Contact',
				'url' => $url->generate('home') . '#contact'
			]
		];

		$this->view->data->offsetSet('timeExperience', (date('Y', time()) - date('Y', 1265014800)) + 1); // Mon, 01 Feb 2010 09:00:00 GMT;
		$this->view->data->offsetSet('googleAnalyticsTrackingId', 1);
		$this->view->data->offsetSet('projects', $projects);
		$this->view->data->offsetSet('skills', $skills);
		$this->view->data->offsetSet('menuPrimary', $menuPrimary);
		$this->view->data->offsetSet('siteTitle', 'Martin Wyatt');;
		$this->view->data->offsetSet('metaTitle', 'Martin Wyatt - Web Developer Lancashire');
		$this->view->data->offsetSet('metaDescription', 'I work at AV Distribution as a Web Developer. I spend my days designing and implementing web interfaces. I am very dedicated to my craft with 7 years experience.');

		return $this->response($this->view->getTemplate('index'));
	}


	public function serverError(\Exception $exception)
	{
		$code = 500;
		$this->view->data->offsetSet('title', 'Server Error');
		$this->view->data->offsetSet('code', $code);
		$this->view->data->offsetSet('message', 'Server error: ' . $exception->getMessage());
		return $this->response($this->view->getTemplate('error.bundle'), $code);
	}


	public function notFound()
	{		
		$code = 404;
		$this->view->data->offsetSet('title', 'Not Found');
		$this->view->data->offsetSet('code', $code);
		$this->view->data->offsetSet('message', 'Unable to find the page you were looking for. Please return <a href="' . $this->get('Url')->generate('home') . '">home</a>.');
		return $this->response($this->view->getTemplate('error.bundle'), $code);
	}
}
