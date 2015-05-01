<?php

namespace OriginalAppName\Site\Claire\Controller;

use OriginalAppName\Entity;
use OriginalAppName\Response;
use OriginalAppName\Json;
use OriginalAppName\Google\Analytics\Campaign;
use OriginalAppName\Model;
use OriginalAppName\View;
use OriginalAppName\Service;



/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Front
{


	public function home() {
		$entityManager = $this->getEntityManager();

		$content = new Entity\Content();
		$content
			->setTitle('title')
			->setSlug('Slug')
			->setHtml('Html')
			->setType('Type')
			->setTimePublished(time())
			->setUserId(1)
			->setStatus(Entity\Content::STATUS_UNPUBLISHED);
		$entityManager->persist($content);
		$entityManager->flush();
exit;
		$repository = $entityManager->getRepository('\OriginalAppName\Entity\Content');
		$content = $repository->findAll();
		
		foreach ($content as $cont) {
			echo '<pre>';
			print_r($cont->getUser()->getEmail());
			echo '</pre>';
			exit;
			
		}
		
exit;




exit('ok');

		// latest 3 posts
		$modelContent = new model_content($this);
		$modelContent->read(array(
			'where' => array(
				'type' => 'post',
				'status' => 'visible'
			),
			'limit' => array(0, 6),
			'order_by' => 'time_published desc'
		));
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');
		$modelContent->bindUser();
		$this->view->setDataKey('contents', $modelContent->getData());
		$this->view->getTemplate('home');
		


		
		$serviceContent = new Service\Content;
		$entitiesProject = $serviceContent->readType('project');
		shuffle($entitiesProject);

		// skills
		$json = new Json();
		$json->read('skills');
		$skills = $json->getData();

		// template
		$this
			->view
			->setDataKey('templateName', 'home')
			->setDataKey('skills', $skills)
			->setDataKey('projects', $entitiesProject);
		return new Response($this->view->getTemplate('home'));
	}


	public function search()
	{
		if (! isset($_REQUEST['query'])) {
			return new Response('', 404);
		}
	    return new Response('you are searching for: ' . $_REQUEST['query']);
	}
}
