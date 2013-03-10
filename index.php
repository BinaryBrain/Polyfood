<?php session_start();

$root = "http://localhost:8008";

// FACEBOOK API
require_once("fb/facebook.php");

$config = array();
require_once(".facebooksecret");
$config['fileUpload'] = false; // optional

$facebook = new Facebook($config);

// Login URL
$params = array(
  'scope' => 'read_friendlists, publish_stream',
  'redirect_uri' => $root
);
$loginUrl = $facebook->getLoginUrl($params);

$uid = $facebook->getUser();
$isConnected = ($uid != 0);

// HARD CODE !!
if($isConnected) {
  
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Poly Food</title>
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
      
    <script src="http://static.cpfk.net/scripts/jquery/latest.js"></script>
    <script src="http://static.cpfk.net/scripts/jquery/tablesorter/latest.js"></script>
    <script src="http://static.cpfk.net/scripts/jquery/tooltip/latest.js"></script>
    <script src="http://static.cpfk.net/scripts/jquery/collapse/latest.js"></script>
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
	  <p><a href="<?php echo $loginUrl; ?>">Facebook Login</a></p>
	  <!--fb:login-button size="large" onlogin="Log.info('onlogin callback')">Connexion Facebook</fb:login-button-->
	  <!--<fb:login-button size="large" onlogin="login()">Connexion Facebook</fb:login-button>-->
	  <?php
	} else {
	  echo "<p>".$uid."</p>";
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
            <th><i class="icon-chevron-up"></i><i class="icon-chevron-down"></i>
            Friends</th>
            <th><i class="icon-chevron-up"></i><i class="icon-chevron-down"></i>
            Total</th>
          </tr>
        </thead>
        <tbody id="data">
        </tbody>
      </table>
    </div>
  </div>
  <footer class="footer"><p><a href="http://twitter.com/Binary_Brain">Sacha Bron</a> &amp; <a href="http://twitter.com/Protectator">Kewin Dousse</a> - 2012</p></footer>
</div>
</body>
</html>
