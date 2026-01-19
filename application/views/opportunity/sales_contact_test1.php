<script>
_companiesINString = [];
_companiesINString=[<?php
		$insertID = array();
		for ($i = 0; $i < count($companies); $i++) {
			if(!in_array((int)$companies[$i]->id,$insertID)):
			$insertID[] = (int)$companies[$i]->id;
			$selected = 0;
			$usersCount = 0;
			if($companies[$i]->company_users!=null){
				$usersCount = $companies[$i]->company_users;
			}
			$specialist = $companies[$i]->specialties;
			echo "{'id':". $companies[$i]->id.",'company_size':".$companies[$i]->company_size.",'specialist':".$specialist.",'industry':".$companies[$i]->industry.",'selected':".$selected.",'company_name':'" . addslashes($companies[$i]->company_name) . "','no_of_users':'" . $usersCount . "','sectors':'" . $companies[$i]->sectorName . "','categories':'" . $companies[$i]->department_names . "','sub_category':'" . $companies[$i]->sub_department_names . "','scrapped_date':'".$companies[$i]->scrapped_date."','linkedin_url':'".$companies[$i]->linkedin_url."'}";
			if ($i < count($companies) - 1) {
				echo ",";
			}
			endif;
		}
	?>];
rows = [];
for(i=0;i<_companiesINString.length;i++){
	u = _companiesINString[i];
	_checked="";
	_addclass = "main master";
	_addclass1 = "";
	if(u.selected==1){
		_addclass = "main selt";
		_addclass1 = "selt1";
		_checked="checked='checked'";
	}
	_color = "";
	_cName = u.company_name;
	_cName = _cName.toLowerCase();
	_v1 = "";
	_v1 = _v1.toLowerCase();
	if(_v1!="" && _cName.indexOf(_v1)>=0){
	   _color = 'yellow';
	}
	_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.openCompanyEdit("+u.id+")'>"+u.company_name+"</a>";
	/*General*/
	cDate = u.scrapped_date;
	if(cDate=='0000-00-00'){
		cDate = u.scrapped_profile_date;
	}
	if(cDate=='0000-00-00'){
		cDate = "Scrape";
	} else {
		cDate = moment(new Date(cDate)).format('MM/DD/YY');
	}
	_anchor = "<a class='scrape_date' href='javascript://' onclick='scrapeOnRun(jQuery(this))'>"+cDate+"</a>";
	_check = "";
	if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
		_check = "CHECKED='CHECKED'";
		if(_unselectedCompanies.length>0 && _unselectedCompanies.indexOf(u.id)>=0){
			_check = "";
		}
	} else {
		if(_selectedCompanies.length>0 && _selectedCompanies.indexOf(u.id)>=0){
			_check = "CHECKED='CHECKED'";
		}
	}
	
	_tdList = "";
	_tdList +="<td><input type='checkbox' name='vendor_select_bulk[]' class='checker' "+_checked+" value='"+u.id+"' onchange='checkedMe(jQuery(this))'/></td>";
	_tdList +="<td><input type='checkbox' name='general_select_bulk[]' "+_check+" class='general' value='"+u.id+"' data-linkedin='"+u.linkedin_url+"' onclick='selectedMe(jQuery(this))'/> "+_anchor+"</td>";
	_tdList +="<td class='merger'><input type='checkbox'  class='merger_chk' value='"+u.id+"' /></td>";
	_tdList +="<td class='survivor'><input type='checkbox' class='survivor_chk' value='"+u.id+"' /></td>";
	if(_color!=""){
		_tdList +="<td style='background-color:"+_color+"'>"+_htmlName+"</td>";
	} else {
		_tdList +="<td>"+_htmlName+"</td>";
	}
	_l  = (u.label==1)?'<i class="fa fa-exclamation"></i>':'';
	_tdList +="<td>"+_l+"</td>";
	_tdList +="<td>"+u.no_of_users+"</td>";

	_linkedIN = u.linkedin_url;
	if(_linkedIN.indexOf('linkedin')>=0){
		_linkedIN = "In";
	}
	noOfEmployees = u.no_of_employees;
	_tdList +="<td>"+formatter.format(noOfEmployees)+"</td>";
	_tdList +="<td>"+u.company_size+"</td>";
	_tdList +="<td><div class='overwrap' title='"+u.industry+"'>"+u.industry+"</div></td>";
	/*if(u.specialist!=null){
		_tdList +="<td><div class='overwrap' title='"+u.specialist+"'>"+u.specialist+"</div></td>";
	} else {
		_tdList +="<td><div class='overwrap' title=''></div></td>";
	}
	
	_tdList +="<td>"+u.sectors+"</td>";
	_cat = u.categories;
	if(_cat==undefined || _cat==false){
		_cat = "";
	}
	_cat = _cat.toString().split(',').join('<br/>');
	_tdList +="<td><div class='overwrap'>"+_cat+"</div></td>";
	_subcat = u.sub_category;
	if(_subcat==undefined || _subcat==false){
		_subcat = "";
	}
	_subcat = _subcat.toString().split(',').join('<br/>');
	_tdList +="<td><div class='overwrap'>"+_subcat+"</div></td>";
	_tech = u.technology_names;
	if(_tech==undefined || _tech==false){
		_tech = "";
	}
	_tdList +="<td><div class='overwrap'>"+_tech+"</div></td>";
	_subtech = u.sub_technology_names;
	if(_subtech==undefined || _subtech==false){
		_subtech = "";
	}					
	_tdList +="<td><div class='overwrap'>"+_subtech+"</div></td>";*/	
	rows.push("<tr id='"+_increment+"' class='"+_addclass+"'>"+_tdList+"</tr>");
	_increment++;
}
	</script>
<link href="<?php echo $Layout->baseUrl?>/public/clusterize/clusterize.css"/>
<div class="clusterize">
	<table>
    <thead>
      <tr>
        <th>Invited</th>
        <th>General</th>
        <th>Merging</th>
        <th>Survivor</th>
        <th>Company</th>
        <th>Users</th>
        <th>Lin</th>
        <th>Size</th>
        <th>Industry</th>
      </tr>
    </thead>
	</table>
	<div class="clusterize-scroll emulate-progress" id="playgroundScroll">
		<table>
		  <tbody id="playgroundContent" class="clusterize-content" tabindex="0" style="counter-increment: clusterize-counter 0;"></tbody>
		</table>
	</div>
</div>
<script src="<?php echo $Layout->baseUrl?>/public/clusterize/jquery.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script src="<?php echo $Layout->baseUrl?>/public/clusterize/clusterize.js"></script>
<script>
let rows=[];
const formatter = new Intl.NumberFormat('en-IN');
var __baseUrl = '<?php echo $Layout->baseUrl?>',_filterSector=[],_filterType=[],_filterSubType=[],_filterTechnology=[],_filterSubTech=[],_filterUsers=[],_filterLinkedIn = "",_filterCompanyIndustry=[],_filterSpecialties = [],_filterCompanySize=[],_filterNoOfSize=[],_filterLabel="", _leadID= 0,_activity=0,p=500,_sortField = "c.company_name",_sortBy = "ASC",_selectedCompanies=[],_unselectedCompanies=[],_increment=0;
_url = __baseUrl+'opportunity/sales_contact_test1/'+_leadID+'/'+_activity+'/ajax/'+p;
_filters = {search:"",s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,label:_filterLabel,specialist:_filterSpecialties,start:0,end:30000,sort_field:_sortField,sort_by:_sortBy,t:true};
</script>
<script src="<?php echo $Layout->baseUrl?>/public/clusterize/support.js"></script>