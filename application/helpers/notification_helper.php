<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getSliderData'))
{
    function getSliderData(){ 
		$CI = &get_instance();
		$query = $CI->db->select('*')->from('sliders')->get();
		$data=array();
		if($query->num_rows()>0){
			$data = $query->result();
		}	
		return $data;
    }
}
if ( ! function_exists('getUserNotification'))
{
    function getUserNotification(){ 
		$CI = &get_instance();
		$user_session_id = $CI->session->userdata('id');
		$query = $CI->db->select('*')->from('notifications')->where('user_id',$user_session_id)->order_by('id','DESC')->get();
		$data=array();
		if($query->num_rows()>0){
			$data = $query->result();
		}	
		return $data;
    }
}
if ( ! function_exists('isHTML'))
{	
	function isHTML($str,$count = FALSE){ 
    $html = array('A','ABBR','ACRONYM','ADDRESS','APPLET','AREA','B','BASE','BASEFONT','BDO','BIG','BLOCKQUOTE','BODY','BR','BUTTON','CAPTION','CENTER','CITE','CODE','COL','COLGROUP','DD','DEL','DFN','DIR','DIV','DL','DT','EM','FIELDSET','FONT','FORM','FRAME','FRAMESET','H1','H2','H3','H4','H5','H6','HEAD','HR','HTML','I','IFRAME','IMG','INPUT','INS','ISINDEX','KBD','LABEL','LEGEND','LI','LINK','MAP','MENU','META','NOFRAMES','NOSCRIPT','OBJECT','OL','OPTGROUP','OPTION','P','PARAM','PRE','Q','S','SAMP','SCRIPT','SELECT','SMALL','SPAN','STRIKE','STRONG','STYLE','SUB','SUP','TABLE','TBODY','TD','TEXTAREA','TFOOT','TH','THEAD','TITLE','TR','TT','U','UL','VAR'); 
    if(preg_match_all("~(<\/?)\b(".implode('|',$html).")\b([^>]*>)~i",$str,$c)){ 
        if($count) 
            return array(TRUE, count($c[0])); 
        else 
            return TRUE; 
    }else{ 
        return FALSE; 
    } 
} 
}
if ( ! function_exists('getUserTimeLine'))
{	
	function getUserTimeLine($userID,$leadID,$opportunityID){
		$CI = &get_instance();
		$CI->load->model('user_model');
		$getTimelineData = $CI->user_model->getAllUserHistory($userID,$leadID,$opportunityID);
		return $getTimelineData;
	}  
}

if ( ! function_exists('getUserTimeLineWithSearch'))
{	
	function getUserTimeLineWithSearch($userID,$from,$to,$leadID){
		$CI = &get_instance();
		$CI->load->model('user_model');
		$getTimelineData = $CI->user_model->getUserTimeLineWithSearch($userID,$from,$to,$leadID);
		return $getTimelineData;
	}
}

if ( ! function_exists('getLeadDetail'))
{	
	function getLeadDetail($leadID){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$getLeadData = $CI->lead_model->getLeadData($leadID);
		return $getLeadData;
	}
}

if ( ! function_exists('getMyLogTime'))
{	
	function getMyLogTime($userID,$from,$to,$lead,$activityType){
		$CI = &get_instance();
		$CI->load->model('user_model');
		$getLogTimeData = $CI->user_model->getMyLogTime($userID,$from,$to,$lead,$activityType);
		return $getLogTimeData;
	}
}

if ( ! function_exists('getFlagConversations'))
{	
	function getFlagConversations($userID){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$getMesageList = $CI->lead_model->getFlagConversations($userID);
		return $getMesageList;
	}
}

if ( ! function_exists('getMessageTaskList'))
{	
	function getMessageTaskList($userID){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$getMesageList = $CI->lead_model->getMessageTaskList($userID);
		return $getMesageList;
	}
}

if ( ! function_exists('getAllBackyardModules'))
{	
	function getAllBackyardModules(){
		$CI = &get_instance();
		$CI->load->model('user_model');
		$getModulesData = $CI->user_model->getAllBackyardModules();
		return $getModulesData;
	}
}
if ( ! function_exists('get_menu_arr'))
{
	function get_menu_arr(){
		$CI = &get_instance();
		$user_session_id = $CI->session->userdata('id');
		$query = $CI->db->select('*')->from('user_page_access_level as u')->join('pages','u.page_id=pages.id')->where('u.user_id',$user_session_id)->get();
		//echo $CI->db->last_query();
		$data=array();
		if($query->num_rows()>0){
			$data = $query->result();
		}	
		return $data;
    }
}
if ( ! function_exists('getUserPageAssigned'))
{	
	function getUserPageAssigned(){
		/*Check Which Page Assign to him*/
		$CI = &get_instance();
		$user_session_id = $CI->session->userdata('id');
		$where = "( p.page_url = 'leads/litigation' OR p.page_url = 'leads/market')";
		$query = $CI->db->select('p.*')->from('pages as p')->join('user_page_access_level as u', 'u.page_id = p.id')->where('u.user_id',$user_session_id)->where($where)->get();
		$data=array();
		if($query->num_rows()>0){
			$data = $query->result();
		}	
		return $data;
	}
}
if ( ! function_exists('getUserTaskList'))
{	
	function getUserTaskList($lead_id=null){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$user_session_id = $CI->session->userdata('id');
		$getTaskData = $CI->opportunity_model->waitingApproval($user_session_id);
		return $getTaskData;
	}
}

if ( ! function_exists('getUserMyCreatedTaskList'))
{	
	function getUserMyCreatedTaskList($lead_id=null){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$user_session_id = $CI->session->userdata('id');
		$getTaskData = $CI->opportunity_model->myTaskApproval($user_session_id);
		return $getTaskData;
	}
}


if ( ! function_exists('checkUserCreatedLeadFromLitigation'))
{	
	function checkUserCreatedLeadFromLitigation(){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$getLeadCreated = $CI->lead_model->checkUserCreatedLeadFromLitigation();
		return $getLeadCreated;
	}
}

if ( ! function_exists('getUserById'))
{	
	function getUserById($ID){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$getLeadCreated = $CI->lead_model->getUserById($ID);
		return $getLeadCreated;
	}
}

if ( ! function_exists('sendApprovalRequest'))
{	
	function sendApprovalRequest($data){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$getLeadCreated = $CI->opportunity_model->sendApprovalRequest($data);
		return $getLeadCreated;
	}
}
if ( ! function_exists('waitingApproval'))
{	
	function waitingApproval(){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$getApproval = $CI->opportunity_model->waitingApproval($CI->session->userdata['id']);
		return $getApproval;
	}
}
if ( ! function_exists('checkApprovalSend'))
{	
	function checkApprovalSend(){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$getApproval = $CI->opportunity_model->checkApprovalSend($CI->session->userdata['id']);
		return $getApproval;
		
	}
}
if ( ! function_exists('getAllUsersIncAdmin'))
{	
	function getAllUsersIncAdmin(){
		$CI = &get_instance();
		$CI->load->model('user_model');
		$getUserList = $CI->user_model->getAllUsersIncAdmin();
		return $getUserList;
		
	}
}
if ( ! function_exists('findAdminUsers'))
{	
	function findAdminUsers(){
		$CI = &get_instance();
		$CI->load->model('user_model');
		$getUserList = $CI->user_model->findAdminUsers();
		return $getUserList;
		
	}
}
if ( ! function_exists('getTaskAccToType'))
{	
	function getTaskAccToType($type){
		$CI = &get_instance();
		$CI->load->model('general_model');
		$getData = $CI->general_model->getTaskAccToType($type);
		return $getData;
		
	}
}


if ( ! function_exists('findIncompleteANDCompleteList'))
{	
	function findIncompleteANDCompleteList($type=''){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$getData = $CI->lead_model->findIncompleteANDCompleteList($type);
		return $getData;
		
	}
}

if ( ! function_exists('findIncompleteANDCompleteListAccUser'))
{	
	function findIncompleteANDCompleteListAccUser($userID){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$page = $CI->lead_model->countAssignedLead($userID);
		$getData = $CI->lead_model->findIncompleteANDCompleteListAccUser($userID,0,$page);
		return $getData;
		
	}
}

if ( ! function_exists('getPassLead'))
{	
	function getPassLead(){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$getData = $CI->lead_model->getPassLead();
		return $getData;
		
	}
}

if ( ! function_exists('findAllBoxList'))
{	
	function findAllBoxList(){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$getData = $CI->lead_model->findAllBoxList();
		return $getData;
		
	}
}


if ( ! function_exists('myEmails'))
{	
	function myEmails($token,$type){
		$CI = &get_instance();
		$CI->load->library('DriveServiceHelper');		
		$service = new GmailServiceHelper();
		$data = array();
		if(empty($token)){
			$data['auth_url'] = $service->createAuthUrl();
			$data['messages'] =array();							
		} else{
			$data['auth_url']="";
			$service->setAccessToken($token);
			$data['messages'] = $service->messageList(100,$type);	
			unset($_SESSION['clickedd_url']);			
		}
		return $data;
	}
}
if ( ! function_exists('getAllMarketSectors'))
{	
	function getAllMarketSectors(){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$market_sectors = $CI->opportunity_model->getAllMarketSectors();
		return $market_sectors;
		
	}
}
if ( ! function_exists('getAllCompanyIndustry'))
{	
	function getAllCompanyIndustry(){
		$CI = &get_instance();
		$CI->load->model('customer_model');
		return $CI->customer_model->getAllCompanyIndustry();
	}
}
if ( ! function_exists('getAllCompanySize'))
{	
	function getAllCompanySize(){
		$CI = &get_instance();
		$CI->load->model('customer_model');
		return $CI->customer_model->getAllCompanySize();
	}
}
if ( ! function_exists('getAllLinkedinCompanyUsers'))
{	
	function getAllLinkedinCompanyUsers(){
		$CI = &get_instance();
		$CI->load->model('customer_model');
		return $CI->customer_model->getAllLinkedinCompanyUsers();
	}
}
if ( ! function_exists('getAllCategories'))
{	
	function getAllCategories(){
		$CI = &get_instance();
		$CI->load->model('customer_model');
		$market_sectors = $CI->customer_model->categoryList(0);
		return $market_sectors;
		
	}
}

if ( ! function_exists('getAllSubCategories'))
{	
	function getAllSubCategories(){
		$CI = &get_instance();
		$CI->load->model('general_model');
		$allSubCategories = $CI->general_model->getAllSubCategory();
		return $allSubCategories;
		
	}
}

if ( ! function_exists('companyListWithSectorName'))
{	
	function companyListWithSectorName($select=''){
		$CI = &get_instance();
		$CI->load->model('customer_model');
		$list = $CI->customer_model->companyList($select);
		return $list;
	}
}

if ( ! function_exists('getAllCompanies'))
{	
	function getAllCompanies(){
		$CI = &get_instance();
		$CI->load->model('customer_model');
		$list = $CI->customer_model->companyList();
		return $list;
	}
}
if ( ! function_exists('getAllTemplates'))
{	
	function getAllTemplates(){
		$CI = &get_instance();
		$CI->load->model('general_model');
		$list = $CI->general_model->getAllTemplates();
		return $list;
	}
}
if ( ! function_exists('getAllTemplateBYLead'))
{	
	function getAllTemplateBYLead($leadID){
		$CI = &get_instance();
		$CI->load->model('general_model');
		$list = $CI->general_model->getAllTemplateBYLead($leadID);
		return $list;
	}
}
if ( ! function_exists('getUsersByActDeactCompanies'))
{	
	function getUsersByActDeactCompanies($companyID,$status){
		$CI = &get_instance();
		$CI->load->model('customer_model');
		$count = $CI->customer_model->getUsersByActDeactCompanies($companyID,$status);
		return $count;
	}
}
if ( ! function_exists('findMyPreferenceWithName'))
{	
	function findMyPreferenceWithName($companyID){
		$CI = &get_instance();
		$CI->load->model('customer_model');
		$count = $CI->customer_model->findMyPreferenceWithName($companyID);
		return $count;
	}
}
if ( ! function_exists('allActiveLeads'))
{	
	function allActiveLeads(){
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$leads = $CI->lead_model->findIncompleteANDCompleteList('');
		return $leads;
	}
}
if ( ! function_exists('getUserCompanyByEmail'))
{	
	function getUserCompanyByEmail($emailID){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$leads = $CI->opportunity_model->find_contact_by_email($emailID);
		return $leads;
	}
}
if ( ! function_exists('getAllUsersCompanyByEmail'))
{	
	function getAllUsersCompanyByEmail($emailIDs){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$data = $CI->opportunity_model->find_all_contacts_by_emails($emailIDs);
		return $data;
	}
}
if ( ! function_exists('timeDiff'))
{
	function timeDiff($startTime,$endTime,$format='%H:%I'){
		$start_date = new DateTime($startTime);
		$end_date = new DateTime($endTime);
		$interval = date_diff($start_date, $end_date);
		return $interval->format($format);
	}
}
if ( ! function_exists('sum_the_time'))
{
	function sum_the_time($time1, $time2) {
		$times = array($time1, $time2);
		$seconds = 0;
		foreach ($times as $time)
		{
			list($hour,$minute,$second) = explode(':', $time);
			$seconds += $hour*3600;
			$seconds += $minute*60;
			$seconds += $second;
		}
		$hours = floor($seconds/3600);
		$seconds -= $hours*3600;
		$minutes  = floor($seconds/60);
		$seconds -= $minutes*60;
		return sprintf('%02d:%02d:%02d', $hours, $minutes,$seconds); 
	}
}
if ( ! function_exists('show_timer'))
{
	function show_timer($timer){
		if(trim($timer)!=""){
			list($hour,$minute,$second) = explode(':', $timer);
		} else {
			$hour='';$minute='';
		}		
		return sprintf('%02d:%02d', $hour, $minute); 
	}
}

if ( ! function_exists('buildTechnologyMenu'))
{
	function buildTechnologyMenu($companyID=0,$d=1){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$result ="";
		$allSectors = $CI->opportunity_model->getTechnologies();
		$i = 1;
		$c = 1;
		$s = 1;
		$findMyPreference = array();
		if($companyID>0){
			$findMyPreference = $CI->opportunity_model->findMyPreferenceTechnologies($companyID);
		}
		if(count($allSectors)>0){
			$result .= "<ol class=\"dd-list\" data-t=\"technology\">\n";
			foreach($allSectors as $sec){
				$parentChecked = '';
				if($companyID>0){
					if(count($findMyPreference)>0){
						foreach($findMyPreference as $pref){
							if($pref->preference_id  == $sec->id){
								$parentChecked='CHECKED="CHECKED"';
								break;
							}
						}
					}
				}
				$sectorName = "<span class='show-span css-label2 black-check'><a class='edit-btn' href='javascript://' onclick='openForEdit(jQuery(this))'>{$sec->name}</a></span><span class='edit-span' style='display:none'><input type='text' class='form-control' style='width:39%;display:inline;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' value='{$sec->name}' />";
				if($d==1){
					/*$sectorName .= "<a href='javascript://' onclick='updateMe(jQuery(this));' style='margin-left:5px;'>Save</a><a href='javascript://' onclick='closeMe(jQuery(this));' style='margin-left:5px;'>Cancel</a><a class='btn-delete' style='margin-left:5px;' href='javascript://' onclick='deleteMe(jQuery(this))'>Delete</a></span>";*/
					$sectorName .= "<a href='javascript://' onclick='updateMe(jQuery(this));' style='margin-left:5px;'>Save</a><a href='javascript://' onclick='closeMe(jQuery(this));' style='margin-left:5px;'>Cancel</a>";
				}
				$padding = "";
				if($d==0){
					$padding = "padding-left:0px;";
				}				
			$sectorName .= "</span>";				
			$result .= "<li class='dd-item nested-list-item' data-order='{$i}' data-id='{$sec->id}' data-type='technology'>
			  <div class='dd-handle nested-list-handle dd-nodrag'></div>
			  <div class='nested-list-content' style='padding-left:0px'><a href='javascript://' onclick='addFromTop(\"ulChildT{$sec->id}\",jQuery(this),1)'><i class='fa fa-long-arrow-down' style='font-size:8px;'></i></a><input type='checkbox' {$parentChecked} name='preferences[technology][]' class='css-checkbox-2' onchange='checkMeWithOther(jQuery(this),1)' value='{$sec->id}'/><div class='listbox'>{$sectorName}</div></div>";
				$categories =  $sec->sub_category;
				$result .= "<ol class=\"dd-list\"  data-t=\"sub-technology\" style='display:none'>\n";
				if(count($categories)>0){
					foreach($categories as $cat){
						$childChecked = "";
						if(count($findMyPreference)>0){
							foreach($findMyPreference as $pref){
								if($pref->preference_id  == $cat->id){
									$childChecked='CHECKED="CHECKED"';
									break;
								}
							}
						}
						/*if($childChecked=="" && $parentChecked!=""){
							$childChecked='CHECKED="CHECKED"';
						}*/
						$subCategory = $cat->sub_sub_category;
						$catName = "<span class='show-span css-label3 black-check'><a class='edit-btn' href='javascript://' onclick='openForEdit(jQuery(this))'>{$cat->name}</a></span><span class='edit-span' style='display:none'><input type='text' class='form-control' style='width:39%;display:inline;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' value='{$cat->name}' />";
						$classCat = "show";
						if($d==1){
							$catName .= "<a href='javascript://' onclick='updateMe(jQuery(this));' style='margin-left:5px;'>Save</a><a href='javascript://' onclick='closeMe(jQuery(this));' style='margin-left:5px;'>Cancel</a><a class='btn-delete' style='margin-left:5px;' href='javascript://' onclick='deleteMe(jQuery(this))'>Delete</a>";
						}
						$catName .= "</span>";
						$result .= "<li class='dd-item nested-list-item' data-order='{$c}' data-id='{$cat->id}' data-type='sub-technology'>
						  <div class='dd-handle nested-list-handle dd-nodrag'></div>
						  <div class='nested-list-content' style='".$padding."'><a href='javascript://' onclick='addFromTop(\"ulChildChildT{$cat->id}\",jQuery(this),1)'><i class='fa fa-long-arrow-down' style='font-size:8px;'></i></a><input class='parent css-checkbox-3' type='checkbox' {$childChecked} name='preferences[subtechnology][]' onclick='checkedMyChild(jQuery(this),1)' value='{$cat->id}'/><div class='listbox'>{$catName}</div></div>";
						  
						
						$result .= "<ol class=\"dd-list sub-child\" data-t=\"subsub-technology\" style='display:none'>\n";
						if(count($subCategory)>0){	
							foreach($subCategory as $subCat){
								$subChildChecked = "";
								if(count($findMyPreference)>0){
									foreach($findMyPreference as $pref){
										if($pref->preference_id  == $subCat->id){
											$subChildChecked='CHECKED="CHECKED"';
											break;
										}
									}
								}
								$toolTip = addslashes($subCat->explanation);
								/*if($subChildChecked=="" && $childChecked!=""){
									$subChildChecked='CHECKED="CHECKED"';
								}*/
								$subcatName = "<span class='show-span'><a class='edit-btn' href='javascript://' onclick='openForEdit(jQuery(this))' title='{$toolTip}'>{$subCat->name}</a></span><span class='edit-span' style='display:none'><input type='text' class='form-control' style='width:39%;display:inline;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' value='{$subCat->name}' />";
								if($d==1){
									$subcatName .= "<a href='javascript://' onclick='updateMe(jQuery(this));' style='margin-left:5px;'>Save</a><a href='javascript://' onclick='closeMe(jQuery(this));' style='margin-left:5px;'>Cancel</a><a class='btn-delete' style='margin-left:5px;' href='javascript://' onclick='deleteMe(jQuery(this))'>Delete</a>";
								}
								$subcatName .= "</span>";		
								$result .= "<li class='dd-item nested-list-item' data-order='{$c}' data-id='{$subCat->id}' data-type='subsub-technology'>
								  <button data-action='cancel'>&nbsp;</button><div class='dd-handle nested-list-handle dd-nodrag'></div>
								  <div class='nested-list-content' style='".$padding."'><input class='child' type='checkbox' {$subChildChecked} name='sub[technology][]' onclick='checkedMyParent(jQuery(this),1)' value='{$subCat->id}'/><div class='listbox'>{$subcatName}</div></div></li>";
								$s++; 
							}
						}
						$result .="<li id='ulChildChildT".$cat->id."'  data-t='subsub-technology' data-p='".$cat->id."' class='dd-item nested-list-item adding'><button data-action='cancel'>&nbsp;</button><div class='dd-handle nested-list-handle dd-nodrag'></div><div class='nested-list-content'><a href='javascript://' class='span-show' onclick='addMe(jQuery(this));' style='margin-left:10px'>Add Sub-Category</a><span style='display:none' class='span-edit'><input type='text' maxlength='30' style='margin-left:30px;width:39%;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' placeholder='Type here...'/><a style='margin-left:15px;' href='javascript://' onclick='addSaveMe(jQuery(this))'>Save</a><a style='margin-left:5px' href='javascript://' onclick='cancelMe(jQuery(this))'>Cancel</a><span class='span-wait' style='display:none;margin-left:5px'>Please wait...</span></span></div></li>";
						$result .="</ol>\n";
						$result .="</li>";
						$c++;
					}
				}
				$result .="<li id='ulChildT".$sec->id."'  data-t='sub-technology' data-p='".$sec->id."' class='dd-item nested-list-item adding'><button data-action='cancel'>&nbsp;</button><div class='dd-handle nested-list-handle dd-nodrag'></div><div class='nested-list-content'><a href='javascript://' class='span-show' onclick='addMe(jQuery(this));' style='margin-left:10px'>Add a Category</a><span style='display:none' class='span-edit'><input type='text' maxlength='30' style='margin-left:5px;width:39%;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' placeholder='Type here...'/><a style='margin-left:15px;' href='javascript://' onclick='addSaveMe(jQuery(this))'>Save</a><a style='margin-left:5px' href='javascript://' onclick='cancelMe(jQuery(this))'>Cancel</a><span class='span-wait' style='display:none;margin-left:5px'>Please wait...</span></span></div></li>";
				$result .="</ol>\n";
				$result .="</li>";
				$i++;
			}
		/*	$result .="<li id='ChildT' data-t='technology' data-p='21' class='dd-item nested-list-item adding'><div class='dd-handle nested-list-handle dd-nodrag'></div><div class='nested-list-content'><a href='javascript://' class='span-show' onclick='addMe(jQuery(this));' style='margin-left:10px'>Add Technology</a><span style='display:none' class='span-edit'><input type='text' maxlength='30' style='margin-left:5px;' placeholder='Type here...'/><a style='margin-left:5px;' href='javascript://' onclick='addSaveMe(jQuery(this))'>Save</a><a style='margin-left:5px' href='javascript://' onclick='cancelMe(jQuery(this))'>Cancel</a><span class='span-wait' style='display:none;margin-left:5px'>Please wait...</span></span></div></li>";*/
			$result .="</ol>\n";
		}
		return $result;
	}
}

if ( ! function_exists('buildCompanyMenu'))
{
	function buildCompanyMenu($companyID=0){
		$CI = &get_instance();
		$CI->load->model('opportunity_model');
		$CI->load->model('general_model');
		$CI->load->model('customer_model');
		$result ="";
		$allSectors = $CI->opportunity_model->getAllMarketSectorsNotOldOperating();
		$i = 1;
		$c = 1;
		$s = 1;
		$companySectors = $CI->opportunity_model->getAllCompanySectors($companyID);
		$findMyPreference = array();
		if($companyID>0){
			$findMyPreference = $CI->customer_model->findMyPreference($companyID);
			/*echo "<pre>";
			print_r($findMyPreference);*/
			
		}
		if(count($allSectors)>0){
			$result .= "<ol class=\"dd-list\" data-t=\"sector\">\n";
			foreach($allSectors as $sec){
				$checked = '';
				if($companyID>0){
					if(count($companySectors['sector'])>0){
						foreach($companySectors['sector'] as $sector){
							if($sec->id==$sector->sector_id){
								$checked='CHECKED="CHECKED"';
								break;
							}
						}
					}
				}
				$sectorName = "<span class='show-span css-label black-check'><a class='edit-btn' href='javascript://' onclick='openForEdit(jQuery(this))'>{$sec->name}</a></span><span class='edit-span' style='display:none'><input type='text' class='form-control' style='width:39%;display:inline;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' value='{$sec->name}' /><a href='javascript://' onclick='updateMe(jQuery(this));' style='margin-left:5px;'><i class='fa fa-check'></i></a><a href='javascript://' onclick='closeMe(jQuery(this));' style='margin-left:5px;'><i class='fa fa-times'></i></a><a class='btn-delete' style='margin-left:5px;' href='javascript://' onclick='deleteMe(jQuery(this))'><i class='fa fa-trash'></i></a></span>";
			$result .= "<li class='dd-item nested-list-item' data-order='{$i}' data-id='{$sec->id}' data-type='sector'><div class='dd-handle nested-list-handle dd-nodrag'></div><div class='nested-list-content' style='padding-left:0px'><a href='javascript://' onclick='addFromTop(\"ulChild{$sec->id}\",jQuery(this))'><i class='fa fa-long-arrow-down'  style='font-size:8px;'></i></a><input type='checkbox' {$checked} class='css-checkbox' name='company[sector][]' onchange='checkMeWithOther(jQuery(this))' value='{$sec->id}'/><div class='listbox'>{$sectorName}</div></div>";
				$categories =  $CI->general_model->getSectorDepartmentsName($sec->id);
				$result .= "<ol class=\"dd-list\"  data-t=\"category\" style='display:none'>\n";
				if(count($categories)>0){					
					foreach($categories as $cat){
						$checked = "";
						if(count($findMyPreference)>0){
							  foreach($findMyPreference as $pref){
								  if($pref->preference_id  == $cat->id){
									  $checked='CHECKED="CHECKED"';
									  break;
								  }
							  }
						  }
						  $catName = "<span class='show-span css-label1 black-check'><a class='edit-btn' href='javascript://' onclick='openForEdit(jQuery(this))'>{$cat->name}</a></span><span class='edit-span' style='display:none'><input type='text' class='form-control' style='width:39%;display:inline;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' value='{$cat->name}' /><a href='javascript://' onclick='updateMe(jQuery(this));' style='margin-left:5px;'><i class='fa fa-check'></i></a><a href='javascript://' onclick='closeMe(jQuery(this));' style='margin-left:5px;'><i class='fa fa-times'></i></a><a class='btn-delete' style='margin-left:5px;' href='javascript://' onclick='deleteMe(jQuery(this))'><i class='fa fa-trash'></i></a></span>";
						$result .= "<li class='dd-item nested-list-item' data-order='{$c}' data-id='{$cat->id}' data-type='category'><div class='dd-handle nested-list-handle dd-nodrag'></div>	  <div class='nested-list-content'><a href='javascript://' onclick='addFromTop(\"ulChildChild{$cat->id}\",jQuery(this))'><i class='fa fa-long-arrow-down' style='font-size:8px;'></i></a><input class='parent css-checkbox-1' type='checkbox' {$checked} name='preferences[departments][]'  onclick='checkedMyChild(jQuery(this))' value='{$cat->id}'/><div class='listbox'>{$catName}</div></div>";
						  
						$subCategory = $CI->customer_model->categoryListWithMoreThanOne($cat->id);
						$result .= "<ol class=\"dd-list sub-child\" data-t=\"subcategory\" style='display:none'>\n";
						if(count($subCategory)>0){	
							foreach($subCategory as $subCat){
								$checked = "";
								if(count($findMyPreference)>0){
									  foreach($findMyPreference as $pref){
										  if($pref->preference_id  == $subCat->id){
											  $checked='CHECKED="CHECKED"';
											  break;
										  }
									  }
								  }
								  $subcatName = "<span class='show-span'><a class='edit-btn' href='javascript://' onclick='openForEdit(jQuery(this))'>{$subCat->name}</a></span><span class='edit-span' style='display:none'><input type='text' class='form-control' style='width:39%;display:inline;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' value='{$subCat->name}' /><a href='javascript://' onclick='updateMe(jQuery(this));' style='margin-left:5px;'><i class='fa fa-check'></i></a><a href='javascript://' onclick='closeMe(jQuery(this));' style='margin-left:5px;'><i class='fa fa-times'></i></a><a class='btn-delete' style='margin-left:5px;' href='javascript://' onclick='deleteMe(jQuery(this))'><i class='fa fa-trash'></i></a></span>";
								$result .= "<li class='dd-item nested-list-item' data-order='{$c}' data-id='{$subCat->id}' data-type='subcategory'><button data-action='cancel'>&nbsp;</button><div class='dd-handle nested-list-handle dd-nodrag'></div><div class='nested-list-content'><input class='child' type='checkbox' {$checked} name='sub[departments][]' onclick='checkedMyParent(jQuery(this))' value='{$subCat->id}'/><div class='listbox'>{$subcatName}</div></div></li>";
								$s++;
							}
						}
						$result .="<li id='ulChildChild".$cat->id."' data-t='sub-category' data-p='".$cat->id."' class='dd-item nested-list-item adding'><button data-action='cancel'></button><div class='dd-handle nested-list-handle dd-nodrag'></div><div class='nested-list-content'><a href='javascript://' class='span-show' onclick='addMe(jQuery(this));' style='margin-left:10px'>Add a Sub Category</a><span style='display:none' class='span-edit'><input type='text' maxlength='30' style='margin-left:30px;width:39%;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' placeholder='Type here...'/><a style='margin-left:5px;' href='javascript://' onclick='addSaveMe(jQuery(this))'><i class='fa fa-check'></i></a><a style='margin-left:5px' href='javascript://' onclick='cancelMe(jQuery(this))'><i class='fa fa-times'></i></a><span class='span-wait' style='display:none;margin-left:5px'>Please wait...</span></span></div></li>";
						$result .="</ol>\n";
						$result .="</li>";
						$c++;
					}
				}
				$result .="<li id='ulChild".$sec->id."' data-t='category' data-p='".$sec->id."' class='dd-item nested-list-item adding'><button data-action='cancel'></button><div class='dd-handle nested-list-handle dd-nodrag'></div><div class='nested-list-content'><a href='javascript://' class='span-show' onclick='addMe(jQuery(this));' style='margin-left:10px'>Add Category</a><span style='display:none' class='span-edit'><input type='text' maxlength='30' style='width:39%;margin-left:15px;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' placeholder='Type here...'/><a style='margin-left:5px;' href='javascript://' onclick='addSaveMe(jQuery(this))'><i class='fa fa-check'></i></a><a style='margin-left:5px' href='javascript://' onclick='cancelMe(jQuery(this))'><i class='fa fa-times'></i></a><span class='span-wait' style='display:none;margin-left:5px'>Please wait...</span></span></div></li>";
				$result .="</ol>\n";
				$result .="</li>";
				$i++;
			}
			$result .="<li id='Child' data-t='sector' class='dd-item nested-list-item adding'><div class='dd-handle nested-list-handle dd-nodrag'></div><div class='nested-list-content'><a href='javascript://' class='span-show' onclick='addMe(jQuery(this));' style='margin-left:10px'>Add Sector</a><span style='display:none' class='span-edit'><input type='text' maxlength='30' style='margin-left:5px;width:39%;position:relative;top:-2px;padding:0 0 0 5px;height:20px;' placeholder='Type here...'/><a style='margin-left:5px;' href='javascript://' onclick='addSaveMe(jQuery(this))'><i class='fa fa-check'></i></a><a style='margin-left:5px' href='javascript://' onclick='cancelMe(jQuery(this))'><i class='fa fa-times'></i></a><span class='span-wait' style='display:none;margin-left:5px'>Please wait...</span></span></div></li>";
			$result .="</ol>\n";
		}
		return $result;
	}
}
if ( ! function_exists('generateRandomNumber'))
{
	function generateRandomNumber($length = 3) {
		$number = '1234567890';
		$numberLength = strlen($number);
		$randomNumber = '';
		for ($i = 0; $i < $length; $i++) {
			$randomNumber .= $number[mt_rand(0, $numberLength - 1)];
		}
		return $randomNumber;
	}
}

if ( ! function_exists('showJSONParentFamily'))
{
	function showJSONParentFamily($target,$parentData) {
		if(count($parentData)>0){
			foreach($parentData as $parent){
				echo '{source: "'.$parent['number_id'].'", target: "'.$target.'", type: "parent"},';
				echo '{source: "'.$parent['number_id'].'", target: "'.$target.'", type: "parent"},';
				$details[] = $parent['details'];
				if(count($parent['child'])>0){
					foreach($parent['child'] as $child){
						echo '{source: "'.$child['number_id'].'", target: "'.$parent['number_id'].'", type: "child"},';
						echo '{source: "'.$child['number_id'].'", target: "'.$parent['number_id'].'", type: "child"},';
						$details[] = $child['details'];
					}
				}
				if(count($parent['parent'])>0){
					showJSONParentFamily($parent['number_id'],$parent['parent']);
				}
			}
		}
	}
}
if ( ! function_exists('getArrayParentFamilyDetails'))
{
	function getArrayParentFamilyDetails($parentData) {
		$dataDetails = array();
		if(count($parentData)>0){		
			foreach($parentData as $parent){
				$det = $parent['details'];
				$det->parent_relation = $parent['parent_relation'];
				$dataDetails[] = $det;
				if(count($parent['child'])>0){
					foreach($parent['child'] as $child){
						$child['details']->parent_relation = $child['parent_relation'];
						$dataDetails[] = $child['details'];
					}
				}
				if(count($parent['parent'])>0){
					$dataDetails[] = getArrayParentFamilyDetails($parent['parent']);
				}
			}
		}
		return $dataDetails;
	}
}

if ( ! function_exists('getLeadName'))
{
	function getLeadName($serialNumber) {
		$dataDetails = array();
		$CI = &get_instance();
		$CI->load->model('lead_model');
		$dataDetails = $CI->lead_model->findSerialNumber($serialNumber);
		return $dataDetails;
	}
}
if ( ! function_exists('closetags'))
{
	function closetags($html) {
			preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
			$openedtags = $result[1];
			preg_match_all('#</([a-z]+)>#iU', $html, $result);
			$closedtags = $result[1];
			$len_opened = count($openedtags);
			if (count($closedtags) == $len_opened) {
				return $html;
			}
			$openedtags = array_reverse($openedtags);
			for ($i=0; $i < $len_opened; $i++) {
				if (!in_array($openedtags[$i], $closedtags)) {
					$html .= '</'.$openedtags[$i].'>';
				} else {
					unset($closedtags[array_search($openedtags[$i], $closedtags)]);
				}
			}
		return $html;
	}
}