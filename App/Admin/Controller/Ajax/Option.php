<?php

namespace OriginalAppName\Admin\Controller\Ajax;

use OriginalAppName;
use OriginalAppName\Admin\Service;
use OriginalAppName\Entity;
use OriginalAppName\Session;
use OriginalAppName\Model;
use OriginalAppName\Response;

/**
 * untested
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Option extends \OriginalAppName\Admin\Controller\Ajax
{


    public function read()
    {

        // resource
        $modelOption = new Model\Option;

        // action
        $modelOption->read();

        // output
        return new Response(json_encode($modelOption->getData()));
    }


    public function create()
    {

        // validate
        if (! isset($_REQUEST['name']) || ! isset($_REQUEST['value'])) {
            throw new Exception;
        } elseif (! $_REQUEST['name'] || ! $_REQUEST['value']) {
            throw new Exception;
        }

        // resource
        $modelOption = new Model\Option;
        $entityOption = new Entity\Option;

        // action
        $entityOption->consumeArray($_REQUEST);
        $modelOption
            ->create([$entityOption])
            ->readId($modelOption->getLastInsertIds());

        // output
        return new Response(json_encode($modelOption->getDataFirst()));
    }


    public function delete()
    {

        // validate
        if (! isset($_REQUEST['id'])) {
            throw new Exception;
        }

        // resource
        $modelOption = new Model\Option;
        $entitiesOption = $modelOption
            ->readId([$_REQUEST['id']])
            ->getData();

        // action
        $modelOption->delete($entitiesOption);

        // output
        return new Response(json_encode($modelOption->getRowCount()));
    }


    public function update()
    {
        
        // validate
        if (! isset($_REQUEST['id']) || ! isset($_REQUEST['name']) || ! isset($_REQUEST['value'])) {
            throw new Exception;
        }

        // resource
        $modelOption = new Model\Option;
        $entityOption = new Entity\Option;

        // action
        $entityOption->consumeArray($_REQUEST);
        $modelOption->update([$entityOption]);
            ;

        // validate it happend
        if (! $modelOption->getRowCount()) {
            throw new Exception;
        }

        // output
        $modelOption->readId([$_REQUEST['id']]);
        return new Response(json_encode($modelOption->getDataFirst()));
    }
}
