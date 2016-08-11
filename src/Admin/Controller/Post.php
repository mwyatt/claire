<?php

namespace Mwyatt\Portfolio\Admin\Controller;

class Post extends \Mwyatt\Core\Controller
{


	public function single($request)
	{	
		$slug = $request->getUrlVar('slug');
		$postService = $this->get('Post');
		$post = $postService->getBySlug($slug);

		if (!$post) {
			$post = $postService->getModel();
		}

		$this->view->data->offsetSet('post', $post);
		return $this->response($this->view->getTemplate('admin/post/single.bundle'));
	}


	public function persist($request)
	{
		$id = $request->getPost('id');
		$postService = $this->get('Post');
		
		if ($id) {
			$post = $postService->getById($id);
		} else {
			$post = $postService->getModel();
		}

		$post->setTitle($request->getPost('title'));
		$post->setSlug($request->getPost('slug'));
		$post->setContent($request->getPost('content'));
		$post->setTimeCreated(time());
		$post->setStatus($request->getPost('status'));

		if ($post->get('status') == $post->getStatusPublished()) {
			$post->setTimePublished(time());
		}

		try {
			$postService->persist($post);
		} catch (Exception $e) {
			
		}

		$this->redirect('admin.post.single', ['slug' => $post->get('slug')]);
	}


	// public function delete($request)
	// {
	// 	$postService = $this->get('Post');
	// 	$post = $postService->getById($request->get('postId'))
	// 	$postService->persist($post)
	// }
}
