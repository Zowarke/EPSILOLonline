<!--- header -->
<header class="main-header">
  <!-- Logo -->
  <a href="index.php" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b></b>LOL</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>EPSI</b>LOL</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
  </nav>
</header>
<!---/header -->


<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image" id="sidebarIcon">
      </div>
      <div class="pull-left info">
        <p>
          <span id="sidebarName">
            <?php
            if (isset($_GET["summonerName"]))
            {
              $_SESSION["summonerName"] = $_GET["summonerName"];
            }
            echo $_SESSION["summonerName"];
            ?>
          </span>
          <br />
          <br />
          <span id="sidebarLevel"></span>
        </p>
      </div>
    </div>

    <?php
      if ($_SERVER["PHP_SELF"] == "/LocalEpsiLOL/index.php")
      {
        $redirection = "/LocalEpsiLOL/summoner_summary.php";
      }
      else
      {
        $redirection = $_SERVER["PHP_SELF"];
      }


    ?>
    <!-- search form -->
    <div class="sidebar-form">
      <form class="input-group" method="GET" action="<?php echo $redirection ?>">
        <input name="summonerName" id="userName" type="text" class="form-control" value="splatatozor">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-flat"><i class="fa fa-search"></i></input>
          </span>
        </form>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="active treeview">
          <a href="index.php">
            <i class="fa fa-home"></i> <span>Home</span></i>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Summoner</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php
            if (isset($_GET["summonerName"]))
            {
              ?>
              <li><a href="summoner_summary.php?summonerName=<?php echo $_GET['summonerName']?>"><i class="fa fa-circle-o"></i> Summary </a></li>
              <?php
            }
            else
            {
              ?>
              <li><a href="summoner_summary.php"><i class="fa fa-circle-o"></i> Summary </a></li>
              <?php
            }
            ?>
            <li><a href="summoner_champion.php"><i class="fa fa-circle-o"></i> Champions </a></li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <script>
        function getSummonerSidebar(summonerNameSidebar)
        {
          var SUMMONER_NAME = summonerNameSidebar;
          var SUMMONER_NAME_NOSPACES_SIDEBAR = SUMMONER_NAME.replace(" ", "");
          var API_KEY = "a7103d78-47ef-4097-a41e-618b82276627";
          $.ajax({
            url: 'https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/' + SUMMONER_NAME + '?api_key=' + API_KEY,
            type: 'GET',
            dataType: 'json',
            data: {},
            success: function (json) 
            {
              SUMMONER_NAME_NOSPACES_SIDEBAR = SUMMONER_NAME_NOSPACES_SIDEBAR.toLowerCase().trim();
              document.getElementById('sidebarLevel').innerHTML = "Level " + json[SUMMONER_NAME_NOSPACES_SIDEBAR].summonerLevel;
              document.getElementById('sidebarIcon').innerHTML = "<img src='http://avatar.leagueoflegends.com/euw/" + summonerNameSidebar + ".png' class='img-circle'>";
            }
          })
        }
      </script>

      <?php
      if (isset($_SESSION["summonerName"]))
      {
        ?>
        <script>
          getSummonerSidebar('<?php echo $_SESSION["summonerName"]?>');
        </script>
        <?php
      }
      ?>