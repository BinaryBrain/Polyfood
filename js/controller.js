format()

Preferences = {
	defaultPriceType: "Etudiant",
	defaultPrice: 0,
	defaultCheckboxes: [],
	
	storageWorks: (typeof(Storage)!=="undefined"),
	
	getPriceType: function() {
		if(this.storageWorks && localStorage.priceType !== null && localStorage.priceType !== undefined)
			return localStorage.priceType
		else
			return this.defaultPriceType
	},
	
	getPrice: function() {
		if(this.storageWorks && localStorage.price !== null && localStorage.price !== undefined)
			return parseFloat(localStorage.price)
		else
			return this.defaultPrice
	},
	
	getCheckboxes: function() {
		if(this.storageWorks && localStorage.checkboxes !== null && localStorage.checkboxes !== undefined)
			return JSON.parse(localStorage.checkboxes)
		else
			return this.defaultCheckboxes
	},
	
	save: function(priceType, maxPrice, checkboxIDArray) {
		if(this.storageWorks) {
			checkboxesJson = JSON.stringify(checkboxIDArray)
			localStorage.priceType	= priceType
			localStorage.price		= maxPrice
			localStorage.checkboxes	= checkboxesJson
		}
		else
			console.log("Warning: Local Storage is not supported.")
	},
}

function firstConnexion() {
	return (Preferences.getPrice() == Preferences.defaultPrice && Preferences.getPriceType() == Preferences.defaultPriceType && Preferences.getCheckboxes() == Preferences.defaultCheckboxes)
}

function format() {
	var i = 0
	while(i < json.length) {
		// Description
		var lines = json[i].description.split("\n")
		lines[0] = "<strong>"+lines[0]+"</strong>"
		json[i].description = lines.join("<br>")
		
		// Remove "Le", "La", "Les" "L'"
		json[i].restaurant.nom = json[i].restaurant.nom.replace(/^L[aes']\s?/i, "")

		// Parmentier - Vinci
		if(json[i].restaurant.nom == "Parmentier") {
			json[i].restaurant.nom = "Parmentier<br>Vinci"
		}
		else if(json[i].restaurant.nom == "Vinci") {
			// Remove Vinci
			json.splice(i, 1)
			i--
		}
		i++
	}
}

function refreshForm(priceType, maxPrice, checkboxIDArray) {
	$("#select01").val(priceType)
	$("#input01").val(maxPrice)

	for(var i in checkboxIDArray) {
		$("input[type=checkbox]#"+checkboxIDArray[i]).attr("checked", "checked")
	}
}

function refreshTable(priceType, maxPrice, checkboxIDArray) {
	checkboxIDArrayAll = []
	$("input[type=checkbox]").each(function(i) {
		checkboxIDArrayAll.push($("input[type=checkbox]")[i].id)
	})
	
	if(checkboxIDArray.length == 0)
		checkboxIDArray = checkboxIDArrayAll
	
	var html = ""
	
	for(var i in json) {
		if(priceType == "Etudiant")
			var price = json[i].prix.E
		else if(priceType == "Doctorant")
			var price = json[i].prix.D
		else if(priceType == "Professeur")
			var price = json[i].prix.C
		else
			var price = json[i].prix.V
		
		price = parseFloat(price)
		maxPrice = parseFloat(maxPrice)
		
		if(isNaN(maxPrice))
			maxPrice = 0
		
		function restaurantChecked(val) {
			if(!!json[i].restaurant.nom.match(new RegExp(val,"i"), ""))
				return true
			return false
		}
		
		var visible = ((price <= maxPrice || maxPrice == 0) && checkboxIDArray.some(restaurantChecked))
		
		if(visible) {
			var rname = json[i].restaurant.nom
			if(isFBConnected)
				html += '<tr data-restaurant="'+rname+'" class="dish connected">'
			else
				html += '<tr data-restaurant="'+rname+'" class="dish">'
				
				html += "<td class=\"restaurant clickable\" onclick=\"window.open('"+json[i].restaurant.lien+"','_newtab')\">"
					html += "<strong>"+rname+"</strong>"
				html += "</td>"
				html += '<td class="logo">'
					html += '<img src="img/types/'+json[i].logo+'.png" title="'+json[i].logo+'">'
				html += "</td>"
				html += '<td class="description clickable">'
					html += json[i].description
				html += "</td>"
				html += '<td class="price">'
					html += price
				html += "</td>"
				if(isFBConnected) {
					var empty = true
					var _html = ''
					for(var i=0, len=friendsplaces.length; i<len; i++) {
						if(friendsplaces[i].restaurant == rname) {
							_html += '<img src="https://graph.facebook.com/'+friendsplaces[i].fbid+'/picture" title="'+friendsplaces[i].fbname+'"> '
							empty = false
						}
					}
					if(empty)
						html += '<td class="friends">'
					else
						html += '<td class="friends clickable">'
						
						html += _html
					html += "</td>"
					//html += '<td class="total">'
					//html += "</td>"
				}
			html += "</tr>"
		}
	}
	
	$("#data").html(html)
	//$("#priceType").html(" ("+priceType+")")
	if(maxPrice != 0)
		$("#maxPrice").html(" ≤ "+maxPrice+"")
	else
		$("#maxPrice").html("")
	
	$("#mainTable").trigger("update")
}

// MAIN
$(function() {
	var priceType = Preferences.getPriceType()
	var price = Preferences.getPrice()
	var checkboxes = Preferences.getCheckboxes()
	
	refreshTable(priceType, price, checkboxes)
	refreshForm(priceType, price, checkboxes)
	
	$("#mainTable").tablesorter({
		textExtraction:function(s){
			if($(s).find('img').length == 0) return $(s).text()
			return $(s).find('img').attr('title')
		},
		sortList: [[0,0],[3,0]],
		debug: false
	})
	
	$('#mainTable th:not(.sorter-false)').tooltip({title:"Shift pour un tri multiple", delay:{show: 500, hide: 100}})
	$('#mainTable .clickable.restaurant').tooltip({title:"Plus d'infos sur le restaurant", placement:"left", delay:{show: 500, hide: 100}})
	$('#mainTable .clickable.friends').tooltip({title:"Détails sur les amis", placement:"right", delay:{show: 500, hide: 100}})
	$('#mainTable .clickable.description').tooltip({title:"Indiquez à mes amis que je mange ici", placement:"top", delay:{show: 500, hide: 100}})
	
	$(".collapse").collapse()
	
	$("#price").submit(function() {
		checkboxIDArray = []
		$("input[type=checkbox]:checked").each(function(i) {
			checkboxIDArray.push($("input[type=checkbox]:checked")[i].id)
		})
		
		refreshTable($("#price #select01").val(), $("#price #input01").val(), checkboxIDArray)
		Preferences.save($("#price #select01").val(), $("#price #input01").val(), checkboxIDArray)
		return false
	})
	
	$("input, select").change(function() {
		checkboxIDArray = []
		$("input[type=checkbox]:checked").each(function(i) {
			checkboxIDArray.push($("input[type=checkbox]:checked")[i].id)
		})
		
		refreshTable($("#price #select01").val(), $("#price #input01").val(), checkboxIDArray)
		Preferences.save($("#price #select01").val(), $("#price #input01").val(), checkboxIDArray)
	})
	
	if(firstConnexion()) {
		var html = ""
		html += '<div class="alert alert-info">Les données sont automatiquement sauvegardées sur votre navigateur.</div>'
		$("#infos").html(html)
	}
	
	if(isFBConnected) {
		$("#mainTable tr.dish td.description").live('click', function () {
			var restaurant = $(this).parent().attr("data-restaurant")
			
			$("#placeModal .restaurant").html(restaurant)
			$('#placeModal').modal()
		})
		
		$("#mainTable tr.dish td.friends.clickable").live('click', function () {
			var restaurant = $(this).parent().attr("data-restaurant")
			
			html = '<table class="table">'
			for(var i=0, len=friendsplaces.length; i<len; i++) {
				if(friendsplaces[i].restaurant == restaurant) {
					html += '<tr>'
						html += '<td><img src="https://graph.facebook.com/'+friendsplaces[i].fbid+'/picture" title="'+friendsplaces[i].fbname+'"></td>'
						html += '<td><a class="facebookname" href="https://facebook.com/'+friendsplaces[i].fbid+'" target="_blank">'+friendsplaces[i].fbname+'</a></td>'
						html += '<td>'+friendsplaces[i].hour.slice(0, -3)+'</td>'
					html += '</tr>'
				}
			}
			html += '</table>'
			
			$("#friendsModal .restaurant").html(restaurant)
			$("#friendsModal .modal-body").html(html)
			
			$("#friendsModal").modal()
		})
		
		$("#placeModal form").live('submit', function () {
			var restaurant = $("#placeModal .restaurant").html()
			var hour = $("#placeModal form #hour").val()
			
			$.get("inomhere.php?place="+restaurant+"&hour="+hour, function (data) {
				$("#placeModal").modal('hide')
			})
			
			return false
		})
	}
})
