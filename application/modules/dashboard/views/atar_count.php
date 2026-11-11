<div class="card">
    <div class="card-header">
        
        <h3 class="card-title">ATAR Report For <?php echo date('Y') ?> </h3>
    </div>
    <div class="card-body">
        <div id="chartdiv" style="width: 100%; height: 460px;"></div>

    </div>
</div>

<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }

</style>

<script>
    $(document).ready(function () {
        var chart = AmCharts.makeChart("chartdiv", {
            "theme": "none",
            "type": "serial",
            "startDuration": 2,
            "dataProvider": <?php echo $atarCountdata;?>,
            "valueAxes": [{
                    "position": "left",
                    "axisAlpha": 1,
                    "gridAlpha": 0.2,
                    "title": "Action Tracking & Recording (ATAR) Register"
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
            

        }, 0);
    });
</script>

