<?php

namespace Mwyatt\Claire\Model;

class Post extends \Mwyatt\Core\ModelAbstract
{


    protected $id;
    protected $title;
    protected $slug;
    protected $content;
    protected $timeCreated;
    protected $timePublished;
    protected $status = self::STATUS_HIDDEN;
    protected $comments;

    const STATUS_HIDDEN = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_DELETED = 2;

    
    public function getStatusHidden()
    {
        return $this::STATUS_HIDDEN;
    }


    public function getStatusPublished()
    {
        return $this::STATUS_PUBLISHED;
    }


    public function getStatusDeleted()
    {
        return $this::STATUS_DELETED;
    }


    public function getStatusText()
    {
        $statuses = $this->getStatuses();
        $status = $this->status;
        return isset($statuses[$status]) ? $statuses[$status] : 'Unknown';
    }


    public function getStatuses()
    {
        return [
            $this->getStatusHidden() => 'Hidden',
            $this->getStatusPublished() => 'Published'
        ];
    }


    public function setTitle($value)
    {
        \Assert\Assertion::string($value);
        \Assert\Assertion::betweenLength($value, 5, 255);
        $this->title = $value;
    }


    public function setContent($value)
    {
        \Assert\Assertion::string($value);
        $this->content = $value;
    }


    public function setSlug($value)
    {
        \Assert\Assertion::string($value);
        \Assert\Assertion::betweenLength($value, 5, 255);
        $this->slug = $value;
    }


    public function setTimeCreated($value)
    {
        if ($this->timeCreated) {
            return;
        }

        \Assert\Assertion::integer($value);
        $this->timeCreated = $value;
    }


    public function setTimePublished($value)
    {
        if ($this->timePublished) {
            return;
        }

        \Assert\Assertion::integer($value);
        $this->timePublished = $value;
    }


    public function setStatus($value)
    {
        if (!array_key_exists($value, $this->getStatuses())) {
            throw new \Assert\AssertionFailedException;
        }
        \Assert\Assertion::integerish($value);
        $this->status = $value;
    }
}
