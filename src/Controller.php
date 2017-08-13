<?php

namespace Mwyatt\Claire;

class Controller extends \Mwyatt\Core\Controller
{


	public function home() {
		$servicePost = $this->get('Post');
		$posts = $servicePost->findAll();

		$this->view->data->offsetSet('posts', $posts);
		return $this->response($this->view->getTemplate('home'));
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
