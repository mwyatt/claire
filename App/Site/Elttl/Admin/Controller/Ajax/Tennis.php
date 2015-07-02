<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Ajax;

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
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Tennis extends \OriginalAppName\Admin\Controller\Ajax
{


	public function generateTableSlugs()
	{
		exit('take the safety off first');
		$model = new TennisModel\Player; // manually change this
		$model->read();
		foreach ($model->getData() as $entity) {

			// needs to be unfilled
			if (! $entity->slug) {
				$entity->slug = Helper::slugify($entity->nameFirst . '-' . $entity->nameLast);
				$model->update($entity, ['id' => $entity->id]);
			}
		}
		exit('updated all table slugs');
	}
}
