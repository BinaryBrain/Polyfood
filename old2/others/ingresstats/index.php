<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Ingress Stats</title>
    <link href="css/bootstrap.css" rel="stylesheet" media="screen" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1.0;">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" />
		<script>
		function increase(type, number) {
			pR[type*8+number] = Math.min(pR[type*8+number]+1, 8);
			var id = ["#portalResonator", "#rAcq", "#bAcq"][type];
			inputForm[type*8+number].value = pR[type*8+number];
			if(type==0){lColorize(id+number, pR[type*8+number]);}
		}
		
		function decrease(type, number) {
			pR[type*8+number] = Math.max(pR[type*8+number]-1, 0);
			var id = ["#portalResonator", "#rAcq", "#bAcq"][type];
			inputForm[type*8+number].value = pR[type*8+number];
			if(type==0){lColorize(id+number, pR[type*8+number]);}
		}
		
		function lColor(level) {
			return ["#D0D0D0","#FECE5A","#FFA630","#FF7315","#E40000","#FD2992","#EB26CD","#C124E0","#9627F4"][level];
		}
		
		function lColorize(id, level) {
			$(id)[0].style.color = lColor(level);
		}
		
		function input(type, number) {
			var id = ["#portalResonator", "#rAcq", "#bAcq"][type];
			pR[type*8+number]=parseInt($(id+number)[0].value);
			if(type==0){lColorize(id+number, $(id+number)[0].value);}
		}
		
		var pR = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
		inputForm = [0];
		</script>
	</head>
	<body>
		<div class="container">
			<div class="layout">
				<form>
				<h1>Ingress Stats</h1>
				<div id="resLevels">
					<h2>Resonators Levels</h2>
					<table class="portalInfos">
						<tr><td></td>
							<td><input type="button" class="spinButton" value="+" onClick='increase(0, 1);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="+" onClick='increase(0, 2);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="+" onClick='increase(0, 3);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="+" onClick='increase(0, 4);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="+" onClick='increase(0, 5);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="+" onClick='increase(0, 6);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="+" onClick='increase(0, 7);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="+" onClick='increase(0, 8);' tabIndex="-1"></td>
						</tr>
						<tr>
							<td>Lv</td>
							<td><input type="number" class="level" id="portalResonator1" min="0" max="8" maxlength="1" placeholder="0" oninput='input(0, 1)'>
							<td><input type="number" class="level" id="portalResonator2" min="0" max="8" maxlength="1" placeholder="0" oninput='input(0, 2)'>
							<td><input type="number" class="level" id="portalResonator3" min="0" max="8" maxlength="1" placeholder="0" oninput='input(0, 3)'>
							<td><input type="number" class="level" id="portalResonator4" min="0" max="8" maxlength="1" placeholder="0" oninput='input(0, 4)'>
							<td><input type="number" class="level" id="portalResonator5" min="0" max="8" maxlength="1" placeholder="0" oninput='input(0, 5)'>
							<td><input type="number" class="level" id="portalResonator6" min="0" max="8" maxlength="1" placeholder="0" oninput='input(0, 6)'>
							<td><input type="number" class="level" id="portalResonator7" min="0" max="8" maxlength="1" placeholder="0" oninput='input(0, 7)'>
							<td><input type="number" class="level" id="portalResonator8" min="0" max="8" maxlength="1" placeholder="0" oninput='input(0, 8)'>
						</tr>
						<tr><td></td>
							<td><input type="button" class="spinButton" value="-" onClick='decrease(0, 1);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="-" onClick='decrease(0, 2);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="-" onClick='decrease(0, 3);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="-" onClick='decrease(0, 4);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="-" onClick='decrease(0, 5);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="-" onClick='decrease(0, 6);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="-" onClick='decrease(0, 7);' tabIndex="-1"></td>
							<td><input type="button" class="spinButton" value="-" onClick='decrease(0, 8);' tabIndex="-1"></td>
						</tr>
					</table>
				</div>
				<div id="itemsAcq">
					<h2>Items acquired</h2>
					<table>
						<tr>
							<td style = "border-right: 1px solid #008EB5; padding-right: 6px;">
								<h4>Resonators</h4>
								<table class="resonatorsAcquired">
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(1, 1);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="rAcq1" placeholder="0" class="itemAcquired" oninput='input(1, 1)'><input type="button" class="spinButton" value="+" onClick='increase(1, 1);' tabIndex="-1"></td><td class="l1"> L1</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(1, 2);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="rAcq2" placeholder="0" class="itemAcquired" oninput='input(1, 2)'><input type="button" class="spinButton" value="+" onClick='increase(1, 2);' tabIndex="-1"></td><td class="l2"> L2</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(1, 3);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="rAcq3" placeholder="0" class="itemAcquired" oninput='input(1, 3)'><input type="button" class="spinButton" value="+" onClick='increase(1, 3);' tabIndex="-1"></td><td class="l3"> L3</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(1, 4);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="rAcq4" placeholder="0" class="itemAcquired" oninput='input(1, 4)'><input type="button" class="spinButton" value="+" onClick='increase(1, 4);' tabIndex="-1"></td><td class="l4"> L4</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(1, 5);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="rAcq5" placeholder="0" class="itemAcquired" oninput='input(1, 5)'><input type="button" class="spinButton" value="+" onClick='increase(1, 5);' tabIndex="-1"></td><td class="l5"> L5</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(1, 6);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="rAcq6" placeholder="0" class="itemAcquired" oninput='input(1, 6)'><input type="button" class="spinButton" value="+" onClick='increase(1, 6);' tabIndex="-1"></td><td class="l6"> L6</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(1, 7);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="rAcq7" placeholder="0" class="itemAcquired" oninput='input(1, 7)'><input type="button" class="spinButton" value="+" onClick='increase(1, 7);' tabIndex="-1"></td><td class="l7"> L7</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(1, 8);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="rAcq8" placeholder="0" class="itemAcquired" oninput='input(1, 8)'><input type="button" class="spinButton" value="+" onClick='increase(1, 8);' tabIndex="-1"></td><td class="l8"> L8</td></tr>
								</table>
							</td><td style="padding-left: 6px;">
								<h4>XMP Bursters</h4>
								<table class="burstersAcquired">
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(2, 1);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="bAcq1" placeholder="0" class="itemAcquired" oninput='input(2, 1)'><input type="button" class="spinButton" value="+" onClick='increase(2, 1);' tabIndex="-1"></td><td class="l1"> L1</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(2, 2);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="bAcq2" placeholder="0" class="itemAcquired" oninput='input(2, 2)'><input type="button" class="spinButton" value="+" onClick='increase(2, 2);' tabIndex="-1"></td><td class="l2"> L2</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(2, 3);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="bAcq3" placeholder="0" class="itemAcquired" oninput='input(2, 3)'><input type="button" class="spinButton" value="+" onClick='increase(2, 3);' tabIndex="-1"></td><td class="l3"> L3</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(2, 4);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="bAcq4" placeholder="0" class="itemAcquired" oninput='input(2, 4)'><input type="button" class="spinButton" value="+" onClick='increase(2, 4);' tabIndex="-1"></td><td class="l4"> L4</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(2, 5);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="bAcq5" placeholder="0" class="itemAcquired" oninput='input(2, 5)'><input type="button" class="spinButton" value="+" onClick='increase(2, 5);' tabIndex="-1"></td><td class="l5"> L5</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(2, 6);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="bAcq6" placeholder="0" class="itemAcquired" oninput='input(2, 6)'><input type="button" class="spinButton" value="+" onClick='increase(2, 6);' tabIndex="-1"></td><td class="l6"> L6</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(2, 7);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="bAcq7" placeholder="0" class="itemAcquired" oninput='input(2, 7)'><input type="button" class="spinButton" value="+" onClick='increase(2, 7);' tabIndex="-1"></td><td class="l7"> L7</td></tr>
									<tr><td><input type="button" class="spinButton" value="-" onClick='decrease(2, 8);' tabIndex="-1"><input type="number" min="0" max="8" maxlength="1" id="bAcq8" placeholder="0" class="itemAcquired" oninput='input(2, 8)'><input type="button" class="spinButton" value="+" onClick='increase(2, 8);' tabIndex="-1"></td><td class="l8"> L8</td></tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
				<div id="validate">
					<input type="submit" value="Submit">
				</div>
				</form>
			</div>
		</div>
		<script src="http://code.jquery.com/jquery-latest.js">
		</script>
		<script>
			for (var i = 1; i <= 8; i++) {
				inputForm[i] = $("#portalResonator"+i)[0];
			}
			for (var i = 9; i <= 16; i++) {
				inputForm[i] = $("#rAcq"+(i-8))[0];
			}
			for (var i = 17; i <= 24; i++) {
				inputForm[i] = $("#bAcq"+(i-16))[0];
			}
		</script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
