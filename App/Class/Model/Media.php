<?php


/**
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Model_Media extends Model
{
	

	public $fields = array(
		'id'
		, 'title'
		, 'description'
		, 'path'
		, 'type'
		, 'time_published'
		, 'user_id'
	);



	/**
	 * appends thumbnail information if it is an image
	 * @todo port to view
	 * @param array $result modified row
	 */
	public function getMediaThumb($result)
	{
		if ($result->type != 'application/pdf') {
			$result->thumb = new stdClass();
			$result->thumb->{'300'} = $this->url->build(array('thumb/?src=' . $this->url->getCache('base') . $result->path . '&w=300&h=130'), false);
			$result->thumb->{'150'} = $this->url->build(array('thumb/?src=' . $this->url->getCache('base') . $result->path . '&w=150&h=120'), false);
			$result->thumb->{'350'} = $this->url->build(array('thumb/?src=' . $this->url->getCache('base') . $result->path . '&w=350&h=220'), false);
			$result->thumb->{'760'} = $this->url->build(array('thumb/?src=' . $this->url->getCache('base') . $result->path . '&w=760&h=540'), false);
		}
		return $result;
	}

}
