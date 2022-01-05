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
                            console.log(data);
                            if(data==200) window.parent.closeModal();
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
                        console.log(data);
                        if(data==200) window.parent.closeModal();
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
                        console.log(data);
                        if(data==200) window.parent.closeModal();
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
        events: '<?php echo base_url("employee/loadTimesheetEvents"); ?>',
        headerToolbar: { left:'today',center:'title',right:'prev,next' }, // timeGridWeek,buttons for switching between views
        footerToolbar: { left: 'dayGridMonth,listWeek',center:'myCustomButton' },
        eventTimeFormat:{
            hour: 'numeric',
            minute: '2-digit',
            meridiem: false,
            hour12: false
        },
        locale: 'de',
        eventColor: 'green',
        customButtons: {
        myCustomButton: {
        text: 'Bericht PDF',
            click: function(e) {
                console.log(e,'clicked the custom button!');
                
            }
        }
    },
});
    calendar.render();
});    
$('html > head').append('<style>.fc-daygrid-dot-event .fc-event-title {display:none;}</style>'); //hidde event title