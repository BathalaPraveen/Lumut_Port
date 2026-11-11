<style>
  /* card */

  /* TOP CARDS */

.external-card {
    background: linear-gradient(135deg, #007bff, #00c6ff);
    color: #fff;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.internal-card {
    background: linear-gradient(135deg, #28a745, #6ddf8b);
    color: #fff;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}


/* BOTTOM TOTAL CARDS */

.external-card-dark {
    background: linear-gradient(135deg, #0b5cad, #1295d8);
    color: #fff;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.internal-card-dark {
    background: linear-gradient(135deg, #1f8f3a, #4cd964);
    color: #fff;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}


/* COMMON */

.stat-card h5 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 15px;
}

.stat-card p {
    font-size: 18px;
    margin-bottom: 8px;
}

.stat-card h2 {
    font-size: 52px;
    font-weight: bold;
    margin-top: 10px;
}
  #calendar {
    max-width: 100%;
    margin: 0 auto;
    width: 100%;
    max-height: 850px;
    min-height: 730px;
  }

  button.fc-today-button.fc-button.fc-button-primary,
  button.fc-dayGridMonth-button.fc-button.fc-button-primary.fc-button-active,
  button.fc-timeGridWeek-button.fc-button.fc-button-primary,
  button.fc-timeGridDay-button.fc-button.fc-button-primary,
  button.fc-listWeek-button.fc-button.fc-button-primary,
  button.fc-dayGridMonth-button.fc-button.fc-button-primary {
    text-transform: capitalize !important;
  }

  @media only screen and (max-width: 600px) {
    #calendar {
      max-width: 100%;
      margin: 0 auto;
      width: 100%;
      height: auto !important;
      max-height: 100% !important;
      min-height: 100% !important;
    }

    .fc .fc-button-group {
      display: inline-grid !important;
    }

  }
</style>
<link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>fullcalendar/lib/main.min.css">
<link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>fullcalendar-bootstrap/main.min.css">
<script src="<?php echo LAYOUT_PLUG_PATH; ?>fullcalendar/lib/main.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');
    var terminal = $('#terminal').val();
    var year = $('#year').val();


    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      initialDate: '<?php echo date('Y-m-d'); ?>',
      editable: true,
      navLinks: true, // can click day/week names to navigate views
      dayMaxEvents: true, // allow "more" link when too many events

      //events: <?php //echo $calendarInfo;
                ?>

      eventSources: [

        {
          url: 'dashboard/Dashboard/getCalendarInfo',
          method: 'GET',
          extraParams: {
            terminal: terminal,
            year: year,
          },

          failure: function() {
            alert('there was an error while fetching events!');
          },
           

        }
      ]
    });

    calendar.render();
  });
</script>
<?php
// $completePTWCount = postData($ptwCounts,'completeptwcount');
// $activePTWCount = postData($ptwCounts,'activeptwcount');
// $pendingPTWCount = postData($ptwCounts,'pendingptwcount');
// $stopPTWCount = postData($ptwCounts,'stopptwcount');
// $HirarcCount = postData($hirarcCounts,'totalhirarccount');
//  $AtarCountDisplay = postData($AtarCountDisplaydata,'atar_count');
//  $inspecCountDisplay = postData($totalInspeccount,'inspec_count');
//echo '<pre>';print_r($incidentCount);exit;
global $YearList;
$YearList = [
  '' => 'Select Year',
  '2020' => '2020',
  '2021' => '2021',
  '2022' => '2022',
  '2023' => '2023',
  '2024' => '2024',
  '2025' => '2025',
  '2026' => '2026',
];
$year = !empty($year) ? $year : date('Y');
$completePTWCount = postData($ptwCounts, 'completeptwcount');
$activePTWCount = postData($ptwCounts, 'activeptwcount');
$pendingPTWCount = postData($ptwCounts, 'pendingptwcount');
$stopPTWCount = postData($ptwCounts, 'stopptwcount');


$completePTWCountCritical = postData($ptwCountsCritical, 'completeptwcount');
$activePTWCountCritical = postData($ptwCountsCritical, 'activeptwcount');
$pendingPTWCountCritical = postData($ptwCountsCritical, 'pendingptwcount');
$stopPTWCountCritical = postData($ptwCountsCritical, 'stopptwcount');


$HirarcCount = postData($hirarcCounts, 'totalhirarccount');
// print_r($hirarcCounts);
// exit;
$AtarCountDisplay = postData($AtarCountDisplaydata, 'atar_count');
$inspecCountDisplay = postData($totalInspeccount, 'inspec_count');
?>
<div class="content-wrapper">


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-body">
              <div id="" style="width: 100%; height: 100%;">

                <div id="dashslider" class="carousel slide" data-ride="carousel">

                  <!-- Indicators -->

                  <ol class="carousel-indicators">
                    <?php
                    $j = 0;
                    if (isset($sliderData) && $sliderData != FALSE) {
                      foreach ($sliderData as $photo) {
                        $j++;
                        $activeTag = ($j == 1) ? "active" : "";
                        $k = $j - 1;
                    ?>
                        <li data-target="#dashslider" data-slide-to="<?php echo $k; ?>" class="<?php echo $activeTag; ?>"></li>

                    <?php  }
                    }
                    ?>
                  </ol>

                  <!-- The slideshow -->
                  <div class="carousel-inner">
                    <?php
                    $i = 0;
                    if (isset($sliderData) && $sliderData != FALSE) {

                      foreach ($sliderData as $key => $photo) {
                        $i++;
                        $imagepath = BASE_URL . $photo->SLI_FILE_PATH . $photo->SLI_FILENAME;

                        //  print_r($photo);exit;
                        $activeImg = ($i == 1) ? "active" : "";
                        //
                    ?>
                        <div class="carousel-item <?php echo $activeImg; ?>">
                          <img src="<?php echo $imagepath; ?>" alt="Los Angeles" width="100%">
                        </div>

                    <?php
                      }
                    }
                    ?>
                  </div>

                  <!-- Left and right controls -->
                  <a class="carousel-control-prev" href="#dashslider" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#dashslider" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </a>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

   <?php
$formData = [
    'class' => 'form-horizontal',
    'id' => 'search_form',
    'novalidate' => 'novalidate'
];

echo form_open(BASE_URL . 'dashboard', $formData);

$year = !empty($year) ? $year : date('Y');
?>

<div class="card card-headprimary">

    <!-- CARD HEADER -->
    <div class="card-header headingStyl">
        <h4 class="title-head">User Statistics</h4>
    </div>

    <div class="card-body">

        <!-- TODAY / MONTH -->
        <div class="row justify-content-center mb-4">

            <!-- EXTERNAL USERS -->
            <div class="col-md-4 mb-3">
                <div class="stat-card external-card">
                    <h5>External Users</h5>

                    <p>
                        Today:
                        <b><?php echo $userCounts['contracter_today']; ?></b>
                    </p>

                    <p>
                        Current Month:
                        <b><?php echo $userCounts['contracter_month']; ?></b>
                    </p>
                </div>
            </div>

            <!-- INTERNAL USERS -->
            <div class="col-md-4 mb-3">
                <div class="stat-card internal-card">
                    <h5>Internal Users</h5>

                    <p>
                        Today:
                        <b><?php echo $userCounts['employee_today']; ?></b>
                    </p>

                    <p>
                        Current Month:
                        <b><?php echo $userCounts['employee_month']; ?></b>
                    </p>
                </div>
            </div>

        </div>

        <!-- SEARCH FILTER -->
        <div class="row m-t-10">

            <!-- TERMINAL -->
            <div class="col-md-3 form-group">
                <label>Terminal <span class="error"></span></label>

                <?php
                $termdata = array(
                    'id' => 'terminal',
                    'class' => 'form-control select2',
                    'required' => true,
                    'checkselect' => 'select2'
                );

                echo form_dropdown(
                    'terminal',
                    $getterminalNamedatas,
                    $terminal,
                    $termdata
                );
                ?>

                <label class="error terminal"></label>
            </div>

            <!-- YEAR -->
            <div class="col-md-2 form-group">
                <label>Year</label>

                <?php
                $yearDetails = [
                    'id' => 'year',
                    'class' => 'form-control select2bs4 select2',
                    'style' => 'width:100%',
                ];

                echo form_dropdown(
                    'year',
                    $YearList,
                    $year,
                    $yearDetails
                );
                ?>

                <?php echo form_error('year', '<div class="error">', '</div>'); ?>
            </div>

            <!-- FROM DATE -->
            <div class="col-md-2 form-group">
                <label>From Date</label>

                <input type="date"
                       name="from_date"
                       id="from_date"
                       class="form-control"
                       value="<?php echo isset($from_date) ? $from_date : ''; ?>">
            </div>

            <!-- TO DATE -->
            <div class="col-md-2 form-group">
                <label>To Date</label>

                <input type="date"
                       name="to_date"
                       id="to_date"
                       class="form-control"
                       value="<?php echo isset($to_date) ? $to_date : ''; ?>">
            </div>

            <!-- BUTTONS -->
            <div class="col-md-3 form-group" style="margin-top:30px;">

                <button class="btn btn-success"
                        id="searchbtn"
                        name="search">
                    Search
                </button>

                <input type="reset"
                       class="btn btn-danger"
                       id="reset"
                       name="reset"
                       value="Reset">
            </div>

        </div>

        <!-- TOTAL USERS -->
        <div class="row justify-content-center mt-4">

            <!-- EXTERNAL TOTAL -->
            <div class="col-md-4 mb-3">
                <div class="stat-card external-card-dark">

                    <h5>External Users</h5>

                    <h2>
                        <?php echo $userCounts['contracter_total']; ?>
                    </h2>

                </div>
            </div>

            <!-- INTERNAL TOTAL -->
            <div class="col-md-4 mb-3">
                <div class="stat-card internal-card-dark">

                    <h5>Internal Users</h5>

                    <h2>
                        <?php echo $userCounts['employee_total']; ?>
                    </h2>

                </div>
            </div>

        </div>

    </div>

</div>

<?php echo form_close(); ?>
      <!-- Info boxes -->
      <h3 class="mb-3">Normal Work Permit</h3>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"></span>

            <div class="info-box-content">
              <span class="info-box-text">Active <br /> PTWs</span>

              <!-- <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/permitList?search=1"><?php echo $activePTWCount; ?></a></span> -->

              <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/normalList?status=6&year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>"><?php echo $activePTWCount; ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"></span>

            <div class="info-box-content">
              <span class="info-box-text">Completed <br /> PTWs</span>
              <!-- <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/permitList?search=2"><?php echo $completePTWCount; ?></a></span> -->

              <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/normalList?status=7&year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>"><?php echo $completePTWCount; ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"></span>

            <div class="info-box-content">
              <span class="info-box-text">Pending <br /> PTWs</span>
              <!-- <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/permitList?search=3"><?php echo $pendingPTWCount; ?></a></span> -->

              <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/normalList?status=1&year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>"><?php echo $pendingPTWCount; ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"></span>

            <div class="info-box-content">
              <span class="info-box-text">PTW Stoppage / <br /> Stop Work Order</span>
              <!-- <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/permitList?search=4"><?php echo $stopPTWCount; ?></a></span> -->

              <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/normalList?status=8&year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>"><?php echo $stopPTWCount; ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Info boxes -->
      <h3 class="mb-3">Critical Work Permit</h3>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"></span>

            <div class="info-box-content">
              <span class="info-box-text">Active <br /> PTWs</span>

              <!-- <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/permitList?search=1"><?php echo $activePTWCount; ?></a></span> -->

              <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/criticalList?status=6&year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>"><?php echo $activePTWCountCritical; ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"></span>

            <div class="info-box-content">
              <span class="info-box-text">Completed <br /> PTWs</span>
              <!-- <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/permitList?search=2"><?php echo $completePTWCount; ?></a></span> -->

              <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/criticalList?status=7&year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>"><?php echo $completePTWCountCritical; ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"></span>

            <div class="info-box-content">
              <span class="info-box-text">Pending <br /> PTWs</span>
              <!-- <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/permitList?search=3"><?php echo $pendingPTWCount; ?></a></span> -->

              <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/criticalList?status=1&year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>"><?php echo $pendingPTWCountCritical; ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"></span>

            <div class="info-box-content">
              <span class="info-box-text">PTW Stoppage / <br /> Stop Work Order</span>
              <!-- <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/permitList?search=4"><?php echo $stopPTWCount; ?></a></span> -->

              <span class="info-box-number"><a href="<?php echo BASE_URL ?>ptw/permit/criticalList?status=8&year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>"><?php echo $stopPTWCountCritical; ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->



      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8 calendarsection">
          <div class="card card-primary">
            <div class="card-body p-0">
              <!-- THE CALENDAR -->
              <div id='calendar' style="width:100%;max-height:850px;min-height:730px;  "></div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-4 hsesection">
          <!-- Info Boxes Style 2 -->
          <div class="info-box mb-3 bg-warning">

            <div class="info-box-content">
              <span class="info-box-text">HSSE Inspections</span>
              <span class="info-box-number"> <?php echo ($inspecCountDisplay != "" ? $inspecCountDisplay : 0) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-success">

            <div class="info-box-content">
              <span class="info-box-text">HIRARC</span>
              <span class="info-box-number"><a href="<?php echo BASE_URL ?>hirarc/hirarc?year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" style="color: white;"><?php echo ($HirarcCount != "" ? $HirarcCount : 0) ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-danger">
            <div class="info-box-content">
              <span class="info-box-text">ATAR</span>
              <span class="info-box-number"><?php echo ($AtarCountDisplay != "" ? $AtarCountDisplay : 0) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-info">
            <div class="info-box-content">
              <span class="info-box-text">Incident</span>
              <span class="info-box-number"><a href="<?php echo BASE_URL ?>incident?year=<?php echo $year; ?>&terminal=<?php echo $terminal; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" style="color: white;"><?php echo ($incidentCount != "" ? $incidentCount : 0) ?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">HSSE Master Plan</h3>

              <!--  <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div> -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php $year_new = !empty($year) ? $year : '2025'; ?>
              <div class="row">
                  <div class="col-md-12">
                      <div class="chart-responsive">
                          <canvas id="pieChart" height="99" width="199" class="chartjs-render-monitor" style="display: block; width: 199px; height: 99px;"></canvas>
                      </div>
                  </div>

                  <div class="col-md-11">
                      <ul class="chart-legend clearfix">
                          <li onclick="redirectWithStatus(3)" style="cursor: pointer;"><i class="far fa-circle text-danger"></i> Program Overdue</li>
                          <li onclick="redirectWithStatus(2)" style="cursor: pointer;"><i class="far fa-circle text-success"></i> Program Completed</li>
                          <li onclick="redirectWithStatus(4)" style="cursor: pointer;"><i class="far fa-circle text-warning"></i> Program Postpone</li>
                          <li onclick="redirectWithStatus(1)" style="cursor: pointer;"><i class="far fa-circle text-info"></i> Program Processing</li>
                      </ul>
                  </div>
              </div>

            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer bg-white p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      United States of America
                      <span class="float-right text-danger">
                        <i class="fas fa-arrow-down text-sm"></i>
                        12%</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      India
                      <span class="float-right text-success">
                        <i class="fas fa-arrow-up text-sm"></i> 4%
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      China
                      <span class="float-right text-warning">
                        <i class="fas fa-arrow-left text-sm"></i> 0%
                      </span>
                    </a>
                  </li>
                </ul>
              </div> -->
            <!-- /.footer -->
          </div>
        </div>

        <!-- /.card -->

        <!-- /.row -->

        <!-- TABLE: LATEST ORDERS -->

        <!-- /.card -->
      </div>
      <div class="row">
        <div class="col-md-12">
          <?php
          $aData = [
            'atarCountdata' => $atarCountdata
          ];

          ?>
          <?php $this->load->view('dashboard/atar_count', $aData); ?>
          <!-- /.card -->
        </div>

      </div>
      <!-- /.col -->

      <div class="row">
        <div class="col-md-12">
          <?php
          $aData = [
            'incidentCounts' => $incidentbarCount
          ];

          ?>
          <?php $this->load->view('dashboard/incident_count', $aData); ?>
          <!-- /.card -->
          </a>
        </div>

      </div>


      <!-- /.info-box -->


      <!-- /.card -->

      <!-- PRODUCT LIST -->

      <!-- /.card -->
    </div>
    <!-- /.col -->

    <!-- /.row -->
    <!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<script>
  function redirectWithStatus(status) {
    var terminal = '<?php echo $terminal; ?>';
    var year = '<?php echo $year_new; ?>';
    var from_date = '<?php echo $from_date; ?>';
    var to_date = '<?php echo $to_date; ?>';
    var url = '<?php echo BASE_URL; ?>hmp/hmp/hmpInfo?terminal=' + terminal + '&year=' + year + '&status=' + status + '&start_date=' + from_date + '&end_date=' + to_date;
    window.location.href = url;
}

  $(document).on('click', '#reset', function(e) {
    e.preventDefault();
    $('.select2').val('').trigger('change');
    window.location.href = "<?php echo base_url('dashboard'); ?>";
  });
  $(function() {
    $('#dashslider').carousel({
      interval: 2000
    })


  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');

  var pieData = {
    labels: [
      'Program Overdue',
      'Program Completed',
      'Program Postpone',
      'Program Processing',
    ],
    datasets: [{
      data: <?php echo json_encode($programpiedata); ?>,
      backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
    }]
  };

  var pieOptions = {
    legend: {
      display: false
    },
    onClick: function(event, elements) {
      if (elements.length > 0) {
         var index = elements[0]._index;
        // alert(JSON.stringify(elements));
      

        // Status mapping based on index
        var statusMap = {
          0: 3, // Program Overdue
          1: 2, // Program Completed
          2: 4, // Program Postpone
          3: 1  // Program Processing
        };

        var status = statusMap[index];
          // console.log('Clicked Index:', index, 'Mapped Status:', status);
          // return;
        var terminal = '<?php echo $terminal; ?>';
        var year = '<?php echo $year_new; ?>';
        var from_date = '<?php echo $from_date; ?>';
        var to_date = '<?php echo $to_date; ?>';

        var url = '<?php echo BASE_URL; ?>hmp/hmp/hmpInfo?terminal=' + terminal + '&year=' + year + '&status=' + status + '&start_date=' + from_date + '&end_date=' + to_date;
        window.location.href = url;
      }
    }
  };

  // Create the chart
  var pieChart = new Chart(pieChartCanvas, {
    type: 'doughnut',
    data: pieData,
    options: pieOptions
  });



  });
</script>