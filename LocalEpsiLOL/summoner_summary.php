  <?php
  include("header.php");
  include("function.php");
  include("sidebar.php");
  include("scriptJs.php");
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <!-- Profile Image -->

     <div class="box ">
      <div class="box-body box-profile">
        <div class="col-xs-12">
          <div class="box box-solid">
            <div class="box-body">
              <div class="row">
               <div class="col-xs-6 col-md-4 text-center">
                <div style="padding-top:50px;">
                  <div class="img-responsive"  id="sIcon"></div>
                  <h3 class="profile-username text-center" id="sName"></h3>
                  <p class="text-muted text-center" id="sLevel"></p>
                </div>
              </div><!-- ./col -->
              <div class="col-xs-6 col-md-4 text-center border-right border-left">
                <div id="sRankedSolo"></div>
              </div><!-- ./col -->
              <div class="col-xs-6 col-md-4 text-center border-right">
                <div id="sRankedThree"></div>
              </div><!-- ./col -->
              <div class="col-xs-6 col-md-4 text-center">
                <div id="sRankedFive"></div>
              </div><!-- ./col -->
            </div><!-- /.row -->
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.box-body -->
  </div><!-- /.box -->

  <div class="row">

  </div><!-- /.row -->


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


  <!-- Recent Game -->
  <div class="row" id="recentGame">

  </div>


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
              "lengthMenu" : [3],
              "bFilter" : false,
              "bLengthChange" : false,
              "sScrollX" : false,
              "bPaginate" : true,
              "responsive" : true,
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
        <script>
          var API_KEY = "a7103d78-47ef-4097-a41e-618b82276627";
          var summonerLevel;
          var sumID;

        function getSummonerAccountInfos() // Getting datas concerning summoner
        {
          if (SUMMONER_NAME !== "") 
          { 
            $.ajax({
              url: 'https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/' + SUMMONER_NAME + '?api_key=' + API_KEY,
              type: 'GET',
              dataType: 'json',
              data: {},
              success: function (json)
              {
                var SUMMONER_NAME_NOSPACES = SUMMONER_NAME.replace(" ", "");

                SUMMONER_NAME_NOSPACES = SUMMONER_NAME_NOSPACES.toLowerCase().trim();

                summonerLevel = json[SUMMONER_NAME_NOSPACES].summonerLevel;
                sumID = json[SUMMONER_NAME_NOSPACES].id;

                document.getElementById('sidebarLevel').innerHTML = "Level " + json[SUMMONER_NAME_NOSPACES].summonerLevel;
                document.getElementById('sidebarIcon').innerHTML = "<img src='http://avatar.leagueoflegends.com/euw/" + SUMMONER_NAME_NOSPACES + ".png' class='img-circle'>";

                document.getElementById("sName").innerHTML = SUMMONER_NAME;
                document.getElementById('sIcon').innerHTML = "<img width='50%' src='http://avatar.leagueoflegends.com/euw/" + SUMMONER_NAME + ".png' class='img-thumbnail'>";
                document.getElementById("sLevel").innerHTML = "Level " + summonerLevel;

                if (summonerLevel == 30)
                {
                  getVersion();
                  getSummonerRankedStats(sumID);

                };

                  getRecentGameInfo(sumID);
              },

              error: function (XMLHttpRequest, textStatus, errorThrown) 
              {
                alert("error getting Summoner data!");
              }
            });
}
}

function getSummonerRankedStats(sumID)
{
  $.ajax({
    url: 'https://euw.api.pvp.net/api/lol/euw/v2.5/league/by-summoner/' + sumID + '/entry?api_key=' + API_KEY,
    type: 'GET',
    dataType: 'json',
    data: {},
    success: function (json) 
    {
              // Variables initialization 3x3
              var ThreeTeamBestTier = "UNRANKED";
              var ThreeTeamBestDivision = "VI";
              var ThreeTeamBestLP = 0;
              // Variables initialization 5x5
              var FiveTeamBestTier = "UNRANKED";
              var FiveTeamBestDivision = "VI";
              var FiveTeamBestLP = 0;

              $.each(json, // Getting in the array
                function(key, value)
                {
                  $.each(value,
                    function(key2, value2)
                    {
                      if (value2.queue == "RANKED_SOLO_5x5") // Solo Rank Treatment
                      {
                        tier = value2.tier;
                        $.each(value2.entries,
                          function(key3, value3)
                          {
                            division = value3.division
                            lp = value3.leaguePoints;
                            wins = value3.wins;
                            losses = value3.losses;
                            document.getElementById('sRankedSolo').innerHTML = "<h4>Solo</h4><br><img style='width:50%' src='ressources/tier/"+tier +" "+division+".png'><br>" + tier + " " + division + "<br>" + lp + " LP<br>" + wins + "W " + losses + "L";
                          })
                      }

                      else if (value2.queue == "RANKED_TEAM_3x3") // ThreeTeam Rank Treatment
                      {
                        $.each(value2.entries,
                          function(key4, value4)
                          {
                            if (tierToNumber(value2.tier) < tierToNumber(ThreeTeamBestTier)) // If the selected tier is better
                            {
                              ThreeTeamBestTier = value2.tier;
                              ThreeTeamBestDivision = value4.division;
                              ThreeTeamBestLP = value4.leaguePoints;
                              ThreeTeamName = value4.playerOrTeamName;
                              ThreeTeamWins = value4.wins;
                              ThreeTeamLosses = value4.losses
                            }
                            else if (tierToNumber(value2.tier) == tierToNumber(ThreeTeamBestTier) && value4.division < ThreeTeamBestDivision) // If the selected tier is the same but division is better
                            {
                              ThreeTeamBestDivision = value4.division;
                              ThreeTeamBestLP = value4.leaguePoints;
                              ThreeTeamName = value4.playerOrTeamName;
                              ThreeTeamWins = value4.wins;
                              ThreeTeamLosses = value4.losses
                            }
                            else if (tierToNumber(value2.tier) == tierToNumber(ThreeTeamBestTier) && value4.division == ThreeTeamBestDivision && value4.leaguePoints > ThreeTeamBestLP) // If the selected tier and division are the same but LP are better
                            {
                              ThreeTeamBestLP = value4.leaguePoints;
                              ThreeTeamName = value4.playerOrTeamName;
                              ThreeTeamWins = value4.wins;
                              ThreeTeamLosses = value4.losses
                            };
                          })
}

                      else if (value2.queue == "RANKED_TEAM_5x5") // FiveTeam Rank Treatment
                      {
                        $.each(value2.entries,
                          function(key5, value5)
                          {
                            if (tierToNumber(value2.tier) < tierToNumber(FiveTeamBestTier)) // If the selected tier is better
                            {
                              FiveTeamBestTier = value2.tier;
                              FiveTeamBestDivision = value5.division;
                              FiveTeamBestLP = value5.leaguePoints;
                              FiveTeamName = value5.playerOrTeamName;
                              FiveTeamWins = value5.wins;
                              FiveTeamLosses = value5.losses
                            }
                            else if (tierToNumber(value2.tier) == tierToNumber(FiveTeamBestTier) && value5.division < FiveTeamBestDivision) // If the selected tier is the same but division is better
                            {
                              FiveTeamBestDivision = value5.division;
                              FiveTeamBestLP = value5.leaguePoints;
                              FiveTeamName = value5.playerOrTeamName;
                              FiveTeamWins = value5.wins;
                              FiveTeamLosses = value5.losses
                            }
                            else if (tierToNumber(value2.tier) == tierToNumber(FiveTeamBestTier) && value5.division == FiveTeamBestDivision && value5.leaguePoints > FiveTeamBestLP) // If the selected tier and division are the same but LP are better
                            {
                              FiveTeamBestLP = value5.leaguePoints;
                              FiveTeamName = value5.playerOrTeamName;
                              FiveTeamWins = value5.wins;
                              FiveTeamLosses = value5.losses
                            };
                          })
}
})
})

  if (ThreeTeamBestTier == "UNRANKED")
  {
    document.getElementById('sRankedThree').innerHTML = "<h4>3v3 Ranked</h4><br><img style='width:50%' src='ressources/tier/Unranked.png'><br>Unranked"
  }
  else
  {
    document.getElementById('sRankedThree').innerHTML = "<h4>3v3 Ranked</h4> " + ThreeTeamName + "<br><img style='width:50%' src='ressources/tier/"+ThreeTeamBestTier+" "+ThreeTeamBestDivision+".png'><br>" + ThreeTeamBestTier + " " + ThreeTeamBestDivision + "<br>" + ThreeTeamBestLP + "LP<br>" + ThreeTeamWins + "W " + ThreeTeamLosses + "L";
  }

  if (FiveTeamBestTier == "UNRANKED")
  {
    document.getElementById('sRankedFive').innerHTML = "<h4>5v5 Ranked</h4><br><img  style='width:50%' src='ressources/tier/Unranked.png'><br>Unranked"
  }
  else
  {
    document.getElementById('sRankedFive').innerHTML = "<h4>5v5 Ranked</h4>" + FiveTeamName + "<br><img style='width:50%' src='ressources/tier/"+FiveTeamBestTier+" "+FiveTeamBestDivision+".png'><br>" + FiveTeamBestTier + " " + FiveTeamBestDivision + "<br>" + FiveTeamBestLP + "LP<br>" + FiveTeamWins + "W " + FiveTeamLosses + "L";
  }
},

error: function (XMLHttpRequest, textStatus, errorThrown) 
{
  alert("error getting Summoner data!");
}
});     
}
</script>

</section>

<!-- Main content -->

</div><!-- /.content-wrapper -->

      <?php // Using Function
      if (isset($_SESSION['summonerName']))
      {
        ?>
        <script>
          getSummonerAccountInfos();
        </script>
        <?php
      }
      ?>

      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
     <?php 
        include("footer.php");
      ?>

    <script>
      function tierToNumber(tier)
      {
        if (tier == "CHALLENGER") {return 1}
        else if (tier == "MASTER") {return 2}
        else if (tier == "DIAMOND") {return 3}
        else if (tier == "PLATINUM") {return 4}
        else if (tier == "GOLD") {return 5}
        else if (tier == "SILVER") {return 6}
        else if (tier == "BRONZE") {return 7}
        else if (tier == "UNRANKED") {return 8};
    }
  </script>
