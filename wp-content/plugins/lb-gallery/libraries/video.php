<?php
class LBGalleryVideo{
	public function __construct(){
	
	}
	public function getProvider($videoLink, $videoType = 'video'){
		$providerName	= 'invalid';		
		if (! empty($videoLink)){
			$origvideolink = $videoLink;
			//if it using https
            $videoLink	= str_ireplace( 'https://' , 'http://' , $videoLink );
			$videoLink	= str_ireplace( 'http://' , '' , $videoLink );
			if($videoLink === $origvideolink) $videoLink = str_ireplace( 'http://' , '' , $videoLink );					
			$videoLink = 'http://'. $videoLink;
			$parsedLink = parse_url( $videoLink );
			
			//$videoLink	= 'http://'.CString::str_ireplace( 'http://' , '' , $videoLink );
			//$parsedLink	= parse_url($videoLink);
			
			preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $parsedLink['host'], $matches);
			
			if ( !empty($matches['domain']))
			{
				//$this->setError(JText::_('COM_COMMUNITY_VIDEOS_INVALID_VIDEO_URL_ERROR'));
				//return false;
				
				$domain		= $matches['domain'];
				$provider		= explode('.', $domain);
				$providerName	= strtolower($provider[0]);
				
				// For youtube, they might be using youtu.be address
				if($domain == 'youtu.be')
				{
					$providerName = 'youtube';
				}
			}
					
		} 
		//echo $providerName;
		
		$libraryPath = LBGAL_LIBS.'/video/'.$providerName.'.php';
		if (!file_exists($libraryPath)){
			return false;
			$providerName	= 'invalid';
			$libraryPath	= JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'videos'.DS.'invalid.php';
		}
		
		require_once($libraryPath);
		$className	= 'LBGalleryVideo' . ucfirst($providerName);
		$table		= new $className();
		$table->init($videoLink, $videoType);

		return $table;
	}
}