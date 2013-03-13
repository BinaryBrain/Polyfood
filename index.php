<?php session_start();
require_once("mysql.php");

//$root = "http://localhost:8008";
$root = "http://polyfood.ch";

// FACEBOOK API
require_once("fb/facebook.php");

$config = array();
require_once(".facebooksecret.php");
$config['fileUpload'] = false; // optional

$facebook = new Facebook($config);

// Login URL
$params = array(
  'scope' => 'publish_stream',
  'redirect_uri' => $root
);
$loginUrl = $facebook->getLoginUrl($params);

$uid = $facebook->getUser();
$isConnected = ($uid != 0);

// HARD CODE !!
if($isConnected) {
  $friendsids = array();
  
  try {
    $user = $facebook->api('/me','GET');
    
    $fbquery = str_replace(' ', '+', "SELECT uid, flid FROM friendlist_member WHERE flid IN (SELECT flid FROM friendlist WHERE owner=me())");
    $res = $facebook->api('/me/friends', 'GET');
    
    foreach($res['data'] as $key=>$friend) {
      $friendsids[$key] = $friend['id'];
    }
    
    $db = new DB();
    $friendsplaces = $db->getfriendsplaces($friendsids);
    $jsfriendsplaces = json_encode($friendsplaces);
    
    $myplace = $db->whereinom($uid);
    $jsmyplace = $myplace['restaurant'];
  }
  catch(FacebookApiException $e) {
    // If the user is logged out, you can have a 
    // user ID even though the access token is invalid.
    // In this case, we'll get an exception, so we'll
    // just ask the user to login again here.
    $login_url = $facebook->getLoginUrl(); 
    //echo 'Please <a href="' . $login_url . '">login.</a>';
    error_log($e->getType());
    error_log($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>PolyFood</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

    <?php if($isConnected) {
      echo '<script>var isFBConnected=true;</script>';
      echo '<script>var friendsplaces='.$jsfriendsplaces.';</script>';
      echo '<script>var myplace="'.$jsmyplace.'";</script>';
    } else {
      echo '<script>var isFBConnected=false;</script>';
    }
    ?>
    
    <script src="http://static.cpfk.net/scripts/jquery/latest.js"></script>
    <script src="http://static.cpfk.net/scripts/jquery/tablesorter/latest.js"></script>
    <script src="http://static.cpfk.net/scripts/jquery/tooltip/latest.js"></script>
    <script src="http://static.cpfk.net/scripts/jquery/collapse/latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>var json = <?php include("json.php"); ?>;</script>
    <script src="js/controller.js"></script>
    <link href="css/polyfood.css" rel="stylesheet" type="text/css">
  </head>
<body>
<div id="fb-root"></div>
<div class="container">
  <!-- Titre -->
  <div class="hero-unit">
    <h1>PolyFood</h1>
    <p>Enfin un moyen simple de trouver les plats que vous cherchez à l'EPFL.</p>
  </div>
  
  <form class="well form-horizontal" id="price" action="./" method="post">
      <div class="row">
      <!--<div><a href="#"><i class="icon-time"></i> Menu du soir</a></div>-->
      <div id="facebook">
	<?php if(!$isConnected) {
	  ?>
	  <a href="<?php echo $loginUrl; ?>">Facebook Connect</a>
	  <?php
	} else {
	  echo "<p>Hi, ".$user['first_name']."!</p>";
	}
      ?>
      </div>
      <fieldset class="span8">
        <div class="control-group">
          <label class="control-label" for="select01">Je suis</label>
          <div class="controls">
            <select id="select01" class="span2">
              <option>Étudiant</option>
              <option>Doctorant</option>
              <option>Professeur</option>
              <option>Visiteur</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="input01">Budget de</label>
          <div class="controls">
            <div class="input-append">
              <input class="span2" type="number" min="0.00" max="999.00" step="1" id="input01" placeholder="--.--"><span class="add-on">CHF</span>
            </div>
          </div>
        </div>
      </fieldset>
    </div>
    <div class="row">
      <fieldset class="span2">
        <div class="control-group">
          <label class="control-label" for="vinci">Le Parmentier / Vinci</label>
          <div class="controls">
            <input type="checkbox" id="vinci">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="corbusier">Le Corbusier</label>
          <div class="controls">
            <input type="checkbox" id="corbusier">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="puur">Le Puur Innovation</label>
          <div class="controls">
            <input type="checkbox" id="puur">
          </div>
        </div>
      </fieldset>
      <fieldset class="span2">
        <div class="control-group">
          <label class="control-label" for="hodler">Le Hodler</label>
          <div class="controls">
            <input type="checkbox" id="hodler">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="ornithorynque">L'Ornithorynque</label>
          <div class="controls">
            <input type="checkbox" id="ornithorynque">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="esplanade">L'Esplanade</label>
          <div class="controls">
            <input type="checkbox" id="esplanade">
          </div>
        </div>
      </fieldset>
      <fieldset class="span2">
        <div class="control-group">
          <label class="control-label" for="copernic">Le Copernic</label>
          <div class="controls">
            <input type="checkbox" id="copernic">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="valloton">La Table de Vallotton</label>
          <div class="controls">
            <input type="checkbox" id="valloton">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="hong">Hong Thaï Rung</label>
          <div class="controls">
            <input type="checkbox" id="hong">
          </div>
        </div>
      </fieldset>
      <fieldset class="span2">
        <div class="control-group">
          <label class="control-label" for="mx">Cafétéria MX</label>
          <div class="controls">
            <input type="checkbox" id="mx">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="bc">Cafétéria BC</label>
          <div class="controls">
            <input type="checkbox" id="bc">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="maharaja">Maharaja</label>
          <div class="controls">
            <input type="checkbox" id="maharaja">
          </div>
        </div>
      </fieldset>
    </div>
    <div id="infos"></div>
  </form>
  <!-- Containter de la page -->
  <div class="row">
    <div class="span12">
      <table id="mainTable" class="table table-bordered table-striped tablesorter">
        <thead>
          <tr>
            <th><i class="icon-chevron-up"></i><i class="icon-chevron-down"></i>
            Restaurant</th>
            <th class="type"><i class="icon-chevron-up"></i><i class="icon-chevron-down"></i>
            Type</th>
            <th class="sorter-false"><i class="icon-chevron-up"></i><i class="icon-chevron-down"></i>
            Plat</th>
            <th><i class="icon-chevron-up"></i><i class="icon-chevron-down"></i>
            Prix<span id="maxPrice"></span><span id="priceType"></span></th>
            <?php if($isConnected) {
              ?><th><i class="icon-chevron-up"></i><i class="icon-chevron-down"></i>
              Friends</th>
              <!--
                <th><i class="icon-chevron-up"></i><i class="icon-chevron-down"></i>
                Total</th>
              -->
              <?php
            } ?>
          </tr>
        </thead>
        <tbody id="data">
        </tbody>
      </table>
    </div>
  </div>
  <footer class="footer"><p><a href="http://twitter.com/Binary_Brain">Sacha Bron</a> &amp; <a href="http://twitter.com/Protectator">Kewin Dousse</a> - 2012-2013</p></footer>
  
  <!-- Place Modal -->
  <div id="placeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="placeModalLabel" aria-hidden="true">
    <form>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="placeModalLabel"><span class="restaurant"></span></h3>
      </div>
      <div class="modal-body">
        <label for="hour">Je mange à </label>
        <select id="hour" name="hour">
          <option value="00:00:00">Ne pas préciser</option>
          <option value="11:30:00">11h30</option>
          <option value="12:00:00">12h00</option>
          <option value="12:30:00">12h30</option>
          <option value="13:00:00">13h00</option>
          <option value="13:30:00">13h30</option>
          <option value="14:00:00">14h00</option>
        </select>
        <br>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Envoyer</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
      </div>
    </form>
  </div>
  
  <!-- Friends Modal -->
  <div id="friendsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="friendsModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="friendsModalLabel">Amis à <span class="restaurant"></span></h3>
    </div>
    <div class="modal-body">      
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fermer</button>
    </div>
  </div>
</div>
</body>
</html>
