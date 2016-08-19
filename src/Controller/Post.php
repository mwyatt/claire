<?php

namespace Mwyatt\Claire\Controller;

class Post extends \Mwyatt\Claire\Controller
{


	public function single($request) {
		$slug = $request->getUrlVar('slug');
		$postService = $this->get('Post');
		$post = $postService->getBySlugPublished($slug);

		if (!$post) {
			return $this->notFound();
		}

		$this->view->data->offsetSet('post', $post);
		return $this->response($this->view->getTemplate('post/single.bundle'));
	}
}
