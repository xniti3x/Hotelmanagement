document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        dateClick: function(info) {  
        var options = {
            url: "<?php echo site_url('employee/requestViewAdd'); ?>"+"/"+(new Date(info.dateStr).toISOString().slice(0, 10)),
            title:'Add Timesheet',
            buttons: [
                {text: 'save', style: 'primary',   close: true, click: function(e){
                        $.post("<?php echo site_url('employee/addTimesheet'); ?>",{
                            day: $('#day').val(),
                            start: $('#start').val(),
                            end: $('#end').val(),      
                            notes: $('#notes').val(), 
                        },
                        function (data) {
                            data=JSON.parse(data);
                            if(data.status==200) {
                                $.toaster({ priority : 'success',message : data.message });
                            }
                            if(data.status==400) {
                                $.toaster({ priority : 'danger',message : data.message });
                            }
                            calendar.refetchEvents();
                        });
                    } 
                },
                {text: 'cancel', style: 'default', close: true, click: function(e){console.log(e);} }
            ]
        };
        eModal.ajax(options);
        },
        eventClick: function(info){
        var options = {
            url: "<?php echo site_url('employee/requestViewEdit'); ?>"+"/"+info.event.id,
            title:'Edit Timesheet',
            buttons: [
                {text: 'delete', style: 'danger pull-left', close: true, click: function(e){
                    $.post("<?php echo site_url('employee/deleteTimesheet/'); ?>"+info.event.id,{
                        day: $('#day').val(),
                        start: $('#start').val(),
                        end: $('#end').val(),      
                        notes: $('#notes').val(), 
                    },
                    function (data) {
                        data=JSON.parse(data);
                        if(data.status==200) {
                            $.toaster({ priority : 'success',message : data.message });
                        }
                        if(data.status==400) {
                            $.toaster({ priority : 'danger',message : data.message });
                        }
                        calendar.refetchEvents();
                    });
                } },
                {text: 'save', style: 'primary',   close: true, click: function(e){
                    $.post("<?php echo site_url('employee/editTimesheet/'); ?>"+info.event.id,{
                        day: $('#day').val(),
                        start: $('#start').val(),
                        end: $('#end').val(),      
                        notes: $('#notes').val(), 
                    },
                    function (data) {
                        data=JSON.parse(data);
                            if(data.status==200) {
                                $.toaster({ priority : 'success',message : data.message });
                            }
                            if(data.status==400) {
                                $.toaster({ priority : 'danger',message : data.message });
                            }
                            calendar.refetchEvents();
                    });
                 } 
                },
                {text: 'cancel', style: 'default', close: true, click: function(e){console.log(e);} }
            ]
        };
        eModal.ajax(options);
        },
        initialView: 'dayGridMonth',
        events: '<?php echo site_url("employee/loadTimesheetEvents"); ?>',
        headerToolbar: { left:'today',center:'title',right:'prev,next' }, // timeGridWeek,buttons for switching between views
        footerToolbar: { left: 'dayGridMonth,listMonth',center:'myCustomButton' },
        eventTimeFormat:{
            hour: 'numeric',
            minute: '2-digit',
            meridiem: false,
            hour12: false
        },
        buttonText: {
            listMonth: '<?php _trans("list_month"); ?>',
        },
        locale: 'de',
        eventColor: 'green',
        customButtons: {
        myCustomButton: {
        text: 'Bericht PDF',
            click: function(e) {
                var options = {
                    url: "<?php echo site_url('employee/requestViewReport'); ?>",
                    title:'Report Timesheet - Zeitraum',
                    buttons: [
                        {text: 'PDF Report', style: 'warning',   close: true, click: function(e){
                            $.post("<?php echo site_url('employee/requestGenerate_pdf/'); ?>",{
                                start: $('#start').val(),
                                end: $('#end').val(),      
                            },
                            function (data) {
                                data=JSON.parse(data);
                                    if(data.status==200) {
                                        window.open("<?php echo site_url('employee/generate_pdf'); ?>"+"/"+$('#start').val()+"/"+$('#end').val(), '_blank');
                                    }
                                    if(data.status==400) {
                                        $.toaster({ priority : 'danger',message : data.message });
                                    }
                            });
                            } 
                        },
                        {text: 'cancel', style: 'default', close: true, click: function(e){console.log(e);} }
                    ]
                };
                eModal.ajax(options);
            }
        }
    },
});
    calendar.render();
});    
$('html > head').append('<style>.fc-daygrid-dot-event .fc-event-title {display:none;}</style>'); //hidde event title