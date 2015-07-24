<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Front
{


    public function home()
    {
        $modelAd = new \OriginalAppName\Model\Ad;
        $modelAd->readColumn('\'group\'', 'small');
        $this->view->setDataKey('ads', $modelAd->getData());
        $modelAd->readColumn('\'group\'', 'home-cover');
        $this->view->setDataKey('covers', $modelAd->getData());

        // content
        $modelContent = new \OriginalAppName\Model\Content;
        $modelContent
            ->readType('press')
            ->filterStatus(\OriginalAppName\Entity\Content::STATUS_PUBLISHED)
            ->orderByProperty('timePublished', 'desc')
            ->limitData([0, 3]);

        // year
        $registry = \OriginalAppName\Registry::getInstance();
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        $modelYear->readId([$registry->get('database/options/yearId')]);
        $this->view->setDataKey('year', $modelYear->getDataFirst());

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
