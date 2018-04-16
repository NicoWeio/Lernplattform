  //<meta http-equiv="refresh" content="30"> <!nur zu Testzwecken während des Programmierens!>

  //var zahlen = {{1, "uno"},{2, "dos"},{3, "tres"}};
  //var zahlen = [[1, "uno"],[2, "dos"],[3, "tres"]];

  var preferences;
  var checkSettings;
  var username;

  var serverStatus;

  var current;
  var currentQ;
  var revealed;

var currentVok; //TODO current/-Q weglassen und mit Attributen des gesamt-Vok ersetzen

  //var level = "21 Unidad 6 ¡Bienvenidos a México! - ¡Vamos!";
  //var course = "spanisch-2";
  //var level = "22 Unidad 6 ¡Bienvenidos a México! - Paso 1";

  var course;
  var level;

	var ttsEnabled = true;


  function test() {

  	if (!revealed) {

  		var eingabe = document.getElementById("eingabe").value;

  		if (eingabe.trim() === "") {

  			//TTS verschoben ins reveal
				
  			reveal(true);
  			return;

  		}

  		var checkResult = check(eingabe, current, checkSettings);
  		var checkResultBool = checkResult.bool;

  		if (checkResultBool) {
  			$("#abfrage").html("richtig!");

  			if (preferences.clientSettings.tts.afterCorrectInput === true) tts(function() {
  				newVok();
  			});
  			else setTimeout(function() {
  				newVok();
  			}, 1000);


  		} else {
  			$("#abfrage").html(checkResult.errorType || "falsch!");
				$("#eingabe").addClass("wrong");
				setTimeout(function() {
  				if ((preferences.clientSettings.afterWrongInput == "empty") || (preferences.clientSettings.afterWrongInput == "smart" && !checkResult.errorType)) document.getElementById("eingabe").value = "";
					$("#eingabe").removeClass("wrong");
				}, 200);
				setTimeout(function() {
  				$("#abfrage").html(currentQ);
  			}, 1000);
				//if (!checkResult.quite) $("#eingabe").addClass("quite"); //TODO
  		}

  		if (serverStatus === true) httpGet("https://lernen2.nicolaiweitkemper.de/Backend/vok-answer.php?spa=" + encodeURIComponent(current) + "&correct=" + (checkResultBool ? "true" : "false") + "&input=" + eingabe + "&course=" + course + "&level=" + level + "&username=" + username, function() {
  			return;
  		});
  	} else {
  		setTimeout(function() {
  			newVok();
  		}, 400);
  	}
  }

  function newVok() {

  	//if (serverStatus == false) return; //TODO P2

  	serverStatus = false;

  	setTimeout(function() {
  		if (!serverStatus) $("#button-box").addClass("loading");
  	}, 500);

  	httpGet("https://lernen2.nicolaiweitkemper.de/Backend/vok-new-smart.php?level=" + level + "&course=" + course + "&last=" + current + "&username=" + username,
  		function(result) {

  			var vok = JSON.parse(result);
  			//      var hint = //TODO
  			revealed = false;
  			revealPos = 0;

  			serverStatus = true;

			currentVok = vok;
  			current = vok["spa"];
  			currentQ = vok["ger"];
  			document.getElementById("abfrage").innerHTML = currentQ;
  			document.getElementById("hint").value = vok.userdata.hint || "";
  			document.getElementById("eingabe").value = "";
  			$("#reveal_button").removeClass("disabled");
  			$("#reveal_part_button").removeClass("disabled");
  			$("#eingabe").removeClass("correct");
  			document.getElementById("eingabe").readOnly = false;
  			document.getElementById("eingabe").focus();
  			$("#button-box").removeClass("loading");

  			document.getElementById("success_rate_display").innerHTML = vok.userdata.success_rate || "";

  			ttsPrepare();

  		});
  }


  function reveal(bad) {
		
		if (bad) httpGet("https://lernen2.nicolaiweitkemper.de/Backend/vok-answer.php?spa=" + encodeURIComponent(current) + '&correct=false&input=""&course=' + course + "&username=" + username + "&level=" + level, function() {});
		
		if (preferences.clientSettings.tts.afterReveal === true) tts();
  	revealed = true;
  	document.getElementById("eingabe").value = current;
  	$("#reveal_button").addClass("disabled");
  	$("#reveal_part_button").addClass("disabled");
  	$("#eingabe").addClass("correct");
  	document.getElementById("eingabe").readOnly = true;
  	document.getElementById("submit_button").focus();
  	//verschoben zum invoker

  }

  function onLoad() {

  	//document.getElementById("eingabe")
		document.body.addEventListener("keyup", function(event) {
  		event.preventDefault();
  		if (event.keyCode == 13) {
  			//document.getElementById("submit_button").click();
				onEnter();
  		}
  	});

  	username = getCookie("Lernplattform-Login");


  	var url = new URL(window.location.href);
  	var URLcourse = url.searchParams.get("course");
  	var URLlevel = url.searchParams.get("level");

  	if (URLcourse === null) window.location.href = "/Auswahl";
  	if (!username) window.location.href = "/Login";

  	course = URLcourse;
  	level = URLlevel;



  	httpGet("https://lernen2.nicolaiweitkemper.de/Backend/userdata-get.php?username=" + username, function(result) {

  		//TODO Fehler catchen
  		//dann:
  		//window.location = "login.html"; //TODO testen

  		preferences =  JSON.parse(result); //result hat nur die preferences der Userdata-JSON-Datei!
  		checkSettings = preferences.checkSettings;
			//ttsEnabled = preferences.clientSettings.tts.enabled //TODO einführen?
  		newVok();

  	});

  	//hier nix mehr schreiben!

  }

  var ttsAudio;

  var ttsAudioCache = {};

  function ttsPrepare() {

  	var text = current;
		var language = currentVok["tts-language"] || "es";

  	for (var key in preferences.clientSettings.tts.customReplacementsRegEx) {
  		text = text.replace(new RegExp(key), preferences.clientSettings.tts.customReplacementsRegEx[key]);
  	}

  	if (!ttsAudioCache[text]) {

  		ttsAudio = new Audio(
  			(preferences.clientSettings.tts.engine == "google") ?
  			//	"https://translate.google.com/translate_tts?ie=UTF-8&q=" + encodeURIComponent(text) + "&tl=es&tk=227726.332519&client=t" : 
  			//	"https://translate.google.com/translate_tts?ie=UTF-8&q=" + encodeURIComponent(text) + "&tl=es&client=tw-ob" : 
  			"https://google-translate-proxy.herokuapp.com/api/tts?query=" + encodeURIComponent(text) + "&language=" + encodeURIComponent(language) :
  			//TODO &speed=0.24
  			"https://api.voicerss.org/?key=39f3beb80da44ab393c87a9ccab79d21&hl=es-es&src=" + encodeURIComponent(text) + "&r=-5&f=ulaw_44khz_stereo");

  		ttsAudioCache[text] = ttsAudio;

  	} else {
  		ttsAudio = ttsAudioCache[text];
  	}

  }

  function tts(onEnded) {
		if (ttsEnabled) {
  		ttsAudio.play();
  		ttsAudio.onended = onEnded;
		}
		else {
			setTimeout(onEnded,700);
		}
  }

  function editHint() {
  	document.getElementById("hint").readOnly = false;
		$("#hint").addClass("edit");
		//$("#hint").removeClass("noselect");
  	document.getElementById("hint").focus();
  }

  function editHintFinish() {
  	document.getElementById("hint").readOnly = true;
		$("#hint").removeClass("edit");
		//$("#hint").addClass("noselect");
  	var hint = document.getElementById("hint").value;
  	httpGet("https://lernen2.nicolaiweitkemper.de/Backend/vok-hint-change.php?spa=" + encodeURIComponent(current) + "&hint=" + encodeURIComponent(hint) + '&course=' + course + "&username=" + username + "&level=" + level, function() {});
  }


  /*String.prototype.replaceAt=function(index, replacement) {
      return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
  }*/

  var revealPos;

  function revealPart() {
  	revealPos++;

  	var eingabe = document.getElementById("eingabe").value;

  	//if (revealPos == current.length-1)


  	//if (eingabe == current.slice(0, revealPos)) eingabe[revealPos+1] = current[revealPos+1];
  	//else eingabe = current.slice(0, revealPos);

  	/*eingabe.forEach(function(c, i) {
  	if (c != current[i]) {
  	    eingabe[i] = current[i];
  	    exit;
  	  }
  	});*/

  	var prefs = preferences.clientSettings.revealPart;

  	for (var i = 0; i < current.length; i++) {
  		if (eingabe[i] != current[i]) {

  			var veto = false;

  			var compareIn = eingabe[i] || "";
  			var compareSol = current[i];

  			if (prefs.tolerate.case) {
  				if (compareIn.toLowerCase() == compareSol.toLowerCase()) veto = true;
  			}

  			prefs.tolerate.custom.forEach(function(c) {
  				if (c == compareSol || c == compareIn) veto = true;
  			});

  			//TODO das ist ziemlich kacke gelöst - z.B. sobald es einen Akzent gibt, wird's getriggert...

  			if (veto) eingabe = eingabe.substr(0, i) + current[i] + eingabe.substr(i + 1, eingabe.length);
  			else eingabe = eingabe.substr(0, i) + current[i];

  			break;
  		}
  	}

  	document.getElementById("eingabe").value = eingabe;
		$("#eingabe").focus();

		
		
  	if (eingabe == current) {
		
			reveal();
			
			revealed = true;
			
		}

  }

function onEnter() {
	if (document.getElementById("hint").readOnly === false) {
		editHintFinish();
		$("#eingabe").focus();
	}
	else if (revealed) newVok();
	else test();
}

function toggleTTS() {
	ttsEnabled = !ttsEnabled;
	$("#toggle-tts").html("Sprachausgabe " + (ttsEnabled ? "ausschalten" : "einschalten"));
	$("#eingabe").focus();
}
