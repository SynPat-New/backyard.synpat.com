<?php 

ignore_user_abort(true);
ini_set('max_execution_time', 0);
ini_set('xdebug.max_nesting_level', 1000);
ini_set("memory_limit","256M");

class findEmail{
    public $hostname = '35.224.120.151';
    public $username = 'synpat_backyard';
    public $password = 'J=W3qx4s';
    public $database = 'synpat_backyard';
    public $con = "";
    public $imap = "";
    public $lead_id = 0;
    public $refreshActivity = false;
    public function __construct(){
        $this->con = mysqli_connect($this->hostname,$this->username,$this->password,$this->database);
        $this->con->set_charset("utf8");
    }

    public function campaignQuery(){
        $row = array();
        $campaignQuery = "SELECT id,start_date,subject,lead_id FROM campaigns WHERE lead_id = ".$this->lead_id." AND campaign_type = 1 AND activity_type = 1 AND checked = 0  GROUP BY lead_id ORDER BY start_date ASC  LIMIT 1";

        echo $campaignQuery ."<br/>";
        $resultCampaign = $this->con->query($campaignQuery);
        if($resultCampaign){
            if(mysqli_num_rows($resultCampaign)>0){
                $row = mysqli_fetch_object($resultCampaign);
            }
        }
        return $row;
    }

    public function markedBounceAndDelete($newList){
        foreach($newList as $email){
            $body = $email['body'];
            $uID = $email['uid'];            
            $foundEmail = "";
            try{
                $getEmails = $this->extract_emails_from($body);
                if(isset($getEmails[0]) && count($getEmails[0]) > 0){
                    foreach($getEmails[0] as $em){
                        $em = trim($em);
                        $getContact = $this->getContactByEmail($em);
                        if(count($getContact) > 0){
                            $getMessagesList = $this->getListOfMessages($em,1);
                            if(count($getMessagesList['ids']) > 0){
                                $foundEmail = $em;
                                break;
                            }                            
                        }
                    }
                }
                if($foundEmail == ""){
                    $emailAddresses = mailparse_rfc822_parse_addresses($body);
                    if(count($emailAddresses) > 0){                
                        foreach($emailAddresses as $emailA){                   
                            if(filter_var($emailA['address'],FILTER_VALIDATE_EMAIL)){
                                $foundEmail = $emailA['address'];
                            } else if(filter_var($emailA['display'],FILTER_VALIDATE_EMAIL)){
                                $foundEmail = $emailA['display'];
                            }
                            if($foundEmail != ""){
                                break;
                            }
                        }
                    }
                }
            } catch (Exception $e){
                /*echo $body;
                $getEmails = $this->extract_emails_from($body);
                echo "<pre>";
                print_r($getEmails);die;*/
            }
            
            echo "Email Found:". $foundEmail."<br/>";
            if($foundEmail != ""){
                $findMessagesList = $this->getListOfMessages($foundEmail);
                if(count($findMessagesList['email_ids']) > 0){
                    /** Update all sales activites by email to error =>1 */
                    $updateSales = $this->updateAllSalesEmail($findMessagesList['email_ids']);
                    $updateBounce = $this->updateAllBounceEmail($findMessagesList['email_ids']);
                    if($updateSales > 0 && $updateBounce > 0){
                        echo "UPDATED SALES and Bounce<br/>";
						if($this->refreshActivity === false){
							$this->refreshActivity = true;
						}
                    }
                }
                /** Delete Email from imap with UID*/ 
                $deleteMessage = $this->imap->permanentDeleteMessage($uID);
                if($deleteMessage){
                    echo "Message deleted<br/>";
                }                           
                /** Switch to another email */
                $findContactEmails = $this->getContactByEmail($foundEmail);
                if(count($findContactEmails) > 0){
                    $activeType = 1;
                    if($findContactEmails->active_email == 3){
                        /** All 3 emails are not valid change to bounce address */
                        $activeType = 4;                                
                    } else {                                
                        switch($findContactEmails->active_email){
                            case 1:                                            
                                /*if($findContactEmails->secondary_email != $foundEmail){
                                    $activeType = 2;
                                } else {
                                    $activeType = 4;
                                }*/
                                $activeType = 2;
                                break;
                            case 2:
                                if($findContactEmails->secondary_email != "" && $findContactEmails->secondary_email != $foundEmail){
                                    $activeType = 3;
                                } else {
                                    $activeType = 2;
                                }
                                /*if($findContactEmails->tertiary_email != $foundEmail){
                                    $activeType = 3;
                                } else {
                                    $activeType = 4;
                                }*/
                                break;
                        }
                    }
                    if($activeType > 1){
                        $this->updateContactActiveEmail($findContactEmails->id,$activeType);
                    }
                }
            }
        }
    }

    public function getContactByEmail($email){
        $contactData = array();
        $contactQuery = "SELECT id , email, secondary_email, tertiary_email, active_email FROM contacts where email ='".$email."' OR secondary_email ='".$email."' OR tertiary_email ='".$email."'";
        echo $contactQuery."<br/>";
        $resultContact = $this->con->query($contactQuery);
        if($resultContact && mysqli_num_rows($resultContact) > 0){
            $contactData = mysqli_fetch_object($resultContact);
        }
        return $contactData;
    }
    
    public function updateContactActiveEmail($id,$activeType){
        $updateQuery = "UPDATE contacts SET active_email = ".$activeType.", new_email = 1 WHERE id = ".$id;
        echo $updateQuery."<br/>";
        $this->con->query($updateQuery);
        return mysqli_affected_rows($this->con);
    }
    
    public function updateAllBounceEmail($emailIDs){
        $updateQuery = "UPDATE campaign_sender_lists SET bounce = 1, checked = 1 WHERE email_id IN (".implode(',',$emailIDs).")";
        echo $updateQuery."<br/>";
        $this->con->query($updateQuery);
        return mysqli_affected_rows($this->con);
    }
    
    public function updateAllSalesEmail($emailIDs){
        $updateQuery = "UPDATE sales_activity_log_detail SET error = 1 WHERE email_id IN (".implode(',',$emailIDs).")";
        echo $updateQuery."<br/>";
        $this->con->query($updateQuery);
        return mysqli_affected_rows($this->con);
    }
    
    public function getListOfMessages($emailAddress,$t=0){
        $list = array('ids'=>array(),'email_ids'=>array());
        $addressQuery = "SELECT cl.id,cl.email_id FROM campaign_sender_lists as cl INNER JOIN campaigns as c ON c.id  = cl.campaign_id WHERE c.lead_id = ".$this->lead_id." AND cl.address = '" .$emailAddress."' AND cl.send = 1 AND cl.email_id > 0 ";
        if($t == 0){
            $addressQuery .= " AND cl.bounce = 0  AND cl.checked = 0";
        }
        echo $addressQuery."<br/>";
        $resultQuery = $this->con->query($addressQuery);
        if($resultQuery){
            if(mysqli_num_rows($resultQuery)>0){
                while($row = mysqli_fetch_object($resultQuery)){
                    array_push($list['ids'],$row->id);
                    array_push($list['email_ids'],$row->email_id);
                }
            }
        }
        return $list;
    }
    
    public function extract_emails_from($string){
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
        return $matches;
    }
    
    public function searchEmails($subject, $startDate, $t=0){
        /*Find emails like Undelivered, bounce back */
        $hostname = 'imap.gmail.com:993';
        $config = array();
        $config['imap_email'] = 'synpat@synpat.com';
        $config['imap_password'] = 'synpat@_12341234';
        $toAccount = 'licenses@synpat.com';
        $results = array();
        require_once("/var/www/synpat/backyard/application/libraries/Imap.php");
        $params = array('mailbox'=>$hostname,'username'=>$config['imap_email'],'password'=>$config['imap_password'],'encryption'=>'ssl','folder'=>'INBOX');
        $this->imap = new Imap($params);
        if($this->imap->isConnected() && $toAccount!=''){
            echo "CONNECTED<br/>";
            $filter = "";
            if($t === 1){
                $filter = "UNSEEN";
            } else if($t === 2){
                $filter = "SEEN";
            }
            /*$searchCriterea = 'TO "'.$toAccount.'" SUBJECT "'.$subject.'" '.$filter.' SINCE "'.$startDate.'" BEFORE "'.$endDate.'"';*/
            $searchCriterea = 'TO "'.$toAccount.'" SUBJECT "'.$subject.'" '.$filter.' SINCE "'.$startDate.'"';
            $results = $this->imap->searchEmails($searchCriterea);        
        }
        return  $results;
    }
	function sendNotificationToBackyard(){
		$postData = array('action'=>'refresh_activity_table','id'=>0,'d_d'=>'','type'=>0);
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
}

if(isset($_GET['lead_id']) && $_GET['lead_id'] > 0){
    $leadID = $_GET['lead_id'];
    $findEmails = new findEmail();
    $findEmails->lead_id = $leadID;
    $current = $findEmails->campaignQuery();
    $startDate = "";
    if(count($current) > 0){
        $startDate = date('d F Y',strtotime('-1 days',strtotime($current->start_date)));
    }
    if($startDate != ""){
        $subject = "Delivery Status Notification (Failure)";

        /**UNSEEN */
        $getEmailList = $findEmails->searchEmails($subject, $startDate,1);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo "Delivery Status Notification (Failure) UNSEEN not found<br/>";
		}
        
        /**SEEN */     
        $getEmailList = $findEmails->searchEmails($subject, $startDate,2);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo "Delivery Status Notification (Failure) SEEN not found<br/>";
		}

        /*$subject = "Delivery Status Notification (Delay)";

        /**UNSEEN */
        /*$getEmailList = $findEmails->searchEmails($subject, $startDate,1);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        }*/
        
        /**SEEN */     
        /*$getEmailList = $findEmails->searchEmails($subject, $startDate,2);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        }*/

        $subject = "Undelivered Mail Returned to Sender";

        /**UNSEEN */
        $getEmailList = $findEmails->searchEmails($subject, $startDate,1);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo "Undelivered Mail Returned to Sender UNSEEN not found<br/>";
		}
        
        /**SEEN */     
        $getEmailList = $findEmails->searchEmails($subject, $startDate,2);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo "Undelivered Mail Returned to Sender SEEN not found<br/>";
		}

        /**Another failure subject */
        $subject = "Returned mail: see transcript for details";

        /**UNSEEN */
        $getEmailList = $findEmails->searchEmails($subject, $startDate,1);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo "Returned mail: see transcript for details UNSEEN not found<br/>";
		}

        /**SEEN */     
        $getEmailList = $findEmails->searchEmails($subject, $startDate,2);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo "Returned mail: see transcript for details SEEN not found<br/>";
		}

        /**Another failure subject */
        $subject = "Undeliverable: ".$current->subject;

        /**UNSEEN */
        $getEmailList = $findEmails->searchEmails($subject, $startDate,1);
        echo "COUNT:".count($getEmailList)."<br/>";
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo $subject." UNSEEN not found<br/>";
		}

        /**SEEN */     
        echo "COUNT:".count($getEmailList)."<br/>";
        $getEmailList = $findEmails->searchEmails($subject, $startDate,2);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo $subject." SEEN not found<br/>";
		}

        /**Another failure subject */
        $subject = "Undeliverable: [**SPAM**] ".$current->subject;

        /**UNSEEN */
        $getEmailList = $findEmails->searchEmails($subject, $startDate,1);
        echo "COUNT:".count($getEmailList)."<br/>";
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo $subject." UNSEEN not found<br/>";
		}

        /**SEEN */     
        echo "COUNT:".count($getEmailList)."<br/>";
        $getEmailList = $findEmails->searchEmails($subject, $startDate,2);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo $subject." SEEN not found<br/>";
		}

        /**Another failure subject */
        $subject = "Undeliverable: [Possible Spam -FPE] ".$current->subject;

        /**UNSEEN */
        $getEmailList = $findEmails->searchEmails($subject, $startDate,1);
        echo "COUNT:".count($getEmailList)."<br/>";
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo $subject." UNSEEN not found<br/>";
		}

        /**SEEN */     
        echo "COUNT:".count($getEmailList)."<br/>";
        $getEmailList = $findEmails->searchEmails($subject, $startDate,2);
        if(count($getEmailList) > 0){
            $findEmails->markedBounceAndDelete($getEmailList);
        } else {
			echo $subject." SEEN not found<br/>";
		}
		if($findEmails->refreshActivity === true){
			$findEmails->sendNotificationToBackyard();
		}
    }
}
?>