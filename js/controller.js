format();

Preferences = {
	defaultPriceType: "Etudiant",
	defaultPrice: 0,
	defaultCheckboxes: [],
	
	storageWorks: (typeof(Storage)!=="undefined"),
	
	getPriceType: function() {
		if(this.storageWorks && localStorage.priceType !== null && localStorage.priceType !== undefined)
			return localStorage.priceType;
		else
			return this.defaultPriceType;
	},
	
	getPrice: function() {
		if(this.storageWorks && localStorage.price !== null && localStorage.price !== undefined)
			return parseFloat(localStorage.price);
		else
			return this.defaultPrice;
	},
	
	getCheckboxes: function() {
		if(this.storageWorks && localStorage.checkboxes !== null && localStorage.checkboxes !== undefined)
			return JSON.parse(localStorage.checkboxes);
		else
			return this.defaultCheckboxes;
	},
	
	save: function(priceType, maxPrice, checkboxIDArray) {
		if(this.storageWorks) {
			checkboxesJson = JSON.stringify(checkboxIDArray);
			localStorage.priceType	= priceType;
			localStorage.price		= maxPrice;
			localStorage.checkboxes	= checkboxesJson;
		}
		else
			console.log("Warning: Local Storage is not supported.");
	},
};

function format() {
	var i = 0;
	while(i < json.length) {
		// Description
		var lines = json[i].description.split("\n");
		lines[0] = "<strong>"+lines[0]+"</strong>";
		json[i].description = lines.join("<br>");
		
		// Remove "Le", "La", "Les" "L'"
		json[i].restaurant.nom = json[i].restaurant.nom.replace(/^L[aes']\s?/i, "");

		// Parmentier - Vinci
		if(json[i].restaurant.nom == "Parmentier") {
			json[i].restaurant.nom = "Parmentier<br>Vinci";
		}
		else if(json[i].restaurant.nom == "Vinci") {
			// Remove Vinci
			json.splice(i, 1);
			i--;
		}
		i++
	}
}

function refreshForm(priceType, maxPrice, checkboxIDArray) {
	$("#select01").val(priceType);
	$("#input01").val(maxPrice);

	for(var i in checkboxIDArray) {
		$("input[type=checkbox]#"+checkboxIDArray[i]).attr("checked", "checked");
	}
}

function refreshTable(priceType, maxPrice, checkboxIDArray) {
	checkboxIDArrayAll = [];
	$("input[type=checkbox]").each(function(i) {
		checkboxIDArrayAll.push($("input[type=checkbox]")[i].id)
	});
	
	if(checkboxIDArray.length == 0)
		checkboxIDArray = checkboxIDArrayAll;
	
	var html = "";
	
	for(var i in json) {
		if(priceType == "Etudiant")
			var price = json[i].prix.E;
		else if(priceType == "Doctorant")
			var price = json[i].prix.D;
		else if(priceType == "Professeur")
			var price = json[i].prix.C;
		else
			var price = json[i].prix.V;
		
		price = parseFloat(price);
		maxPrice = parseFloat(maxPrice);
		
		if(isNaN(maxPrice))
			maxPrice = 0;
		
		function restaurantChecked(val) {
			if(!!json[i].restaurant.nom.match(new RegExp(val,"i"), ""))
				return true;
			return false;
		}
		
		var visible = ((price <= maxPrice || maxPrice == 0) && checkboxIDArray.some(restaurantChecked))
		
		if(visible) {
			html += "<tr>";
				html += "<td class=\"clickable\" onclick=\"window.open('"+json[i].restaurant.lien+"','_newtab');\">";
					html += "<strong>"+json[i].restaurant.nom+"</strong>";
				html += "</td>";
				html += "<td>";
					html += '<img src="img/types/'+json[i].logo+'.png" title="'+json[i].logo+'">';
				html += "</td>";
				html += "<td>";
					html += json[i].description;
				html += "</td>";
				html += "<td>";
					html += price;
				html += "</td>";
			html += "</tr>";
		}
	}
	
	$("#data").html(html);
	$("#priceType").html(" ("+priceType+")");
	if(maxPrice != 0)
		$("#maxPrice").html(" ≤ "+maxPrice+"");
	else
		$("#maxPrice").html("");
	
	$("#mainTable").trigger("update");
}

// MAIN
$(document).ready(function() {
	var priceType = Preferences.getPriceType();
	var price = Preferences.getPrice();
	var checkboxes = Preferences.getCheckboxes();
	
	refreshTable(priceType, price, checkboxes);
	refreshForm(priceType, price, checkboxes);
	
	$("#mainTable").tablesorter({
		textExtraction:function(s){
			if($(s).find('img').length == 0) return $(s).text();
			return $(s).find('img').attr('title');
		},
		sortList: [[0,0],[3,0]],
		debug: false
	});
	
	$('#mainTable th:not(.sorter-false)').tooltip({title:"Shift pour un tri multiple", delay:{show: 500, hide: 100}});
	$('#mainTable .clickable').tooltip({title:"Plus d'infos sur le restaurant", placement:"left", delay:{show: 500, hide: 100}});

	$(".collapse").collapse()
	
	$("#price").submit(function() {
		checkboxIDArray = [];
		$("input[type=checkbox]:checked").each(function(i) {
			checkboxIDArray.push($("input[type=checkbox]:checked")[i].id);
		});
		console.log("2", checkboxIDArray);
		
		refreshTable($("#price #select01").val(), $("#price #input01").val(), checkboxIDArray);
		Preferences.save($("#price #select01").val(), $("#price #input01").val(), checkboxIDArray);
		return false;
	});
	$("input, select").change(function() {
		checkboxIDArray = [];
		$("input[type=checkbox]:checked").each(function(i) {
			checkboxIDArray.push($("input[type=checkbox]:checked")[i].id);
		});
		console.log(2, checkboxIDArray);
		
		refreshTable($("#price #select01").val(), $("#price #input01").val(), checkboxIDArray);
		Preferences.save($("#price #select01").val(), $("#price #input01").val(), checkboxIDArray);
	});
});
