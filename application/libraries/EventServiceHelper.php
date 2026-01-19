<?php
require_once realpath(dirname(__FILE__) . '/google_library/vendor/autoload.php');   
define( 'BACKUP_FOLDER', 'SynPatAPI' );
define( 'BACKUP_FOLDERID', '0B-7JHq4pougDLTFhMS0ycVB1VHM' );
//define( 'BACKUP_FOLDER', 'Master Documents' );
define('PASTING_FOLDER','Opportunities');
define('OPERATIONS_FOLDER','OperationsAPI');
define('MASTER_FOLDER','Master DocumentsAPI');
define('MASTER_FOLDERID','0B-7JHq4pougDY25Bb2QtLWRLMTQ');
define('LEADS_FOLDERID','0B-7JHq4pougDaXEyQ3ItQUJQSWs');
define('INTERNAL_FOLDERID','0B-7JHq4pougDZU5hM2s5TFVmY0k');
define('NONACQUISITIONS_FOLDERID','0B-7JHq4pougDdHZiZjhPb1JUcFU');
define('SELLER_MATERIAL',"Seller's Sale Documents");
define( 'SHARE_WITH_GOOGLE_EMAIL', 'webmaster@synpat.com' );
define( 'SHARE_WITH_GOOGLE_EMAIL_ANOTHER', 'dymmyadsynpat@gmail.com' );
define( 'GOOGLE_EMAIL', 'leads@synpat.com' );
define( 'GOOGLE_EMAIL_NAME', 'Vivek Kapoor' );
$folderID = '0B-7JHq4pougDSE5UR2M0OGY3c00';
/*webmaster Backyard Project*/
define( 'CLIENT_ID',  '671429899926-tvqle2htej2bmq1q55k2tnr1dpf3k5g2.apps.googleusercontent.com' );
define( 'SERVICE_ACCOUNT_NAME', '671429899926-tvqle2htej2bmq1q55k2tnr1dpf3k5g2@developer.gserviceaccount.com' );
define( 'KEY_PATH', realpath(dirname(__FILE__) . '/Backyard Project-bef3d9642631.p12'));
/*webmaster Backyard Production*/
define( 'CLIENT_SECRET', realpath(dirname(__FILE__) . '/client_secret_1036285537673-l8gak1un7a18ql6bq9s3i6uag5umit7b.apps.googleusercontent.com.json'));
define( 'CLIENT_SERVICE_ACCOUNT', realpath(dirname(__FILE__) . '/round-bloom-788-71d608e6a9d7.json'));
define( 'CLIENT_SECRET_IONIC', realpath(dirname(__FILE__) . '/client_secret_ionic_1036285537673-l8gak1un7a18ql6bq9s3i6uag5umit7b.apps.googleusercontent.com.json'));
/*define( 'TOKEN_SERVICE_PATH', realpath(dirname(__FILE__) . '/token_service.json'));*/
define( 'TOKEN_SERVICE_PATH', '/var/www/synpat/backyard/application/libraries/token_service.json');

class EventServiceHelper{
	private $_service;
	
	protected $scope = array('https://www.googleapis.com/auth/calendar','https://www.googleapis.com/auth/calendar.readonly');
	
	private $_client;
	
	public function __construct() {
		$this->_client = new Google_Client();
		$this->_client->setAuthConfig(CLIENT_SERVICE_ACCOUNT);
		try{
			/*if (file_exists(TOKEN_SERVICE_PATH)) {
				$getContent = file_get_contents(TOKEN_SERVICE_PATH);
				if($getContent != ""){
					$accessToken = json_decode($getContent, true);
					$this->_client->setAccessToken($accessToken['access_token']);
					if ($this->_client->refreshTokenWithAssertion()) {
						$this->_client->fetchAccessTokenWithAssertion($this->_client->getAccessToken());
					}
				} else {
					$this->generateToken();
				}
				
			} else {
				$this->generateToken();
				//file_put_contents(TOKEN_SERVICE_PATH, json_encode($this->_client->getAccessToken()));
			}*/
			$this->generateToken();
			$this->_service = new Google_Service_Calendar($this->_client);
		}catch(Exception $e){
			//print_r($e);
		}		
	}
	
	public function generateToken(){
		$this->_client->setClientId( CLIENT_ID );
		$this->_client->setApplicationName('Google Calendar API');
		$this->_client->setScopes($this->scope);
		$this->_client->refreshTokenWithAssertion();
		$f = fopen(TOKEN_SERVICE_PATH,"w+");
		fwrite($f,json_encode($this->_client->getAccessToken()));
		fclose($f);
	}
	
	public function getColor(){
		$_service = new Google_Service_Calendar($this->_client);
		return  $_service->colors->get();
	}
	
	function insert_event($event,$conferenceDataVersion=0){
		$eventC = new Google_Service_Calendar_Event($event);
		/*if($requestID!=""){
			$createSolution = new Google_Service_Calendar_ConferenceSolutionKey();
			$createSolution->setType("hangoutsMeet");
			//$createSolution->setType("eventHangout");
			$createRequest = new Google_Service_Calendar_CreateConferenceRequest();
			$createRequest->setConferenceSolutionKey($createSolution);
			$createRequest->setRequestId($requestID);
			$conferenceData = new Google_Service_Calendar_ConferenceData();
			$conferenceData->setCreateRequest($createRequest);
			$eventC->setConferenceData($conferenceData);
		}
		echo "<pre>";
		print_r($eventC);*/
		$calendarId = 'primary';
		$service = new Google_Service_Calendar($this->_client);
		$optParams = array('sendNotifications'=>TRUE);
		if($conferenceDataVersion==1){
			$optParams['conferenceDataVersion'] = 1;
		}
		$eventR = $service->events->insert($calendarId, $eventC,$optParams);
		return $eventR;
	}
	
	function patch_event($event,$eventID,$conferenceDataVersion = 0){
		$eventC = new Google_Service_Calendar_Event($event);
		$calendarId = 'primary';
		$service = new Google_Service_Calendar($this->_client);
		$optParams = array('sendNotifications'=>TRUE);
		if($conferenceDataVersion==1){
			$optParams['conferenceDataVersion'] = 1;
		}
		$eventR = $service->events->patch($calendarId, $eventID, $eventC,$optParams);
		return $eventR;
	}
	
	function update_event($event,$eventID){
		$eventC = new Google_Service_Calendar_Event($event);
		$calendarId = 'primary';
		$service = new Google_Service_Calendar($this->_client);
		$optParams = array('sendNotifications'=>TRUE);
		$eventR = $service->events->update($calendarId, $eventID, $eventC,$optParams);
		return $eventR;
	}
	
	public function getCalendarList(){
		$calendarList = array();
		do {
			try {
			  $parameters = array();
			  if (isset($pageToken)) {				
				$parameters['pageToken'] = $pageToken;
			  }
			  $children = $this->_service->calendarList->listCalendarList($parameters);
			  foreach ($children->getItems() as $child) {
				$calendarList[] = $child;
			  }
			  $pageToken = $children->getNextPageToken();
			} catch (Exception $e) {
			  $pageToken = NULL;
			}
		} while ($pageToken);		
		return $calendarList;
	}
	
	public function getEvent($eventID){
		$calendarId = 'primary';
		$service = new Google_Service_Calendar($this->_client);
		$event = $service->events->get($calendarId, $eventID);
		return $event;
	}
	
	public function getEventsList($calendarID,$timeMin,$timeMax="", $orderBy=''){
		$eventList = array();
		do {
			try {
				$parameters = array();
				$parameters['timeMin'] = $timeMin;
				if(!empty($timeMax)){
					$parameters['timeMax'] = $timeMax;
				}
				$parameters['timeZone'] = date_default_timezone_get();
				/*$parameters['singleEvents'] = true;*/
				$parameters['maxResults'] = 500;
				if(!empty($orderBy) && $orderBy=='startTime'){
					$parameters['orderBy'] = 'startTime';
					$parameters['singleEvents'] = TRUE;
				}
				/*$parameters['orderBy'] = 'startTime';
				$parameters['maxResults'] = 2500;	*/			
				/*$parameters = array('timeMin'=>$timeMin,'timeZone'=>date_default_timezone_get(),'orderBy'=>'updated','maxResults'=>2500);*/
			  if (isset($pageToken)) {				
				$parameters['pageToken'] = $pageToken;
			  }

			 
			  $children = $this->_service->events->listEvents($calendarID,$parameters);			 
			  foreach ($children->getItems() as $child) {
				$eventList[] = $child;
			  }
			  $pageToken = $children->getNextPageToken();
			} catch (Exception $e) {
			  $pageToken = NULL;
			}
		} while ($pageToken);
		return $eventList;
	}
	
	public function getFreeBusy($calendarIDs = array(),$fromDate,$toDate){
		/*		
		$date_from = "2019-10-23 09:00:00";
		$date_to = "2019-10-23 19:00:00";*/
		$list = array();
		$freebusy = new Google_Service_Calendar_FreeBusyRequest();
		$freebusy->setTimeMin(date(DateTime::ATOM, strtotime($fromDate)));
		$freebusy->setTimeMax(date(DateTime::ATOM, strtotime($toDate)));
		$freebusy->setTimeZone('America/Los_Angeles');
		$freebusy->setGroupExpansionMax(10);
		$freebusy->setCalendarExpansionMax(10);
		if(count($calendarIDs) == 0){
			$mycalendars = array(array("id"=>"primary"));
		}
		/*$mycalendars = array(array("id"=>"uzi@synpat.com"));*/
		$mycalendars = array($calendarIDs);
		$freebusy->setItems($mycalendars);
		try{
			$list = $this->_service->freebusy->query($freebusy);
		}catch(Exception $e){
			
		}
		return $list;
	}
}