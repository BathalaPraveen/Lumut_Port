  
<style type="text/css">
.info-box{

box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset !important;
}
</style>


<div class="card">
    <div class="card-header">
        
        <h3 class="card-title">Incident Report For <?php echo date('Y') ?> </h3>
    </div>
    <div class="card-body">

        <div id="chartdivs" style="width: 100%; height: 460px;"></div>

    </div>
</div>

<style>
    #chartdivs {
        width: 100%;
        height: 500px;
    }

</style>

<script>
    $(document).ready(function () {
        var chart = AmCharts.makeChart("chartdivs", {
            "theme": "none",
            "type": "serial",
            "startDuration": 2,
            "dataProvider": <?php echo $incidentCounts;?>,
            "valueAxes": [{
                    "position": "left",
                    "axisAlpha": 1,
                    "gridAlpha": 0.2,
                    "title": "Incident report"
                }],
            "graphs": [{
                    "balloonText": "[[category]]: <b>[[value]]</b>",
                    "colorField": "color",
                    "fillAlphas": 0.85,
                    "lineAlpha": 0.1,
                    "type": "column",
                    "topRadius": 1,
                    "valueField": "count"
                }],
            "depth3D": 40,
            "angle": 30,

            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "month",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "gridAlpha": 0,
                "rotation": 270,
                "autoRotateAngle": 45,
                "labelRotation": 45,

                "autoGridCount": false,
                "gridCount": 12


            },
            "export": {
                "enabled": true
            },
               "listeners": [{
                "event": "clickGraphItem",
                "method": function(event) {
                    var terminal = $("#terminal").val() || '';
                    console.log(terminal);
                    var year = $("#year").val() || new Date().getFullYear();
                    var from_date = '<?php echo $from_date; ?>';
                    var to_date = '<?php echo $to_date; ?>';
                    var month = event.item.category;
                    var url = "incident?month=" + encodeURIComponent(month) + "&year=" + year+"&terminal="+terminal+"&from_date="+from_date+"&to_date="+to_date;
                    // var url = "incident?Month=" + encodeURIComponent(month) + "&Year=" + year;
                    // Redirect to the URL
                    window.location.href = url;
                }
            }],

        }, 0);
    });
</script>

