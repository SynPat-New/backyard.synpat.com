<link href="https://cdnjs.cloudflare.com/ajax/libs/clusterize.js/0.18.0/clusterize.min.css"/>
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
        <th>Specialities</th>
        <th>Sectors</th>
        <th>Categories</th>
        <th>SubCategories</th>
        <th>Technologies</th>
        <th>SubTechnologies</th>
      </tr>
    </thead>
	</table>
	<div id="scrollArea" class="clusterize-scroll">
		<table>
		  <tbody id="contentArea" class="clusterize-content">
			<tr class="clusterize-no-data">
				<td>Loading data…</td>
			</tr>
		  </tbody>
		</table>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clusterize.js/0.18.0/clusterize.min.js"></script>
<script>
let rows=[];
let clusterize;
function intialClustrize(data){
	clusterize = new Clusterize({
	  rows: data,
	  scrollId: "scrollArea",
	  contentId: "contentArea"
	});
}
const formatter = new Intl.NumberFormat('en-IN');
var __baseUrl = '<?php echo $Layout->baseUrl?>',_filterSector=[],_filterType=[],_filterSubType=[],_filterTechnology=[],_filterSubTech=[],_filterUsers=[],_filterLinkedIn = "",_filterCompanyIndustry=[],_filterSpecialties = [],_filterCompanySize=[],_filterNoOfSize=[],_filterLabel="", _leadID= 0,_activity=0,p=500,_sortField = "c.company_name",_sortBy = "ASC",_selectedCompanies=[],_unselectedCompanies=[];
_url = __baseUrl+'opportunity/sales_contact_test1/'+_leadID+'/'+_activity+'/ajax/'+p;
_filters = {search:"",s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,label:_filterLabel,specialist:_filterSpecialties,start:0,end:30000,sort_field:_sortField,sort_by:_sortBy,t:true};
jQuery(document).ready(function(){
	jQuery.ajax({
		type:"POST",
		url:_url,
		data:_filters,
		cache:false,
		dataType:'json',
		success:function(b){
			if(typeof b.companies!="undefined" && b.companies.length>0){
				_data = b.companies;
				//var specialistList = [];
				rows = [];
				for(i=0;i<_data.length;i++){
					_selected = 0;
					if(b.activity==2){
						if(b.selected_acquisition_companies.length>0){
							jQuery.each(b.selected_acquisition_companies,function(index,sc){
								if(sc.id==_data[i].id){
									_selected = 1;
									return false;
								}
							});
						}
					} else {
						if(b.selected_sales_companies.length>0){
							jQuery.each(b.selected_sales_companies,function(index,sc){
								if(sc.id==_data[i].id){
									_selected = 1;
									return false;
								}
							});
						}
					}
					_sectorName = _data[i].sectorName;
					if(_sectorName==null){
						_sectorName='';
					}
					_categories = _data[i].department_names;
					if(_categories==null){
						_categories='';
					}
					_sub_categories = _data[i].sub_department_names;
					if(_sub_categories==null){
						_sub_categories='';
					}
													
					_usersCount = 0;
					if(_data[i].company_users!=null){
						_usersCount = _data[i].company_users;
					} 
					let u = {};
					u.id = _data[i].id;
					u.selected = _selected;
					u.company_name = _data[i].company_name;
					u.no_of_users = _usersCount;
					u.sectors = _sectorName;
					u.industry = _data[i].industry;
					u.specialist = _data[i].specialties;
					u.company_size = _data[i].company_size;
					u.no_of_employees = _data[i].no_of_employees;
					u.label = _data[i].label;
					u.categories = _categories;
					u.sub_category = _sub_categories;
					u.technology_names = _data[i].technology_names;
					u.sub_technology_names = _data[i].sub_technology_names;
					u.scrapped_date = _data[i].scrapped_date;
					u.scrapped_profile_date = _data[i].scrapped_profile_date;
					u.linkedin_url = _data[i].linkedin_url;
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
					if(u.specialist!=null){
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
					_tdList +="<td><div class='overwrap'>"+_subtech+"</div></td>";
					rows.push("<tr id='"+_increment+"' class='"+_addclass+"'>"+_tdList+"</tr>");
					_increment++;
					
				}	
				intialClustrize(rows);
			}
		}
	});
});
</script>