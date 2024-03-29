<div>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>/custom_assets/styles/css/layout.css?v=2019.3.3903" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>/custom_assets/styles/css/elements.css?v=2019.3.3903" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>/custom_assets/styles/themes/scheduler_8.css" />
	<!-- helper libraries -->
	<!-- daypilot libraries -->
    <script src="<?php echo base_url(); ?>/custom_assets/styles/js/daypilot-all.min.js" type="text/javascript"></script>

</script> 
                    <div id="dp" style="z-index:1;"></div>
                    <div class="space">
                        <!-- <a href="#" id="add-room">Add Room</a> -->
                        <a href="javascript:window.location.href=window.location.href" id="reload">RELOAD</a>
                    </div>

                <script>
                    var dp = new DayPilot.Scheduler("dp");
                    dp.theme = "scheduler_8";
                    dp.cellWidth = 70;
                    dp.allowEventOverlap = true;
                    dp.locale= "de-de";
                    dp.scale = "Day";
                    dp.scrollTo(new DayPilot.Date().addDays(-1));
                    dp.days = 100;
                    loadTimeline(DayPilot.Date.today().addDays('-<?php echo $this->mdl_settings->get("rs_history_days"); ?>'));
                    dp.useEventBoxes = "Never";
                    dp.eventMoveHandling = "Disabled";
                    dp.eventResizeHandling = "Disabled";
                    dp.eventDeleteHandling= "Disabled",
                    dp.eventHoverHandling= "Disabled",
                    dp.eventHeight = 50;
                    var modal = new DayPilot.Modal();
                        modal.autoStretch = true;
                        modal.width=$(window).width();
                        modal.height=$(window).height()-50;                   
                        modal.theme="modal_min";
                        modal.closed = function() {
                            dp.clearSelection();
                            loadEvents();
                        };
                    //dp.bubble = new DayPilot.Bubble({});
                    //dp.startDate = new DayPilot.Date().firstDayOfMonth();
                    //dp.eventClickHandling="Disabled",
                    dp.timeHeaders = [
                      {"groupBy":"Month"},{"groupBy":"Day","format":"ddd d"}
                    ];
                    dp.rowHeaderColumns = [
                        {title: "Room", width: 40}
                    ];
                    dp.separators = [
                        { location: new DayPilot.Date(), color: "red" }
                    ];
                    dp.onBeforeResHeaderRender = function(args) {
                        args.resource.areas = [{
                                    top:3,
                                    right:4,
                                    height:14,
                                    width:14,
                                    action:"JavaScript",
                                    js: function(r) {
                                        
                                        modal.onClosed = function(args) {
                                            loadResources();
                                        };
                                        modal.showUrl("room_edit.php?id=" + r.id);
                                    },
                                    v:"Hover",
                                    css:"icon icon-edit",
                                }];
                    };
                    dp.onTimeRangeSelected = function (args) {
                        dp.clearSelection();
                    };

                    dp.onBeforeCellRender = function(args) {
                        if (args.cell.start.getDayOfWeek() === 0 || args.cell.start.getDayOfWeek() === 6) {
                            args.cell.bgColor = "#eee";
                        }
                    };
                    dp.onBeforeEventRender = function(args) {
                        var start = new DayPilot.Date(args.e.start);
                        var end = new DayPilot.Date(args.e.end);
                        var today = DayPilot.Date.today();
                        var now = new DayPilot.Date();
                        args.e.html = args.e.name;
                        args.e.barColor = args.e.bgcolor;
                    };


                    dp.init();

                    loadResources();
                    loadEvents();

                    function loadTimeline(date) {
                        dp.scale = "Manual";
                        dp.timeline = [];
                        var start = date.getDatePart().addHours(0);

                        for (var i = 0; i < dp.days; i++) {
                            dp.timeline.push({start: start.addDays(i), end: start.addDays(i+1)});
                        }
                        dp.update();
                    }

                    function loadEvents() {
                        var start = dp.visibleStart();
                        var end = dp.visibleEnd();

                        $.post("<?php echo site_url('guest/get/getBackendReservationsAsItem/'.$this->mdl_settings->get('cron_key')); ?>",
                            {
                                start: start.toString(),
                                end: end.toString()
                            },
                            function(data) {
                                
                                dp.events.list = data;
                                dp.update();
                            }
                            );
                    }

                    function loadResources() {
                        $.get("<?php echo site_url('guest/get/backend_rooms/'.$this->mdl_settings->get('cron_key')); ?>",
                        { capacity: $("#filter").val() },
                        function(data) {
                            dp.resources = data;
                            dp.update();
                        });
                    }
                    $(document).ready(function() {
                        $("#filter").change(function() {
                            loadResources();
                        });
                    });
                </script>
            <div class="clear">
            </div>
</div>

