  <?php
  include("header.php");
  include("sidebar.php");
  include("function.php");
  include("scriptJS.php");
  ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            </div><!-- /.box-header -->
            <div class="box-body">
              <table id="championTable" style="text-align:center;"  class="table table-bordered table-striped dataTable header-fixed">
                <thead >
                  <tr style="cursor: pointer">
                    <TH style="text-align:center"> Champion </TH>
                    <TH style="text-align:center"> Name </TH>
                    <TH style="text-align:center"> Games </TH>
                    <TH style="text-align:center"> Wins </TH>
                    <TH style="text-align:center"> Losses </TH>
                    <TH style="text-align:center"> Winrate </TH>
                    <TH style="text-align:center"> Kills/Game </TH>
                    <TH style="text-align:center"> Deaths/Game </TH>
                    <TH style="text-align:center"> Assists/Game </TH>
                    <TH style="text-align:center"> KDA </TH>
                    <TH style="text-align:center"> CS/Game </TH>
                    <TH style="text-align:center"> Gold/Game </TH>
                  </tr>
                </thead>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
      


	        <?php // Checking summoner name entry
	        
	        if (isset($_GET['summonerName']))
	        {
	        	$_SESSION["summonerName"] = $_GET["summonerName"]; // Storing summoner name
	        }
	        if (isset($_SESSION['summonerName']))
	        {
	        	?>
	        	<script>
              var SUMMONER_NAME = <?php echo "'", $_SESSION['summonerName'], "'"; ?>
            </script>
            <?php
          }
          ?>

          <script>
            function sort() {
              $("#championTable").DataTable({
                "lengthMenu" : [-1],
                "bFilter" : false,
                "bLengthChange" : false,
                "sScrollX" : true,
                "bPaginate" : false,
                "bInfo" : false,
                "order" : [[2, "desc"],[3, "desc"],[9, "desc"]],

                "columnDefs" :
                [ 
                {className: "success", "targets" : [3]},
                {className: "danger", "targets" : [4]},
                {className: "warning", "targets" : [5]},
                {className: "info", "targets" : [9]}
                ]
              })

            };
            sort();
            getVersion();
            getSummonerIdBySummonerName(SUMMONER_NAME);
          </script>


        </section>
      </div>