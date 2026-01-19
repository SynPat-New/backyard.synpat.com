<script src='<?php echo $Layout->aws_server_cdn;?>js-init/moment.min.js'></script>
<script src='<?php echo $Layout->aws_server_cdn;?>moment-timezone-with-data-2010-2020.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js'></script>
<script src='<?php echo $Layout->aws_server_cdn;?>js-init/fullcalendar.js'></script>
<script src='<?php echo $Layout->aws_server_cdn;?>widgets/powertip/jquery.powertip.min.js'></script>
<link href='<?php echo $Layout->aws_server_cdn;?>js-init/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo $Layout->aws_server_cdn;?>widgets/powertip/jquery.powertip.min.css' rel='stylesheet' />
<!--<link href='<?php echo $Layout->awsUrl; ?>public/js-init/fullcalendar.print.css' rel='stylesheet' />-->
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/custom.css"/>
<style>
	.fc-time-grid-event .fc-time, .fc-time-grid-event .fc-title{display:inline-block;}
	#powerTip{max-width:300px;white-space:normal;background:#fff;color:#000;word-break: break-word;border:1px solid #efefef}
	#powerTip.e:before,#powerTip.se:before,#powerTip.sw:before,#powerTip.n:before{border-right:10px solid #fff;}
</style>
<script>
if(!String.linkify) {
    String.prototype.linkify = function() {

        // http://, https://, ftp://
        var urlPattern = /\b(?:https?|ftp):\/\/[a-z0-9-+&@#\/%?=~_|!:,.;]*[a-z0-9-+&@#\/%=~_|]/gim;

        // www. sans http:// or https://
        var pseudoUrlPattern = /(^|[^\/])(www\.[\S]+(\b|$))/gim;

        // Email addresses
        var emailAddressPattern = /[\w.]+@[a-zA-Z_-]+?(?:\.[a-zA-Z]{2,6})+/gim;

        return this
            .replace(urlPattern, '<a href="$&" target="_blank">$&</a>')
            .replace(pseudoUrlPattern, '$1<a href="http://$2" target="_blank">$2</a>')
            .replace(emailAddressPattern, '<a href="mailto:$&" target="_blank">$&</a>');
    };
}
	$(document).ready(function() {
		var currentTimezone = 'America/Los_Angeles';

		// load the list of available timezones
	/*	$.getJSON('<?php echo $Layout->baseUrl?>public/upload/user_event.json', function(users) {
			jQuery("#timezone-selector").empty();
			$.each(users, function(i, user) {
				_name = '<span><span style="background-color:'+user.backgroundColor+';color:'+user.color+';width:15px;height:15px;display:inline-block;"></span>&nbsp;'+user.name+'</span>';
			_d = $("<li/>").html(_name).attr('value', user.id);
			jQuery("#timezone-selector").append(_d);
			});
		});
*/
		// when the timezone selector changes, rerender the calendar
		$('#timezone-selector').on('change', function() {
			/*currentTimezone = this.value || false;
			$('#calendar').fullCalendar('destroy');
			renderCalendar();*/
		});
		_date = new Date();
		function popupStr(calEvent){
			title = calEvent.title;
			return '<h4 class="event_start">Time: '+moment(new Date(calEvent.start)).tz('America/Los_Angeles').format('MM/DD/YYYY HH:mm A')+'</h4><div class="event_divider"><p class="event_desc">'+title.linkify()+'</p><p><a class="event_link" href="'+calEvent.htmlLink+'" target="_blank">View Event &raquo;</a></p></div>';
		}
		function renderCalendar() {
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				defaultView: 'agendaWeek',
				defaultDate: _date,
				handleWindowResize:false,
				timezone: currentTimezone,
				allDayDefault:false,
				hiddenDays:[0,6],
				minTime: "08:00:00",
				maxTime: "21:00:00",
				editable: false,
				selectable: true,
				eventLimit: true, // allow "more" link when too many events
				eventTextColor:'#000',
				events: {
					url: '<?php echo $Layout->baseUrl?>public/upload/events.json',
					error: function() {
						$('#script-warning').show();
					},
					success: function()
					{
						console.log("successfully loaded");
					}
				},
				loading: function(bool) {
					/*$('#loading').toggle(bool);*/
				},
				eventRender: function(event, el) {
					// render the timezone offset below the event title
					if (event.start.hasZone()) {
						el.find('.fc-title').after(
							/*$('<div class="tzo"/>').text(event.start.format('Z'))*/
						);
					}
					el.powerTip({
                        placement: 'e',
                        smartPlacement: true,
                        mouseOnToPopup: true,
                        offset: 5
                    });
				},
				eventMouseover: function(calEvent, jsEvent, view){
                    $('.fc-event').data('powertip', popupStr(calEvent));
                },
				eventClick: function(calEvent, jsEvent, view) {
					jQuery.ajax({
						type:'POST',
						url:'<?php echo $Layout->baseUrl?>users/getCalendarEvent',
						data:{event_id:calEvent.event_id},
						dataType:'json',
						success:function(d){
							if(typeof d.summary!="undefined"){
								window.parent.jQuery('#frm_calendar_event').find("#eventSummary").val(d.summary);
								window.parent.jQuery('#frm_calendar_event').find("#eventStartDate").val(moment(new Date(d.start_time)).tz('America/Los_Angeles').format('MM/DD/YYYY'));
								window.parent.jQuery('#frm_calendar_event').find("#eventStartTime").val(moment(new Date(d.start_time)).tz('America/Los_Angeles').format('HH:mm A'));
								window.parent.jQuery('#frm_calendar_event').find("#eventEndDate").val(moment(new Date(d.end_time)).tz('America/Los_Angeles').format('MM/DD/YYYY'));
								window.parent.jQuery('#frm_calendar_event').find("#eventEndTime").val(moment(new Date(d.end_time)).tz('America/Los_Angeles').format('HH:mm A'));
								if(typeof d.attendes!="undefined" && d.attendes.length){
									_attendies = [];
									jQuery.each(d.attendes,function(i,atten){
										_attendies.push(atten.email);
									});
									_list = _attendies.join(',');
									if(_list.length>0){
										window.parent.jQuery('#frm_calendar_event').find("#attendeeEmail").val(_list+',  ');
									}
								}
								window.parent.jQuery('#frm_calendar_event').find("#eventDescription").val(d.description);
								window.parent.jQuery('#frm_calendar_event').find("#eventLocation").val(d.location);
								window.parent.jQuery('#frm_calendar_event').find("#eventId").val(d.id);
							}
						}
					});
				 },
				dayClick: function(date) {
					console.log('dayClick', date.format());
				},
				select: function(startDate, endDate) {
					console.log('select', startDate.format(), endDate.format());
				}
			});
		}

		renderCalendar();
	});

</script>
<style>

	body {
		margin: 0;
		padding: 0;
		font-family: Arial;
		font-size: 14px;
	}

	#top {
		background: #eee;
		/*border-bottom: 1px solid #ddd;*/
		padding: 0 10px;
		line-height: 40px;
		font-size: 12px;
	}
	.left { float: left }
	.right { float: right }
	.clear { clear: both }

	#script-warning, #loading { display: none }
	#script-warning { font-weight: bold; color: red }

	#calendar {
		padding: 0 10px;
	}

	.tzo {
		color: #000;
	}

</style>
</head>
<body style='padding-top:10px;'>

	<div id='top'>
		<div class='right'>
			<span id='loading'>loading...</span>
		</div>
		<div class='clear'></div>
	</div>
	<div class='left' style="width:100%;padding-top:10px;">
		<div class='left' style="width:100%;text-align:center;">
			<div id='calendar'></div>
		</div>
	</div>
	
	<style>
.form-flat .form-group.input-string-group{border-bottom:1px solid #dfe8f1 !important;}
.form-flat .form-control:focus{border-color:#dfe8f1 !important;}
.table > thead > tr > th, .table > tbody > tr > td{border-color:#dfe8f1 !important}
</style>

</body>