<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Intervention Wise Report For 2020</h3>
    </div>
    <div class="box-body">
        <?php
        $param = array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'form'
        );
        echo form_open_multipart('', $param);
        ?>

        <?php echo form_close(); ?>
        <div id="chartdivinter" style="width: 100%; height: 460px;"></div>
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
        var chart = AmCharts.makeChart("chartdivinter", {
            "type": "pie",
            "theme": "none",
            "innerRadius": "40%",
            //"gradientRatio": [-0.4, -0.4, -0.4, -0.4, -0.4, -0.4, 0, 0.1, 0.2, 0.1, 0, -0.2, -0.5],
            "dataProvider": <?php echo $InterVentionCount; ?>,
            "colors": ['red', 'green','blue','black'],
            "balloonText": "[[value]]",
            "valueField": "count",
            "titleField": "category",
            "balloon": {
                "drop": true,
                "adjustBorderColor": false,
                "color": "#FFFFFF",
                "fontSize": 16
            },
            "export": {
                "enabled": true
            },
            "legend": {
                "position": "top",
                "marginRight": 20,
                "autoMargins": false,
                "valueWidth": 10,
                "markerLabelGap": 5
            }
        });

    });
</script>

