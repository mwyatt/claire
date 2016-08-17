<?php

namespace Mwyatt\Claire;

class Controller extends \Mwyatt\Core\Controller
{


	public function home() {
		$menuPrimary = [
			(object) [
				'name' => 'Home',
				'url' => ''
			],
			(object) [
				'name' => 'About me',
				'url' => 'page/about-me/'
			]
		];

		$this->view->data->offsetSet('timeExperience', (date('Y', time()) - date('Y', 1265014800)) + 1); // Mon, 01 Feb 2010 09:00:00 GMT;
		$this->view->data->offsetSet('googleAnalyticsTrackingId', 1);
		$this->view->data->offsetSet('menuPrimary', $menuPrimary);
		$this->view->data->offsetSet('siteTitle', 'Martin Wyatt');
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
