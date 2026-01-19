<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
ignore_user_abort(true);
ini_set('max_execution_time', 0);
ini_set('xdebug.max_nesting_level', 1000);
ini_set("memory_limit","256M");

class emailScrapper{
    public $hostname = '35.224.120.151';
    public $username = 'synpat_backyard';
    public $password = 'J=W3qx4s';
    public $database = 'synpat_backyard';
    public $con = "";
    public $lead_id = 0;
    public $url = "";
    public $header = array();
    public $requestType = "get";
    public $postData = array();
    public $responseT = 0;
    public $findAddresses = array();
    public $first_name = "";
    public $last_name = "";
    public $domain_name = "";
    public $existing_emails = array();
    public $contactID = 0;
    public $company_id = 0;
    public $contactList = array();
	public $companyList = array();
	public $contacts = array();
	public $auth = "";
	public $checkAgain = false;
	public $notifyMessage = array();
    
    public function __construct(){
        $this->con = mysqli_connect($this->hostname,$this->username,$this->password,$this->database);
        $this->con->set_charset("utf8");
		$this->setNotifyMessage(0,'',0);
    }
	
	public function setNotifyMessage($contactID,$name,$status){
		$this->notifyMessage = array('contact_id'=>$contactID,'name'=>$name,'findThatAPI'=>'','voilanorbertAPI'=>'','hunterAPI'=>'','anymailfinderAPI'=>'','snovAPI'=>'','status'=>$status);
	}

    public function callRequest(){
        echo "IN CALL REQUEST<br/>";
       
        $ch = curl_init();
    
        if(count($this->header) > 0){
            echo "adasd<br/>";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        }
		if($this->auth != ""){
			curl_setopt($ch, CURLOPT_USERPWD, $this->auth);
		}
        $url = $this->url;
        if($this->requestType == "post"){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postData);
        } else {
            $url = sprintf("%s?%s", $this->url, http_build_query($this->postData));
        }
    
        curl_setopt($ch, CURLOPT_URL, $url);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        echo "<pre>";
        print_r($this->header);
        print_r($this->postData);
        echo "REQUEST TYPE:".$this->requestType."<br/>";
        echo "REQUEST T:".$this->responseT."<br/>";
        echo "URL:".$this->url."<br/>";
        echo "URL UPDATE:".$url."<br/>";
        echo "</pre>";
    
        // EXECUTE:
        $result = curl_exec($ch);
        echo "RESULT<br/>";
        print_r($result);
        echo "<br/>";
    
        if(!$result){$result = '';}
    
        if( $this->responseT == 0){
            curl_close($ch);            
        } else {
            if (!curl_errno($ch)) {
                echo "INFO:".curl_getinfo($ch, CURLINFO_HTTP_CODE)."<br/>";
                switch(curl_getinfo($ch, CURLINFO_HTTP_CODE)){
                    case 200:
                    case 202:
                            /** check Accepted or success */
                            curl_close($ch);
                            return $result;
                        break;
                    default:
                            curl_close($ch);
                            $result = '';
                        break; 
                }
            }    
        }   
        return $result;
    }

    public function setData($url, $header, $request, $data, $responseT = 0){
        $this->url = $url;
        $this->header = $header;
        $this->requestType = $request;
        $this->postData = $data;
        $this->responseT = $responseT;
    }

    /** 
     * API Findthat 
    */
    public function findThatAPI(){
		echo "I am in findThatAPI <br/>";
		$this->sendNotificationToUser(array('action'=>'scrapping_profile_data','id'=>$this->company_id,'d_d'=>'FindAPI for '.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
        $this->setData("https://findthat.email/api_json/find_email",array(),"post",json_encode(array('api_key'=>'L8dafNxl-FCdfsZpu', 'secret_key'=>'tB5XAaHTpFo1EvDG-lHpW8ctfKrDU59XS', 'first_name'=>$this->first_name, 'last_name'=>$this->last_name, 'company_domain'=>$this->domain_name)));
        $getData = $this->callRequest();
        if($getData != ""){
            try{
                $reponseData = json_decode($getData,true);
                echo "<pre>";
                print_r($reponseData);
                echo "<pre>";
				if(count($reponseData) > 0 && isset($reponseData['status'])){
					if(isset($reponseData['message']) && isset($reponseData['message']['email'])){
						if($emailAddress != null && $emailAddress != 'null'){
							$emailAddress = strtolower($emailAddress);
							$this->notifyMessage['findThatAPI'] = $emailAddress;
							$this->updateNotifyEmail();
							$this->notifyMessage['findThatAPI'] = '';
						}
					}
				}
                if(count($reponseData) > 0 && isset($reponseData['status']) && ($reponseData['status'] == "success" || $reponseData['status'] == "ok")){
                    if(isset($reponseData['message']) && isset($reponseData['message']['email'])){
                        $emailAddress = $reponseData['message']['email'];
                        if($emailAddress != null && $emailAddress != 'null'){
							$emailAddress = strtolower($emailAddress);
                            if(!in_array($emailAddress, $this->existing_emails)){
                                array_push($this->findAddresses,$emailAddress);
								$this->notifyMessage['findThatAPI'] = $emailAddress;
								if($this->notifyMessage['findThatAPI'] != "") {
									$this->updateNotifyEmail();
									$this->sendNotifyEmailFoundFromAPI();
								}
                            }                            
                        }
                    }
                }
            }catch(Exception $e){
        
            }
        }
    }

    /**
     * API voilanorbert 
    */

    public function voilanorbertAPI(){
        /* AUTH auth=('any_string', '16ef4cb7-bee5-4353-8756-e13d01247f28') */
		echo "I am in voilanorbertAPI<br/>";
		$this->sendNotificationToUser(array('action'=>'scrapping_profile_data','id'=>$this->company_id,'d_d'=>'VoilanorbertAPI for '.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
        $header = array();
		$this->auth = 'synpat:16ef4cb7-bee5-4353-8756-e13d01247f28';
        $this->setData("https://api.voilanorbert.com/2018-01-08/search/name",array(),"post",array('name'=>$this->first_name." ".$this->last_name, 'domain'=>$this->domain_name));
        $getData = $this->callRequest();
        if($getData != ""){
            try{
                $json = json_decode($getData, true); 
				echo "<pre>";
				print_r($json);
				echo "</pre>";
				if(isset($json['email'])){
					$temperatureMin = $json['email'];
					if($temperatureMin != null && !empty($temperatureMin)){
						if(!empty($temperatureMin['email'])){
							$emailAddress = strtolower($temperatureMin['email']);
							if($emailAddress != null && !in_array($emailAddress, $this->existing_emails)){
								array_push($this->findAddresses,$emailAddress);
								$this->notifyMessage['voilanorbertAPI'] = $emailAddress;
								if($this->notifyMessage['voilanorbertAPI'] != "") {
									$this->updateNotifyEmail();
									$this->sendNotifyEmailFoundFromAPI();
								}
							} 
						}
					} else {
						if($this->checkAgain === false){
							$this->checkAgain = true;
							$sleepNTime = rand(5,20);
							sleep($sleepNTime);
							$this->voilanorbertAPI();
						}
						
					}
				}				
            }catch(Exception $e){
				echo "<pre>";
				print_r($e);
            }
        }
    }

    /** 
     * API hunter.io 
    */

    public function hunterAPI(){
		echo "I am in hunterAPI<br/>";
		$this->sendNotificationToUser(array('action'=>'scrapping_profile_data','id'=>$this->company_id,'d_d'=>'HunterAPI for '.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
        $this->setData("https://api.hunter.io/v2/email-finder",array(),"get",array('first_name'=>$this->first_name, 'last_name'=>$this->last_name, 'domain'=>$this->domain_name, 'api_key'=>'d09a4282b7b7c9658fe34c83e72b76997a312ddf'));
        $getData = $this->callRequest();
        if($getData != ""){
            try{
                $reponseData = json_decode($getData,true);
                echo "<pre>";
                print_r($reponseData);
                echo "<pre>";
                if(count($reponseData) > 0 && isset($reponseData['data']) && count($reponseData['data']) > 0){
                    if(isset($reponseData['data']['email']) && $reponseData['data']['email'] != ''){
                        $emailAddress = $reponseData['data']['email'];
                        if($emailAddress != null && $emailAddress != 'null'){
							$emailAddress = strtolower($emailAddress);
                            if(!in_array($emailAddress, $this->existing_emails)){
                                array_push($this->findAddresses,$emailAddress);
								$this->notifyMessage['hunterAPI'] = $emailAddress;
								if($this->notifyMessage['hunterAPI'] != "") {
									$this->updateNotifyEmail();
									$this->sendNotifyEmailFoundFromAPI();
								}
                            } 
                        }
                    }
                }
            }catch(Exception $e){
        
            }
        }
    }

    /** 
     * API anymailfinder 
    */

    public function anymailfinderAPI(){
		echo "I am in anymailfinderAPI<br/>";
		$this->sendNotificationToUser(array('action'=>'scrapping_profile_data','id'=>$this->company_id,'d_d'=>'AnymailfinderAPI for '.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
        $this->setData("https://api.anymailfinder.com/v4.1/search/person.json",array('x-api-key: yYLZQcgBqv9zJJQGPGG2vHto'),"post",array('first_name'=>$this->first_name, 'last_name'=>$this->last_name, 'domain'=>$this->domain_name),1);
        $getData = $this->callRequest();
        if($getData != "") {
            echo "IN GET DATA<br/>";
            try{
                $check = 0;
                echo "<pre>";
                print_r($getData);
                $reponseData = json_decode($getData,true);
                echo "Response Data:<br/>";
                print_r($reponseData);
                echo "<pre>";
                if(count($reponseData) > 0 && isset($reponseData['status'])){
                    switch($reponseData['status']){
                        case 'accepted':
                            /** wait for 1 minute and send request again */
                            sleep(60);
                            if($check < 10){
                                $check++;
                                $this->anymailfinderAPI();
                            }
                            break;
                        case 'success':
                            if(isset($reponseData['email']) && $reponseData['email'] != ''){
                                $emailAddress = $reponseData['email'];
                                $emailClass = $reponseData['email_class'];
								if($emailAddress != null && $emailAddress != 'null'){
									$emailAddress = strtolower($emailAddress);
									$this->notifyMessage['anymailfinderAPI'] = $emailAddress;
									$this->updateNotifyEmail();
									$this->notifyMessage['anymailfinderAPI'] = '';
								}
                                if($emailAddress != null && $emailAddress != 'null' && $emailClass == "verified"){
									$emailAddress = strtolower($emailAddress);
                                    if(!in_array($emailAddress, $this->existing_emails)){
                                        array_push($this->findAddresses,$emailAddress);
										$this->notifyMessage['anymailfinderAPI'] = $emailAddress;
										if($this->notifyMessage['anymailfinderAPI'] != "") {
											$this->updateNotifyEmail();
											$this->sendNotifyEmailFoundFromAPI();
										}
                                    } 
                                }
                                $alternativesAddresses = $reponseData['alternatives'];
                                if(count($alternativesAddresses) > 0){
                                    foreach($alternativesAddresses as $address){
										$address = strtolower($address);
                                        if(!in_array($address, $this->existing_emails)){
                                            array_push($this->findAddresses,$address);
											$this->notifyMessage['anymailfinderAPI'] = $this->notifyMessage['anymailfinderAPI'].", ".$address;
                                        } 
                                    }
                                }
                            }
                            break;
                    }
                }
            }catch(Exception $e){
				echo "<pre>";
				print_r($e);
            }
        }
    }

    /** 
     * API findemails 
    */

    public function findEmailsAPI(){
		echo "I am in findEmailsAPI<br/>";
		$this->sendNotificationToUser(array('action'=>'scrapping_profile_data','id'=>$this->company_id,'d_d'=>'FindEmailsAPI for '.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
        $this->setData("https://www.findemails.com/api/v1/guess_email.json",array(),"post",array('key'=>'d8887800c76829fd835d1ae82ded4b5b', 'first_name'=>$this->first_name, 'last_name'=>$this->last_name, 'company_name'=>$this->domain_name));
        $getData = $this->callRequest();
        if($getData != ""){
            try{
                $reponseData = json_decode($getData,true);
                echo "<pre>";
                print_r($reponseData);
                echo "<pre>";
                if(count($reponseData)){
                    foreach($reponseData as $key => $value){
						echo "<pre>";
						print_r($value);
						print_r($key);
                        if($key == "employee" && isset($value['email']) && $value['email']['email'] != '' && (int)$value['email']['confidence'] > 35){
                            $emailAddress = $value['email']['email'];
                            if($emailAddress != null && $emailAddress != 'null'){
								$emailAddress = strtolower($emailAddress);
                                if(!in_array($emailAddress, $this->existing_emails)){
									array_push($this->findAddresses,$emailAddress);
                                } 
                            }
                        }
                    }
                }
            }catch(Exception $e){
				echo "<pre>";
				print_r($e);
            }
        }
    }

    public function getAccessToken(){
        /*qwsa007@ymail.com*/
        $params = [
            'grant_type'    => 'client_credentials',
            'client_id'     => 'c4ac7bce3a182b8f8369b2f5415795ee',
            'client_secret' => '0d328dfcdcc3e26a1c348679a7936504'
        ];
        $options = [
            CURLOPT_URL            => 'https://app.snov.io/oauth/access_token',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true
        ];
    
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $res['access_token'];
    }
    public function getEmailFinder($params){
        /*$params = [
            'access_token' => $token,
            'domain'       => 'octagon.com',
            'firstName'    => 'gavin',
            'lastName'     => 'vanrooyen'
        ];*/
        $options = [
            CURLOPT_URL            => 'https://app.snov.io/restapi/get-emails-from-names',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $res;
    }
    
    public function addEmailFinder($params){
        /*$params = [
            'access_token' => $token,
            'domain'       => 'octagon.com',
            'firstName'    => 'gavin',
            'lastName'     => 'vanrooyen'
        ];*/
        $options = [
            CURLOPT_URL            => 'https://app.snov.io/restapi/add-names-to-find-emails',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $res;
    }

    function retrieveData($params){
        $s = 0;
        $getEmailResultData = $this->getEmailFinder($params);
		echo "<pre>";
		print_r($getEmailResultData);
		echo "</pre>";
        if(isset($getEmailResultData['status']) && isset($getEmailResultData['status']['identifier'])){
            
			if(count($getEmailResultData['data']["emails"]) > 0){
				$email = array();
				foreach($getEmailResultData['data']["emails"] as $email){
					$emailAddress = strtolower($email['email']);
					if($email != null && $email != ""){
						array_push($email,$emailAddress);
					}					
				}
				if(count($email) > 0){
					$this->notifyMessage['snovAPI'] = implode(",",$email);
					$this->updateNotifyEmail();
				}				
				$this->notifyMessage['snovAPI'] = '';
			}
			
			if($getEmailResultData['status']['identifier']=="complete" || $getEmailResultData['status']['identifier']=="in_progress"){
                if(count($getEmailResultData['data']["emails"]) > 0){
                    $s =  1;
                    foreach($getEmailResultData['data']["emails"] as $email){
						$emailAddress = strtolower($email['email']);
						if(!in_array($emailAddress, $this->existing_emails)){
							array_push($this->findAddresses,$emailAddress);
							$this->notifyMessage['snovAPI'] = ($this->notifyMessage['snovAPI'] != "")? $this->notifyMessage['snovAPI'].", ".$emailAddress : $emailAddress;				
						}
                        //array_push($this->findAddresses,strtolower($email['email']));
                    }
					if($this->notifyMessage['snovAPI'] != "") {
						$this->updateNotifyEmail();
						$this->sendNotifyEmailFoundFromAPI();
					}
                }
            }
        } else if(isset($getEmailResultData['errors']) && count($getEmailResultData['errors'])>0){
            $s = 1;
        }
        return $s;
    }

    public function snovAPI(){
		echo "I am in snovAPI<br/>";
		$this->sendNotificationToUser(array('action'=>'scrapping_profile_data','id'=>$this->company_id,'d_d'=>'SnovAPI for '.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
        $token = $this->getAccessToken();
        $newRequest = array('access_token'=>$token,'firstName'=>$this->first_name,'lastName'=>$this->last_name,'domain'=>$this->domain_name);
        echo "<pre>";
        print_r($newRequest);
        echo "</pre>";
        $addEmailResultData = $this->addEmailFinder($newRequest);
        sleep(10);
        $i = 0;
        while($i<6){
            if($i > 0){
                sleep(60);//wait for 10 mins.                    
            }
            $findData = $this->retrieveData($newRequest);
            if($findData == 1){
                break;
            }
            $i++;				
        }
    }



    public function getContactList(){		
        if(count($this->companyList) > 0 || count($this->contacts) > 0){
            /*$queryCompanies = "Select c.id FROM backyard_invitees as i INNER JOIN company as c ON c.id = i.contact_id  WHERE i.lead_id =".$this->lead_id;
            $resultQuery = $this->con->query($queryCompanies);
            if($resultQuery && mysqli_num_rows($resultQuery) > 0){
                $companyList = array();
                while($row = mysqli_fetch_object($resultQuery)){
                    array_push($companyList, $row->id);
                }
*/
                /** Active email 2 and 3 */
                $this->contactList = array();

                $contactQuery = "SELECT c.id,c.first_name,c.last_name,co.web_address,co.company_name,c.email,c.secondary_email,c.tertiary_email,c.active_email,company_id FROM contacts as c INNER JOIN company as co ON co.id = c.company_id WHERE c.active_email = 3 AND c.tertiary_email = ''";
				
				if(count($this->contacts) > 0){
					$contactQuery .= " AND c.id IN (".implode(',',$this->contacts).")";
				} else {
					$contactQuery .= " AND c.company_id IN (".implode(',',$this->companyList).")";
				}

                echo $contactQuery."<br/>";

                $resultQuery = $this->con->query($contactQuery);

                if($resultQuery && mysqli_num_rows($resultQuery) > 0){
                    while($row = mysqli_fetch_object($resultQuery)){
                        array_push($this->contactList, $row);
                    }
                }

                $contactQuery = "SELECT c.id,c.first_name,c.last_name,co.web_address,co.company_name,c.email,c.secondary_email,c.tertiary_email,c.active_email,company_id FROM contacts as c INNER JOIN company as co ON co.id = c.company_id WHERE c.active_email = 2 AND c.secondary_email = '' ";
				
				if(count($this->contacts) > 0){
					$contactQuery .= " AND c.id IN (".implode(',',$this->contacts).")";
				} else {
					$contactQuery .= " AND c.company_id IN (".implode(',',$this->companyList).")";
				}
				
				
				
				
                echo $contactQuery."<br/>";
                $resultQuery = $this->con->query($contactQuery);

                if($resultQuery && mysqli_num_rows($resultQuery) > 0){
                    while($row = mysqli_fetch_object($resultQuery)){
                        array_push($this->contactList, $row);
                    }
                }

                $contactQuery = "SELECT c.id,c.first_name,c.last_name,co.web_address,co.company_name,c.email,c.secondary_email,c.tertiary_email,c.active_email,company_id FROM contacts as c INNER JOIN company as co ON co.id = c.company_id WHERE c.active_email = 1 AND c.email = '' ";
				
				if(count($this->contacts) > 0){
					$contactQuery .= " AND c.id IN (".implode(',',$this->contacts).")";
				} else {
					$contactQuery .= " AND c.company_id IN (".implode(',',$this->companyList).")";
				}
				
				
                echo $contactQuery."<br/>";
                $resultQuery = $this->con->query($contactQuery);

                if($resultQuery && mysqli_num_rows($resultQuery) > 0){
                    while($row = mysqli_fetch_object($resultQuery)){
                        array_push($this->contactList, $row);
                    }
                }
            /*}*/
			if(count($this->contactList) > 0){				
				$addList = array();
				foreach($this->contactList as $list){
					$this->add("email_notification",array('contact_id'=>$list->id,'name'=>$list->first_name." ".$list->last_name,'status'=>0));
				}	
			}
        }
    }

    public function scrapeFromAllAPI(){
        echo "COUNT:".count($this->contactList)."<br/>";
        if(count($this->contactList) > 0){
			$lt = 0;
            foreach($this->contactList as $contact){
                echo "<pre>";
                print_r($contact);
				$lt++;
				if($lt > 1){
					$sleepNTime = rand(15,60);
					$this->sendNotificationToUser(array('action'=>'scrapping_wait_period','id'=>$this->company_id,'d_d'=>'Wait for '.$sleepNTime.' next email contact'.$this->first_name." ".$this->last_name,'type'=>0));
					sleep($sleepNTime);
				}
                $this->findAddresses = array();
                $this->first_name = $contact->first_name;
                $this->last_name = $contact->last_name;
				//$this->notifyMessage['name'] = $this->first_name." ".$this->last_name;
                $webaddress = $contact->web_address;
				$this->contactID = $contact->id;
				$this->company_id = $contact->company_id;
                $existingEmails = array();
                if($contact->email != "" && $contact->email != null){
                    array_push($existingEmails, strtolower($contact->email));
                }
                if($contact->secondary_email != "" && $contact->secondary_email != null){
                    array_push($existingEmails, strtolower($contact->secondary_email));
                }
                if($contact->tertiary_email != "" && $contact->tertiary_email != null){
                    array_push($existingEmails, strtolower($contact->tertiary_email));
                }
                $this->existing_emails = $existingEmails;
                $getDomain = "";
                if($webaddress != ""){
                    $getDomain = $this->getDomainName($webaddress);
                }                
                $getDomain = str_replace("www.","",strtolower($getDomain));
                if($getDomain != ""){
                    $this->domain_name = $getDomain;
                } else {
                    $this->domain_name = $contact->company_name;
                } 
                echo "DomainName:".$this->domain_name."<br/>";
				$this->setNotifyMessage($this->contactID,$this->first_name." ".$this->last_name,1);
				$this->updateNotifyEmail();
                $this->scrapeAll();
				$this->setNotifyMessage($this->contactID,$this->first_name." ".$this->last_name,2);
				$this->updateNotifyEmail();
                echo "<pre>";
				echo "Email Address Found<br/>";
                print_r($this->findAddresses);

                if(count($this->findAddresses) > 0){
                    $arrayCountValues = array_count_values($this->findAddresses);
					echo "ARRAY COUNT VALUES<br/>";
					print_r( $arrayCountValues);
                    $emailWeightage = array();
                    foreach($arrayCountValues as $key => $value){
                        $emailWeightage[] = array('email'=>$key,'repeat'=>$value);
                    }
					echo "EMAIL WEIGHTAGE<br/>";
					print_r( $emailWeightage);
                    if(count($emailWeightage) > 0){
                        /** Sort by repeat DESC */
                        $repeat = array_column($emailWeightage, 'repeat');

                        array_multisort($repeat, SORT_DESC, $emailWeightage);
                        
                        $i=0;
                        $email1 = "";
                        $email2 = "";
                        $email3 = "";
                        $other = array();
                        foreach($emailWeightage as $email){
                            if($i<3){
                                if($i == 0){
                                    $email1 = $email['email'];
                                } else if($i == 1){
                                    $email2 = $email['email'];
                                } else if($i == 2){
                                    $email3 = $email['email'];
                                }
                            } else {
                                $other[] = $email['email'];
                            }
                            $i++;
                        }
						
						echo "EMAIL 1:".$email1."<br/>";
						echo "EMAIL 2:".$email2."<br/>";
						echo "EMAIL 3:".$email3."<br/>";
						echo "<pre>";
						print_r($other);
						echo "</pre>";
                        $updateData = array();

                        if((int)$contact->active_email == 1){
							echo "A1<br/>";
							if($contact->email == ""){
								echo "A11<br/>";
								$updateData['email'] = $email1;
								$updateData['secondary_email'] = $email2;
								$updateData['tertiary_email'] = $email3;
								$updateData['new_email'] = 1;
							} else {
								echo "A13<br/>";
								$updateData['secondary_email'] = $email1;
								$updateData['tertiary_email'] = $email2;
								$updateData['new_email'] = 1;
								if(count($other) > 0){
									array_splice($other,0,1,$email3);
								} else {
									$other[] = $email3;
								}
								
							}                            
                        } else if((int)$contact->active_email == 2){
							echo "A2<br/>";
                            if($contact->email != $email1){
								echo "A21<br/>";
                                $updateData['secondary_email'] = $email1;
                                $updateData['tertiary_email'] = $email2;
								$updateData['new_email'] = 1;
                                if(count($other) > 0){
									array_splice($other,0,1,$email3);
								} else {
									$other[] = $email3;
								}
                            } else {
								echo "A22<br/>";
                                if($contact->email != $email2){
									echo "A223<br/>";
                                    $updateData['secondary_email'] = $email2;
									$updateData['new_email'] = 1;
                                    if($contact->email != $email3){
                                        $updateData['tertiary_email'] = $email3;
										$updateData['new_email'] = 1;
                                    }
                                } else {
									echo "A224<br/>";
                                    if($contact->email != $email3){
										echo "A225<br/>";
                                        $updateData['secondary_email'] = $email3;
										$updateData['new_email'] = 1;
                                        if(count($other) > 0){
                                            foreach($other as $em){
                                                if($contact->email != $em){
                                                    $updateData['tertiary_email'] = $em;
													$updateData['new_email'] = 1;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }                                
                            }                            
                        }
						if(count($updateData) > 0){
							if(count($other) > 0){
								$updateData['other'] = json_encode($other);
							}
							echo "<pre>";
							print_r($updateData);
							//$whereCondition = array('id'=>$contact->id);
							$this->update("contacts",$updateData,$contact->id);
						}
						$this->sendNotificationToUser(array('action'=>'scrapping_email_finished','id'=>$this->company_id,'d_d'=>'Finished '.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
                    }
                } else {
					$this->sendNotificationToUser(array('action'=>'scrapping_profile_data','id'=>$this->company_id,'d_d'=>'Emails not found for '.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
				}                
            }
			$this->sendNotificationToUser(array('action'=>'scrapping_emails_finished','id'=>$this->company_id,'d_d'=>'Emails scrapping finished'.$this->first_name." ".$this->last_name.'@@'.$this->contactID,'type'=>0));
        }
    }

    public function update($tableName,$postValues,$where){
		$stringName ="";
		foreach($postValues as $key=>$value){
			$stringName .=$key."='".mysqli_real_escape_string($this->con,$value)."',";
		}
		$stringName = substr($stringName,0,-1);
		$sql = "UPDATE ".$tableName." SET ".$stringName." WHERE id= ".$where;	
		echo "UPDATE QUERY:".$sql."<br/>";
		$result = $this->con->query($sql);
		if($result){
			return $where;
		} else {
			return 0;
		}
	}
	
	function add($tableName,$postValues){	
		$stringName ="";
		$stringValue ="";
		foreach($postValues as $key=>$value){
			
			$stringName .= $key.",";
			$stringValue .="'".mysqli_real_escape_string($this->con,stripslashes($value))."'".",";
		}
		$stringName = substr($stringName,0,-1);
		$stringValue =substr($stringValue,0,-1);
		$sql = "INSERT INTO ".$tableName."(".$stringName.") VALUES (".$stringValue.")";		
		echo $sql;
		$result = $this->con->query($sql);
		if($result){
			return mysqli_insert_id($this->con);
		} else {
			return 0;
		}
	}

    public function getDomainName($url){
        $domainName = "";
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            $domainName =  $regs['domain'];
        }
        return $domainName;
    }

    public function scrapeAll(){
		
        $this->findThatAPI();
		
		$this->checkAgain = false;
		
        $this->voilanorbertAPI();
		
		$this->checkAgain = false;
		
		$this->auth = "";
		
        $this->hunterAPI();

        $this->anymailfinderAPI();
	
        //$this->findEmailsAPI();

        $this->snovAPI();

    }
	
	function sendNotificationToUser($postData){
		$ch = curl_init();		
		$api_url = 'https://backyard.synpat.com/customers/push_notification_scrape_linkedin';
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
		$response = curl_exec($ch); 
		curl_close($ch);
		return $response;
	}
	
	function sendNotifyEmailFoundFromAPI(){
		$this->sendNotificationToUser(array('action'=>'scrapping_email_api_found_data','id'=>$this->contactID,'d_d'=>json_encode($this->notifyMessage),'type'=>0));
	}
	
	function updateNotifyEmail(){
		if($this->notifyMessage['contact_id'] > 0){
			$queryCheck = "SELECT id FROM email_notification WHERE contact_id = ".$this->notifyMessage['contact_id'];
			$queryRes = $this->con->query($queryCheck);
			if(mysqli_num_rows($queryRes) > 0){
				$row = mysqli_fetch_object($queryRes);
				$this->update("email_notification",$this->notifyMessage,$row->id);
			} else {
				//$this->add("email_notification",$this->notifyMessage);
			}
		}		
	}

}

$emailScrapper = new emailScrapper();

echo "EMAIL API SCRAPPER <BR/>";

if(isset($_REQUEST) && isset($_REQUEST['companies']) && count($_REQUEST['companies']) > 0){
	$emailScrapper->companyList = json_decode($_REQUEST['companies']);	
}
if(isset($_REQUEST) && isset($_REQUEST['contacts']) && count($_REQUEST['contacts']) > 0){
	$emailScrapper->contacts = json_decode($_REQUEST['contacts']);	
}


$emailScrapper->getContactList();

$emailScrapper->scrapeFromAllAPI();
?>