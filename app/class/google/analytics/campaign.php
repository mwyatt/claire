<?php 


/**
 * handles easy output of a google analytics campaign url
 */
class Google_Analytics_Campaign
{


	/**
	 * utm_campaign: The individual campaign name, slogan, promo code, etc. for a product.
	 * @var string
	 */
	public $campaign;


	/**
	 * utm_source: Identify the advertiser, site, publication, etc.
	 * that is sending traffic to your property, e.g. google, citysearch, 
	 * newsletter4, billboard.
	 * @var string
	 */
	public $source;


	/**
	 * utm_medium: The advertising or marketing medium, e.g.: cpc, referral,
	 * email.
	 * @var string
	 */
	public $medium;


	/**
	 * utm_term: Identify paid search keywords. If you're manually tagging
	 * paid keyword campaigns, you should also use utm_term to specify the 
	 * keyword.
	 * @var string
	 */
	public $term;


	/**
	 * utm_content: Used to differentiate similar content, or links within the 
	 * same ad. For example, if you have two call-to-action links within the 
	 * same email message, you can use utm_content and set different values 
	 * for each so you can tell which version is more effective.
	 * @var string
	 */
	public $content;


	/**
	 * auto create on instanciate
	 * @param array $config see create
	 */
	function __construct($config = array())
	{
		$this->create($config);
	}


	/**
	 * sets up campaign vars, modifiable later on if multiple campaigns
	 * @param array $config campaign, source, medium
	 * @return null         
	 */
	public function create($config = array())
	{
		if (
			empty($config['campaign'])
			|| empty($config['source'])
			|| empty($config['medium'])
		) {
			return;
		}
		$this->setCampaign($config['campaign']);
		$this->setSource($config['source']);
		$this->setMedium($config['medium']);
	}


	/**
	 * get a url formatted with a campain get variables
	 * @param  string $url     existing url
	 * @param  string $content label of specific campain element
	 * @param  string $prepend unset by user
	 * @return string          
	 */
	public function get($url, $content = '', $prepend = '?')
	{
		if (strpos($url, '?')) {
			$prepend = '&';
		}
		$parts = array(
			'utm_campaign' => $this->getCampaign(),
			'utm_source' => $this->getSource(),
			'utm_medium' => $this->getMedium(),
		);
		if ($content) {
			$parts['utm_content'] = $content;
		}
		return $url . $prepend . http_build_query($parts);
	}


	/**
	 * @return string 
	 */
	public function getMedium() {
	    return $this->medium;
	}
	
	
	/**
	 * @param string $medium 
	 */
	public function setMedium($medium) {
	    $this->medium = urlencode($medium);
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getSource() {
	    return $this->source;
	}
	
	
	/**
	 * @param string $source 
	 */
	public function setSource($source) {
	    $this->source = urlencode($source);
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getCampaign() {
	    return $this->campaign;
	}
	
	
	/**
	 * @param string $campaign 
	 */
	public function setCampaign($campaign) {
	    $this->campaign = urlencode($campaign);
	    return $this;
	}
}
