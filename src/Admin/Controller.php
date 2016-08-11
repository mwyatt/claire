<?php

namespace Mwyatt\Portfolio\Admin;

class Controller extends \Mwyatt\Core\Controller
{


	public function home($request)
	{	
		$postService = $this->get('Post');
		$posts = $postService->getAll();

		$this->view->data->offsetSet('posts', $posts);
		return $this->response($this->view->getTemplate('admin/home.bundle'));
	}


	public function login($request)
	{
		$email = $request->getPost('email');
		$password = $request->getPost('password');
		$config = $this->get('Config');
		$loggedIn = $config['admin.email'] == $email && $config['admin.password'] == $password;

		if ($loggedIn) {
		    $request->setSession('admin.user', 1);
		}

		$this->redirect('admin.home');
	}


	public function logout($request)
	{
	    $request->setSession('admin.user', '');
		$this->redirect('admin.home');
	}
}
