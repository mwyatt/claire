<?php

namespace Mwyatt\Claire\Mapper;

class Post extends \Mwyatt\Core\MapperAbstract implements \Mwyatt\Core\MapperInterface
{


    public function getModel()
    {
        return '\\Mwyatt\\Claire\\Model\\Post';
    }


    public function findBySlug($slug)
    {
        $sql = ['select', '*', 'from', $this->table, 'where', 'slug', '=', '?'];
        $this->database->prepare(implode(' ', $sql));
        $this->database->execute([$slug]);
        return $this->getIterator($this->database->fetchAll($this->fetchType, '\\Mwyatt\\Claire\\Model\\Post'));
    }


    public function findBySlugPublished($slug)
    {
        $className = $this->getModel();
        $post = new $className;

        $sql = ['select', '*', 'from', $this->table, 'where', 'slug', '=', '?'];
        $sql[] = 'and status = ' . $post->getStatusPublished();
        $this->database->prepare(implode(' ', $sql));
        $this->database->execute([$slug]);
        return $this->getIterator($this->database->fetchAll($this->fetchType, '\\Mwyatt\\Claire\\Model\\Post'));
    }


    public function findAll()
    {
        $sql = ['select', '*', 'from', $this->table];
        $this->database->prepare(implode(' ', $sql));
        $this->database->execute();
        return $this->getIterator($this->database->fetchAll($this->fetchType, '\\Mwyatt\\Claire\\Model\\Post'));
    }


    public function insert(\Mwyatt\Core\Model\Post $post)
    {
        $sql = ['insert', 'into', $this->table, '('];
        $sql[] = implode(', ', [
            '`title`',
            '`slug`',
            '`content`',
            '`timeCreated`',
            '`timePublished`',
            '`status`'
        ]);
        $sql[] = ') values (';
        $sql[] = implode(', ', ['?', '?', '?', '?', '?', '?']);
        $sql[] = ');';

        $this->database->prepare(implode(' ', $sql));
        $this->database->execute([
            $post->get('title'),
            $post->get('slug'),
            $post->get('content'),
            $post->get('timeCreated'),
            $post->get('timePublished'),
            $post->get('status')
        ]);

        return $this->database->getLastInsertId();
    }


    public function findColumn($values, $column = 'id')
    {
        $results = [];
        $sqlParams = [];

        $sql = ['select', '*', 'from', $this->table, 'where', $column, '='];

        foreach ($values as $value) {
            $sqlParams[] = '?';
        }
        $sql[] = implode(', ', $sqlParams);

        $this->database->prepare(implode(' ', $sql));

        $this->database->execute($values);

        return $this->getIterator($this->database->fetchAll($this->fetchType, $this->getModel()));
    }


    public function updateById(\Mwyatt\Core\Model\Post $post)
    {
        $sql = ['update', '`post`', 'set'];

        $sql[] = "`title` = ?,";
        $sql[] = "`slug` = ?,"; 
        $sql[] = "`content` = ?,";
        $sql[] = "`timeCreated` = ?,";
        $sql[] = "`timePublished` = ?,";
        $sql[] = "`status` = ?";
        $sql[] = 'where `id` = ?';
        
        $this->database->prepare(implode(' ', $sql));
        $this->database->execute([
            $post->get('title'),
            $post->get('slug'),
            $post->get('content'),
            $post->get('timeCreated'),
            $post->get('timePublished'),
            $post->get('status'),
            $post->get('id')
        ]);

        return $this->database->getRowCount();
    }


    public function deleteById($id)
    {
        $sql = ['delete', 'from', $this->table, 'where id = ?'];

        $this->database->prepare(implode(' ', $sql));
        $this->database->execute([$id]);

        return $this->database->getRowCount();
    }
}
