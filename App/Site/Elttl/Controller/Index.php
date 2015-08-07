<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Site\Elttl\Controller\Front
{


    public function home()
    {
        $modelAd = new \OriginalAppName\Model\Ad;
        $modelAd->readColumn('groupKey', 'small');
        $this->view->setDataKey('ads', $modelAd->getData());
        $modelAd->readColumn('groupKey', 'home-primary');
        $this->view->setDataKey('covers', $modelAd->getData());

        // content
        $modelContent = new \OriginalAppName\Model\Content;
        $modelContent
            ->readType('press')
            ->filterStatus(\OriginalAppName\Entity\Content::STATUS_PUBLISHED)
            ->orderByProperty('timePublished', 'desc')
            ->limitData([0, 3]);

        // gallery
        $folder = glob(SITE_PATH . 'asset' . DS . 'media' . DS . 'thumb' . DS . '*');
        $files = [];
        foreach ($folder as $filePath) {
            $filePath = str_replace(BASE_PATH, '', $filePath);
            $files[] = str_replace(DS, US, $filePath);
        }

        // template
        $this
            ->view
            ->setDataKey('galleryPaths', $files)
            ->setDataKey('contents', $modelContent->getData());
        return new \OriginalAppName\Response($this->view->getTemplate('home'));
    }
}
