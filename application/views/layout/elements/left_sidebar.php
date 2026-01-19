<div id="page-sidebar">
<div class="scroll-sidebar">
<ul id="sidebar-menu">
<?php if((int)$this->session->userdata['type']==9):?>
<li>
<a href="#" title="General Settings">
<i class="glyph-icon icon-linecons-diamond"></i>
<span>General Settings</span>
</a>
<div class="sidebar-submenu" style="height:300px;overflow-y:scroll;">
<ul>
<li><?php echo anchor('javascript://','<span>Forms Data</span>', array('title' => 'Forms Data','onclick'=>"getSectorsPage('general/forms_data')"));?></li>
<li><?php echo anchor('javascript://','<span>Transaction</span>', array('title' => 'Transaction','onclick'=>"getSectorsPage('general/transaction')"));?></li>
<li><?php echo anchor('javascript://','<span>Document Selections</span>', array('title' => 'Manage Opportunites Type','onclick'=>"getSectorsPage('general/manage_opportunity_type')"));?></li>
<li><?php echo anchor('javascript://','<span>Manage Sectors / Categories</span>', array('title' => 'Manage Sectors / Categories','onclick'=>"getSectorsPage('general/manage_sectors')"));?></li>
<li><?php echo anchor('javascript://','<span>Manage User</span>', array('title' => 'Manage User','onclick'=>"getSectorsPage('general/add_user')"));?></li>
<li><?php echo anchor('javascript://','<span>Users Activities</span>', array('title' => 'All Activity List','onclick'=>"getSectorsPage('general/user_activities')"));?></li>
<li><?php echo anchor('javascript://','<span>Users Timelines</span>', array('title' => 'All Activity List','onclick'=>"getSectorsPage('general/user_timeline')"));?></li>
<li><?php echo anchor('javascript://','<span>Users Timelines(Table View)</span>', array('title' => 'All Activity List','onclick'=>"getSectorsPage('general/user_timeline_table')"));?></li>
<li><?php echo anchor('javascript://','<span>Manage Leads</span>', array('title' => 'Manage Leads','onclick'=>"getSectorsPage('general/manage_leads')"));?></li>
<li><?php echo anchor('javascript://','<span>Manage Stages</span>', array('title' => 'Manage Button Stages','onclick'=>"getSectorsPage('general/manage_stages')"));?></li>
<li><?php echo anchor('javascript://','<span>Manage Task</span>', array('title' => 'Manage Task','onclick'=>"getSectorsPage('general/manage_task')"));?></li>
<li><?php echo anchor('javascript://','<span>Manage Button List</span>', array('title' => 'Manage Button List','onclick'=>"getSectorsPage('general/button_boxes')"));?></li>
<li><?php echo anchor('javascript://','<span>Manage Text Templates</span>', array('title' => 'Manage Text Templates','onclick'=>"getSectorsPage('general/email_templates')"));?></li>
<?php /*<li><?php echo anchor('general/manage_technologies','<span>Manage Technologies</span>', array('title' => 'Manage Technologies'));?></li>
<li><?php echo anchor('general/user_permissions','<span>User Permissions</span>', array('title' => 'User Permissions'));?></li>
<li><?php echo anchor('general/create_an_opportunity','<span>Manage Opportunity</span>', array('title' => 'Manage Opportunity'));?></li>*/?> 
<?php /*<li><?php echo anchor('general/customer_request','<span>Store Customer Request</span>', array('title' => 'Store Customer Request'));?></li>
<li><?php echo anchor('customers/companies_list','<span>Store Customer List</span>', array('title' => 'Store Customer List'));?></li> */?>
</ul>
</div>
</li>
<?php endif; ?>
</ul>
</div>
</div>