<?php

namespace OriginalAppName\Admin\Controller\Ajax;

use OriginalAppName;
use OriginalAppName\Helper;
use OriginalAppName\Admin\Service;
use OriginalAppName\Session;
use OriginalAppName\Model;
use OriginalAppName\Site\Elttl\Model\Tennis as TennisModel;
use OriginalAppName\Response;
use \Exception;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends \OriginalAppName\Admin\Controller\Ajax
{


    /**
     * takes a normal title and returns a unique slug by looking at all other
     * content
     * @return string
     */
    public function generateSlug()
    {
        if (! isset($_REQUEST['title'])) {
            throw new Exception;
        }
        $friendlyTitle = \OriginalAppName\Helper::slugify($_REQUEST['title']);
        $ouput = $friendlyTitle;
        $modelContent = new Model\Content;
        $modelContent->readColumn('slug', $friendlyTitle);
        if ($modelContent->getData()) {
            $ouput = $friendlyTitle . '-2';
        }

        // output
        return new Response(json_encode($friendlyTitle));
    }


    public function generateTableSlugs()
    {
        exit('take the safety off first');
        $model = new TennisModel\Player;
        $model->read();
        foreach ($model->getData() as $entity) {
            // needs to be unfilled
            if (! $entity->slug) {
                $entity->slug = \OriginalAppName\Helper::slugify($entity->nameFirst . '-' . $entity->nameLast);
                $model->update([$entity]);
            }
        }
        exit('updated all table slugs');
    }
}
