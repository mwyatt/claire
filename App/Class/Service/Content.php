<?php

namespace OriginalAppName\Service;

use OriginalAppName\Model;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Content extends \OriginalAppName\Service
{


	/**
	 * single result based on slug
	 * @param  string $slug 
	 * @return object instance       
	 */
	public function readSlug($slug)
	{

		// resource
		$entitiesContent = [];
		$modelContent = new Model\Content();

		// read by slug
		$modelContent->readSlug($slug);
		if (! $modelContent->getData()) {
			return $this->getData();
		}

		// all meta for single
		$modelContentMeta = new Model\Content\Meta();
		$modelContentMeta->readId($modelContent->getDataProperty('id'), 'contentId');
		if (! $modelContentMeta->getData()) {
			return $this->setData($modelContent->getData());
		}

		// bind each content with its meta
		foreach ($modelContent->getData() as $entityContent) {
			foreach ($modelContentMeta->getData() as $entityContentMeta) {
				if ($entityContent->getId() == $entityContentMeta->getContentId()) {
					$entityContent->setMetaKey($entityContentMeta->getName(), $entityContentMeta->getValue());
				}
			}

			// store
			$entitiesContent[] = $entityContent;
		}

		// injected content with meta
		$this->setData($entitiesContent);
		return $this;
	}


	public function readType($type)
	{
		$entitiesContent = [];

		// all projects
		$modelContent = new Model\Content();
		$modelContent->readType($type);
		if (! $modelContent->getData()) {
			return $modelContent->getData();
		}

		// all meta
		$modelContentMeta = new Model\Content\Meta();
		$modelContentMeta->readId($modelContent->getDataProperty('id'), 'contentId');
		if (! $modelContentMeta->getData()) {
			return $modelContent->getData();
		}

		// bind each content with its meta
		foreach ($modelContent->getData() as $entityContent) {
			foreach ($modelContentMeta->getData() as $entityContentMeta) {
				if ($entityContent->getId() == $entityContentMeta->getContentId()) {
					$entityContent->setMetaKey($entityContentMeta->getName(), $entityContentMeta->getValue());
				}
			}

			// store
			$entitiesContent[] = $entityContent;
		}

		// injected content with meta
		return $entitiesContent;
	}
}
