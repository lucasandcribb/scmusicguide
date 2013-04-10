<?php
/**
 * @category	Helper
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

//require_once (COMMUNITY_COM_PATH.DS.'models'.DS.'videos.php');

/**
 * Class to manipulate data from Daily Motion
 * 	 	
 * @access	public  	 
 */
class LBGalleryVideoYoutube{
	var $xmlContent = null;
	var $url = '';
	private $_items = array();
	/**
	 * Return feedUrl of the video
	 */
	public function getFeedUrl()
	{
		return 'http://gdata.youtube.com/feeds/api/videos/' . $this->getId();
	}
	
	public function init($url, $videoType = 'video')
	{
		$this->url = $url;			
		if($videoType == 'video'){
			//echo $this->getFeedUrl();die();
			$this->xmlContent = file_get_contents($this->getFeedUrl());	
			$this->parseVideo();
		}else if($videoType == 'rss'){
			$this->xmlContent = file_get_contents($url);	
			$this->parseRSS();
		}
	}
	function parseVideo(){
		$item = new stdClass();
		// get title 
		$title = '';
		$pattern =  "/<title type='text'>(.*?)<\/title>/i";
		preg_match_all($pattern, $this->xmlContent, $matches);
		if($matches) $title = $matches[1][0];
		$item->title 		= $title;
		
		// get ID
		parse_str( parse_url( $this->url, PHP_URL_QUERY ), $result );
		$vID = $result['v'];
		
		// If we have no match, need to check for youtu.be address
		// which is the new youtbe share address
		if( empty($vID) )
		{
			$pattern    = "'youtu.be/([A-Za-z0-9-_]+)'s"; 
			preg_match($pattern, $this->url, $matches);
	  
			if($matches && !empty($matches[1]) ){
				$vID = $matches[1];
			}
		}
		$item->video_id		= $vID;
		
		// get description
		$description = '';		
		$pattern =  "/<content type='text'>(.*?)<\/content>/s";
		preg_match_all($pattern, $this->xmlContent, $matches);
		if($matches && !empty($matches[1][0]) )
		{
			$description = $matches[1][0];
		}
		$item->description 	= $description;			
		
		// get duration
		$duration = 0;
		$pattern =  "/seconds='(.+?)'/i";
		preg_match_all($pattern, $this->xmlContent, $matches);
		if($matches)
		{
			$duration = $matches[1][0];
		}
		$item->duration		= $duration;
		
		// get thumbnail
		$thumbnail = 'http://i.ytimg.com/vi/'.$vID.'/0.jpg';
		//$thumbnail = 'http://img.youtube.com/vi/' . $vID . '/default.jpg';
		$item->thumbnail	= $thumbnail;
		
		// get link		
		$item->link			= $this->url;
		
		$this->_items[] = $item;
	}
	function parseRSS(){
		$pattern = "/<item>(.*)<\/item>/isxmU";
		preg_match_all($pattern, $this->xmlContent, $matches);
		if($matches && !empty($matches[1])){
			$this->raw = $matches[0];
			for($i = 0, $n = count($matches[1]); $i < $n; $i++){				
				
				$item = new stdClass();
				$item->title 		= $this->_getTitle($i);
				$item->video_id		= $this->_getId($i);
				$item->description 	= $this->_getDescription($i);
				$item->duration		= $this->_getDuration($i);
				$item->thumbnail	= 'http://i.ytimg.com/vi/'.$item->video_id.'/0.jpg';//$this->_getThumbnail($i);
				$item->link			= $this->_getLink($i);
				
				$this->_items[] = $item;				
			}
		}
		//echo '<pre>';print_r($this->raw);echo '</pre>';
		return $this->_items;
	}
	private function _getTitle($i){
		$title = '';
		$pattern = "/<title>(.*)<\/title>/";
		preg_match_all($pattern, $this->raw[$i], $matches);
		if($matches && !empty($matches[1][0]))
			$title = $matches[1][0];
			
		return $title;
	}
	private function _getId($i){
		$code = '';
		$pattern    = "'youtube(.*)watch(\?&?v=|#!v=)+([A-Za-z0-9-_]+)'s"; 
		preg_match($pattern, $this->raw[$i], $matches);
  
		if($matches && !empty($matches[3]) ){
			$code = $matches[3];
		}
		
		// If we have no match, need to check for youtu.be address
		// which is the new youtbe share address
		if( empty($code) )
		{
			$pattern    = "'youtu.be/([A-Za-z0-9-_]+)'s"; 
			preg_match($pattern, $this->raw[$i], $matches);
	  
			if($matches && !empty($matches[1]) ){
				$code = $matches[1];
			}
		}
			
		return $code;
	}
	private function _getDescription($i){
		
		$description = '';
		// Store description
		$pattern =  "/&lt;td.*&gt;(.*)&lt;\/td&gt;/isxmU";
		preg_match_all($pattern, $this->raw[$i], $matches);
		
		if( $matches && !empty($matches[0][1]) ){
			$description = trim(strip_tags($matches[0][1],'<br /><br>'));
			$pattern =  "/&lt;div.*&gt;(.*)&lt;\/div&gt;/isxmU";
			preg_match_all($pattern, $description, $matches);
			if($matches && !empty($matches[1][1])){
				$description = strip_tags(html_entity_decode($matches[1][1]));
			}// '<pre>';print_r($matches);echo '</pre>';
		}
		
		return $description;
	}
	private function _getDuration($i){
		$duration = '';
		// Store duration
		$pattern =  "/&lt;td.*&gt;(.*)&lt;\/td&gt;/isxmU";	 
		preg_match_all($pattern, $this->raw[$i], $matches);
		//echo '<pre>';print_r($matches);echo '</pre>';
		if( $matches && !empty($matches[0][3]) )
		{
            $duration   = $matches[0][3];
			$pattern =  "/&lt;span.*&gt;(.*)&lt;\/span&gt;/isxmU";
			preg_match_all($pattern, $duration, $matches);
			if($matches && !empty($matches[0][1])){
				$duration = strip_tags(html_entity_decode( $matches[0][1]));
				$time = explode(':', $duration);
				$duration = ((int)$time[0])*60+$time[1];
			}
		}
			
		return $duration;
	}
	private function _getThumbnail($i){
		$thumbnail = '';
		$pattern = '/&lt;img.*src=\"(.*)\"&gt;/iU';
		preg_match_all($pattern, $this->raw[$i], $matches);
		//echo '<pre>';print_r($matches);echo '</pre>';
		if( $matches && !empty($matches[1][0]) )
		{
            $thumbnail   = $matches[1][0];
		}
			
		return $thumbnail;
	}
	private function _getLink($i){
		$link = '';
		$pattern = '/<link>(.*)<\/link>/';
		preg_match_all($pattern, $this->raw[$i], $matches);
		//echo '<pre>';print_r($matches);echo '</pre>';
		if( $matches && !empty($matches[1][0]) )
		{
            $link   = $matches[1][0];
		}
			
		return $link;
	}
	function getItems(){
		return $this->_items;
	}
	public function setFeed(){
	
	}
	
	/*
	 * Return true if successfully connect to remote video provider
	 * and the video is valid
	 */	 
	public function isValid()
	{
		// Connect and get the remote video
		//CFactory::load('helpers', 'remote');
		$this->xmlContent = file_get_contents($this->getFeedUrl());//CRemoteHelper::getContent($this->getFeedUrl());
		$videoId = $this->getId();
		if (empty($videoId))
		{
			//$this->setError( JText::_('COM_COMMUNITY_VIDEOS_INVALID_VIDEO_ID_ERROR') );
			return false;
		}
		if($this->xmlContent == FALSE)
		{
			//$this->setError( JText::_('COM_COMMUNITY_VIDEOS_FETCHING_VIDEO_ERROR') );
			return false;
		}
		
		return true;
	}	
	
	/**
	 * Extract DailyMotion video id from the video url submitted by the user
	 * 	 	
	 * @access	public
	 * @param	video url
	 * @return videoid	 
	 */
	public function getId()
	{
        parse_str( parse_url( $this->url, PHP_URL_QUERY ), $result );
		$code = $result['v'];
		
		// If we have no match, need to check for youtu.be address
		// which is the new youtbe share address
		if( empty($code) )
		{
			$pattern    = "'youtu.be/([A-Za-z0-9-_]+)'s"; 
			preg_match($pattern, $this->url, $matches);
	  
			if($matches && !empty($matches[1]) ){
				$code = $matches[1];
			}
		}
		return $code;
	}
	                                 
	
	/**
	 * Return the video provider's name
	 * 
	 */
	public function getType()
	{
		return 'youtube';
	}
	
	public function getTitle()
	{
		$title = '';		
		// Store video title
		$pattern =  "/<h1 class=\"dmco_title\">(.*)(<\/h1>)?(<\/span>)/i";
		preg_match_all($pattern, $this->xmlContent, $matches);

		if( $matches && !empty($matches[1][0]) )
		{
			$title = strip_tags($matches[1][0]);
		}
		
		return $title;
	}
	
	public function getDescription()
	{
		$description = '';
		// Store description
		$pattern =  "/<meta name=\"description\" lang=\"en\" content=\"(.*)\" \/>/i";
		preg_match_all($pattern, $this->xmlContent, $matches);
		
		if( $matches && !empty($matches[1][0]) )
		{
			$description = trim(strip_tags($matches[1][0],'<br /><br>'));
		}
		
		return $description;
	}
	
	public function getDuration()
	{
		$duration = '';
		// Store duration
		$pattern =  "'DMDURATION=(.*?)&'s";			 
		preg_match_all($pattern, $this->xmlContent, $matches);
	
		if( $matches && !empty($matches[1][0]) )
		{
            $duration   = $matches[1][0];
		}
			
		return $duration;
	}
	
	/**
	 * Get video's thumbnail URL from videoid
	 * 
	 * @access 	public
	 * @param 	videoid
	 * @return url
	 */
	public function getThumbnail()
	{
		$thumbnail = '';

		$pattern =  "'<link rel=\"image_src\" type=\"image/jpeg\" href=\"(.*?)\"'s"; 
		preg_match_all($pattern, $this->xmlContent, $matches);
	
		if( $matches && !empty($matches[1][0]) )
		{					
			$thumbnail = urldecode($matches[1][0]);			
		}

		return $thumbnail;
	}
	
	/**
	 * 
	 * 
	 * @return $embedvideo specific embeded code to play the video
	 */
	public function getViewHTML($videoId, $videoWidth, $videoHeight, $iframe = true)
	{
		
		if (!$videoId)
		{
			$videoId	= $this->getId();
		}

		$html = '';
		if($iframe)
		{
			// Use new iframe embed method
			$html = '<iframe class="youtube-player" type="text/html" width="'.$videoWidth.'" height="'.$videoHeight.'" src="http://www.youtube.com/embed/'.$videoId.'" frameborder="0">
				</iframe>';
		}
		else
		{
			$html = "<embed src=\"http://www.youtube.com/v/" .$videoId. "&hl=en&fs=1&hd=1&showinfo=0&rel=0\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"".$videoWidth."\" height=\"".$videoHeight. "\" wmode=\"transparent\"></embed>";
		}
		
		return $html;
	}
	                    
	public function getEmbedCode($videoId, $videoWidth, $videoHeight)
	{
		return $this->getViewHTML($videoId, $videoWidth, $videoHeight);
	}
}
