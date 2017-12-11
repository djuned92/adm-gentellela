<div class="page-title">
    <div class="title_left">
        <h3>Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Dashboard</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="chart_div" style="width: 900px; height: 400px;"></div>
                <hr/>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pintu Air</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach($pintu_air as $key => $value): ?>
                        <tr>
                            <td><?=$i++?></td>
                            <td><?=$value['gaugeNameId']?></td>
                            <td><?=$value['measureDateTime']?></td>
                            <td><?=$value['warningNameId']?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
      
   function drawChart() {
        /*
        * SteppedAreaChart
        var data = google.visualization.arrayToDataTable([
        ['<?=$tanggal[0]?>','<?=$tanggal[1]?>','<?=$tanggal[2]?>','<?=$tanggal[3]?>'],
        ['<?=$measureDateTime[1][0]?>',<?=$measureDateTime[1][1]?>,<?=$measureDateTime[1][2]?>,<?=$measureDateTime[1][3]?>],
        ['<?=$measureDateTime[2][0]?>',<?=$measureDateTime[2][1]?>,<?=$measureDateTime[2][2]?>,<?=$measureDateTime[2][3]?>],
        ['<?=$measureDateTime[3][0]?>',<?=$measureDateTime[3][1]?>,<?=$measureDateTime[3][2]?>,<?=$measureDateTime[3][3]?>],
        ['<?=$measureDateTime[4][0]?>',<?=$measureDateTime[4][1]?>,<?=$measureDateTime[4][2]?>,<?=$measureDateTime[4][3]?>],
        ['<?=$measureDateTime[5][0]?>',<?=$measureDateTime[5][1]?>,<?=$measureDateTime[5][2]?>,<?=$measureDateTime[5][3]?>],
        ['<?=$measureDateTime[6][0]?>',<?=$measureDateTime[6][1]?>,<?=$measureDateTime[6][2]?>,<?=$measureDateTime[6][3]?>],
        ['<?=$measureDateTime[7][0]?>',<?=$measureDateTime[7][1]?>,<?=$measureDateTime[7][2]?>,<?=$measureDateTime[7][3]?>],
        ['<?=$measureDateTime[8][0]?>',<?=$measureDateTime[8][1]?>,<?=$measureDateTime[8][2]?>,<?=$measureDateTime[8][3]?>],
        ['<?=$measureDateTime[9][0]?>',<?=$measureDateTime[9][1]?>,<?=$measureDateTime[9][2]?>,<?=$measureDateTime[9][3]?>],        
        ['<?=$measureDateTime[10][0]?>',<?=$measureDateTime[10][1]?>,<?=$measureDateTime[10][2]?>,<?=$measureDateTime[10][3]?>],
        ['<?=$measureDateTime[11][0]?>',<?=$measureDateTime[11][1]?>,<?=$measureDateTime[11][2]?>,<?=$measureDateTime[11][3]?>],
        ]);

        var options = {
          title: 'Pintu Air',
          vAxis: {title: 'Status Pintu Air'},
          isStacked: true
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart_div'));
        */
        var data = google.visualization.arrayToDataTable([
          ['<?=$tanggal[0]?>', '<?=$measureDateTime[0][0]?>', '<?=$measureDateTime[1][0]?>', '<?=$measureDateTime[2][0]?>',
                                '<?=$measureDateTime[3][0]?>', '<?=$measureDateTime[4][0]?>', '<?=$measureDateTime[5][0]?>',
                                '<?=$measureDateTime[6][0]?>', '<?=$measureDateTime[7][0]?>', '<?=$measureDateTime[8][0]?>',
                                '<?=$measureDateTime[9][0]?>', '<?=$measureDateTime[10][0]?>', '<?=$measureDateTime[11][0]?>'
          ],
          ['<?=$tanggal[3]?>',  <?=$measureDateTime[0][3]?>, <?=$measureDateTime[1][3]?>, <?=$measureDateTime[2][3]?>,
                                <?=$measureDateTime[3][3]?>, <?=$measureDateTime[4][3]?>, <?=$measureDateTime[5][3]?>,
                                <?=$measureDateTime[6][3]?>, <?=$measureDateTime[7][3]?>, <?=$measureDateTime[8][3]?>,
                                <?=$measureDateTime[9][3]?>, <?=$measureDateTime[10][3]?>, <?=$measureDateTime[11][3]?>

          ],
          ['<?=$tanggal[2]?>',  <?=$measureDateTime[0][2]?>, <?=$measureDateTime[1][2]?>, <?=$measureDateTime[2][2]?>,
                                <?=$measureDateTime[3][2]?>, <?=$measureDateTime[4][2]?>, <?=$measureDateTime[5][2]?>,
                                <?=$measureDateTime[6][2]?>, <?=$measureDateTime[7][2]?>, <?=$measureDateTime[8][2]?>,
                                <?=$measureDateTime[9][2]?>, <?=$measureDateTime[10][2]?>, <?=$measureDateTime[11][2]?>

          ],
          ['<?=$tanggal[1]?>',  <?=$measureDateTime[0][1]?>, <?=$measureDateTime[1][1]?>, <?=$measureDateTime[2][1]?>,
                                  <?=$measureDateTime[3][1]?>, <?=$measureDateTime[4][1]?>, <?=$measureDateTime[5][1]?>,
                                  <?=$measureDateTime[6][1]?>, <?=$measureDateTime[7][1]?>, <?=$measureDateTime[8][1]?>,
                                  <?=$measureDateTime[9][1]?>, <?=$measureDateTime[10][1]?>, <?=$measureDateTime[11][1]?>
          ],
        ]);

        var options = {
          title: 'Pintu Air Depth',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
          chart.draw(data, options);
    }

</script>