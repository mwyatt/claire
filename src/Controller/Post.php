<?php

namespace Mwyatt\Portfolio\Controller;

class Post extends \Mwyatt\Portfolio\Controller
{


	public function single($request) {
		$slug = $request->getUrlVar('slug');
		$postService = $this->get('Post');
		$post = $postService->getBySlugPublished($slug);
        $markdown = $this->get('Markdown');

		if (!$post) {
			return $this->notFound();
		}

        $contentHtml = $markdown::defaultTransform($post->get('content'));
		$this->view->data->offsetSet('contentHtml', $contentHtml);
		$this->view->data->offsetSet('post', $post);
		return $this->response($this->view->getTemplate('post/single.bundle'));
	}
}
