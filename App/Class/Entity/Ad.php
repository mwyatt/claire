<?php

namespace OriginalAppName\Entity;

/**
 * @Entity @Table(name="ad")
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Ad extends \OriginalAppName\Entity
{


    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    public $id;


    /**
     * @Column(type="string")
     * @var string
     */
    public $title;


    /**
     * @Column(type="string")
     * @var string
     */
    public $description;


    /**
     * relative url to featured image / artwork
     * @Column(type="string")
     * @var string
     */
    public $image;

    
    /**
     * relative pointer to content
     * @Column(type="string")
     * @var string
     */
    public $url;


    /**
     * button which does something to confirm
     * @Column(type="string", length=50)
     * @var string
     */
    public $action;


    /**
     * time the ad was created epoch
     * @var int
     */
    public $timeCreated;


    /**
     * ties together ads
     * @Column(type="string", length=50)
     * @var string
     */
    public $groupKey;


    /**
     * @var int
     */
    public $status = self::STATUS_HIDDEN;


    /**
     * do not show on frontend
     */
    const STATUS_HIDDEN = 0;


    /**
     * show on frontend
     */
    const STATUS_PUBLISHED = 1;


    public function getStatusText()
    {
        $statuses = self::getStatuses();
        $status = $this->status;
        return isset($statuses[$status]) ? $statuses[$status] : 'Unknown';
    }


    public static function getStatuses()
    {
        return [
            self::STATUS_HIDDEN => 'Hidden',
            self::STATUS_PUBLISHED   => 'Published'
        ];
    }
}
