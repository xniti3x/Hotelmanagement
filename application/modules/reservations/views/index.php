<div>
    <link type="text/css" rel="stylesheet" href="../styles/css/demo.css?v=2019.3.3903" />
    <link type="text/css" rel="stylesheet" href="../styles/css/layout.css?v=2019.3.3903" />
    <link type="text/css" rel="stylesheet" href="../styles/css/elements.css?v=2019.3.3903" />
    <link type="text/css" rel="stylesheet" href="../styles/reservations/themes/scheduler_8.css" />
	<!-- helper libraries -->
	<script src="https://code.jquery.com/jquery-1.12.2.js" type="text/javascript"></script>
	<!-- daypilot libraries -->
    <script src="../styles/js/daypilot-all.min.js" type="text/javascript"></script>


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
                    dp.scrollTo(new DayPilot.Date().addDays(-5));
                    dp.days = 100;
                    loadTimeline(DayPilot.Date.today().addDays(-15));
                    dp.useEventBoxes = "Never";
                    dp.eventMoveHandling = "Disabled";
                    dp.eventResizeHandling = "Disabled";
                    dp.eventResizeHandling= "Disabled",
                    dp.eventDeleteHandling= "Disabled",
                    dp.eventHoverHandling= "Disabled",
                    dp.eventHeight = 50;
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
                                        var modal = new DayPilot.Modal();
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
                        var modal = new DayPilot.Modal();

                        modal.closed = function() {
                            dp.clearSelection();
                            loadEvents();


                        };
                        var start = args.start;
                        var end = args.end;
                        var temp=args.end.addDays(-1);
                        if(start.equals(temp)){
                            end=end.addHours(12);
                        }else{
                            start=start.addHours(14);
                            end=temp.addHours(12);
                        }

                        modal.showUrl("<?php echo site_url('reservations/new'); ?>"+"?start=" + start + "&end=" + end + "&room_id=" + args.resource);

                    };

                    dp.onEventClick = function(args) {
                        var modal = new DayPilot.Modal();
                        modal.closed = function() {
                            // reload all events
                            loadEvents();
                        };
                        //modal.showUrl("edit.php?id=" + args.e.id());
                        modal.showUrl("<?php echo site_url('reservations/edit'); ?>"+"?id=" + args.e.id());

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

                        $.post("<?php echo site_url('reservations/backend_reservations'); ?>",
                            {
                                start: start.toString(),
                                end: end.toString()
                            },
                            function(data) {
                                dp.events.list = data;
                                dp.update();
                            }
                            );

                         /* dp.events.list = [
                                {
                                    start:"2021-03-18T14:00:00",
                                    end:"2021-03-20T16:00:00",
                                    id: 1,
                                    text: "Meeting",
                                    resource: "1"
                                }
                            ];
                            dp.update();
                           */
                    }

                    function loadResources() {
                        $.get("<?php echo site_url('rooms/ajax/backend_rooms'); ?>",
                        { capacity: $("#filter").val() },
                        function(data) {
                            dp.resources = data;
                            dp.update();
                        });

                     /*   dp.resources = [
                        { name: "Room A", id: "1"},
                        { name: "Room B", id: "2" },
                        { name: "Room C", id: "3" }
                    ];
                    dp.update();
                   */
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
