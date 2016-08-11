<?php

namespace Mwyatt\Claire\Service;

class Post extends \Mwyatt\Core\ServiceAbstract
{


    protected $posts;


    public function getBySlug($slug)
    {
        $postMapper = $this->mapperFactory->get('Post');
        $posts = $postMapper->findBySlug($slug);
        return $posts->current();
    }


    public function getBySlugPublished($slug)
    {
        $postMapper = $this->mapperFactory->get('Post');
        $posts = $postMapper->findBySlugPublished($slug);
        return $posts->current();
    }


    public function getById($id)
    {
        $postMapper = $this->mapperFactory->get('Post');
        $posts = $postMapper->findColumn([$id], 'id');
        return $posts->current();
    }


    public function getComments()
    {
        // could get comments and store in current postmodels?
    }


    public function getAll()
    {
        $postMapper = $this->mapperFactory->get('Post');
        return $postMapper->findAll();
    }


    public function getModel()
    {
        $postMapper = $this->mapperFactory->get('Post');
        $className = $postMapper->getModel();
        return new $className;
    }


    public function persist(\Mwyatt\Core\Model\Post $post)
    {
        $postMapper = $this->mapperFactory->get('Post');

        if ($post->get('id')) {
            return $postMapper->updateById($post);
        } else {
            return $postMapper->insert($post);
        }
    }


    public function delete(\Mwyatt\Core\Model\Post $post)
    {
        $postMapper = $this->mapperFactory->get('Post');
        $postMapper->deleteById($post->get('id'));
    }
}
