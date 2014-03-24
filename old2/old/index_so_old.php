<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>1 N33d F00d</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<!-- Styles -->

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
	
	<script src="http://static.cpfk.net/scripts/jquery/latest.js" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	
	<script>
	var json = <?php include("json.php");?>;
	
	function jsoncallback(data){
		$("#annonces").text(data.offres+data.demandes);
		$("#posts").text(data.posts);
		$("#membres").text(data.membres);
		$("#docs").text(data.docs);
	}
	$(document).ready(function() {
		$.getJSON("http://www.mondomaine.com/statistiques.php?jsoncallback=?");
	});
	</script>
	
</head>
<body>
<div class="container" style="margin-top:30px;">

	<!-- Titre -->
	<div class="hero-unit">
		<h1>1 N33d F00d</h1>
		<p>Enfin un moyen simple de trouver la bouffe que vous cherchez à l'EPFL.</p>
	</div>

	<form class="well form-horizontal">
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="select01">Je suis</label>
				<div class="controls">
					<select id="select01" class="span2">
						<option>Etudiant</option>
						<option>Doctorant</option>
						<option>Professeur</option>
						<option>Visiteur</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="select01">Budget de</label>
				<div class="controls">
					<div class="input-append">
						<input class="span2" type="number" min="0.00" step="0.01" id="input01" placeholder="10.00">
						<span class="add-on">CHF</span>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<a class="btn btn-inverse" href="#"><i class="icon-trash icon-white"></i> RàZ</a> 
				<a class="btn" href="#"><i class="icon-search"></i> Filtrer</a>
			</div>
		</fieldset>
	</form>
	
	<!-- Containter de la page -->
	<div class="row">
		<div class="span12">
		
			<!-- Tableau de la bouffe -->
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Restaurant</th>
						<th>Assiette 1</th>
						<th>Assiette 2</th>
						<th>Assiette 3</th>
						<th>Assiette 4</th>
						<th>Assiette 5</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="http://restauration.epfl.ch/Atlantide">L'Atlantide</a></td>
						<td>
							<p><strong>Emincé de veau (CH) sauce chili</strong>
							<br>Mixte de légumes
							<br>Riz Thaï
							<br>Buffet de salades
							<br><small>E 9.50 ; D 9.50 ; C 9.50 ; V 12.00</small></p>
						</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
						<td>-</td>
					</tr>
					
					<tr>
						<td><a href="http://restauration.epfl.ch/le-Parmentier">Le Parmentier</a></td>
						<td>
							<p><strong>Rôti de porc (CH) à l'ancienne</strong>
							<br>
							Petite jardinière
							<br>
							Pomme de terre purée
							<br><small>E 7.00 ; D 8.00 ; C 9.00 ; V 10.50</small></p>
						</td>
						<td>
							<p><strong>Gnocchi farcis au Gorgonzola sauce tomate</strong>
							<br>
							Salade mêlée
							<br><small>E 7.00 ; D 8.00 ; C 9.50 ; V 10.50</small></p>
						</td>
						<td>
							<p><strong>Filet de plie pané</strong>
							<br>
							Légumes
							<br>Riz parfumé
							<br><small>E 7.00 ; D 8.00 ; C 9.50 ; V 10.50</small></p>
						</td>
						<td>
							<p><strong>Omelette aux champignons de Paris</strong>
							<br>
							Jardinière de légumes
							<br>Petites galettes de pomme de terre
							<br><small>E 9.00 ; D 10.00 ; C 11.00 ; V 12.00</small></p>
						</td>
						<td>
							<p><strong>Délice de dinde (CH) aux morilles</strong>
							<br>Déclinaison de légumes
							<br>Polenta
							<br><small>E 13.00 ; D 13.00 ; C 13.00 ; V 13.00</small></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

</body>
</html>