
var CT = {
  ABE: {
    Settings: {
      webkit: true,
      startTime: +new Date(),
      clientID: '857703',
      language: localeFigame,
      expressBooking: {
	enabled: false
      },
      customFonts: false, //WP-1947
      recentSearches: {
	enabled: true,
	type: 'CHIPS'
      },
      newDriverAge: true,
      step1: {
	deeplinkURL: "https://www.figamecars.com/search.html",
	popoutIFrame: true,
	campaignOffers: true,
	orientation: "landscape",
	hideLabels: true,
	showAgeInput: true,
	strings: {
	  headingText: heading
	},
	i18n: {
	  legend: "<span></span>" + heading,
	  searchButton: buttonFigame
	}
      },
    }
  }
};

/**
 * Convert Year, month, day into an Unix Timestamp
 * ---------------------------------------------------------------------
 * @param  {object} dateParams  {y: year, m: javascript month, d: day}
 * @return {integer}        A Unix Timestamp
 */
window.dateToUnixTimeStamp = function (dateParams) {
  return new Date(dateParams.y, dateParams.m, dateParams.d).getTime();
};

function displayCurrentDateTime(k, m) {
  if (k != "el" && k != "en" && k != "fr" && k != "de" && k != "es" && k != "it") {
    k = "en"
  }
  if (m != "long" && m != "short") {
    m = "long"
  }
  var c = k + m;
  var d = null;
  var f = null;
  var l = null;
  switch (c) {
    case "ellong":
      d = new Array("Κυριακή", "Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο");
      f = new Array("", "Ιανουάριος", "Φεβρουάριος", "Μάρτιος", "Απρίλιος", "Μάιος", "Ιούνιος", "Ιούλιος", "Αύγουστος", "Σεπτέμβριος", "Οκτώβριος", "Νοέμβριος", "Δεκέμβριος");
      l = new Array("μμ", "πμ");
      break;
    case "elshort":
      d = new Array("Κυρ", "Δευ", "Τρι", "Τετ", "Πεμ", "Παρ", "Σαβ");
      f = new Array("", "Ιαν", "Φεβ", "Μαρ", "Απρ", "Μαι", "Ιουν", "Ιουλ", "Αυγ", "Σεπ", "Οκτ", "Νοε", "Δεκ");
      l = new Array("μμ", "πμ");
      break;
    case "enlong":
      d = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
      f = new Array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      l = new Array("pm", "am");
      break;
    case "enshort":
      d = new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
      f = new Array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
      l = new Array("pm", "am");
      break;
    case "frlong":
      d = new Array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
      f = new Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
      l = new Array("", "");
      break;
    case "frshort":
      d = new Array("dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam.");
      f = new Array("", "janv.", "févr.", "mars", "avr.", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc.");
      l = new Array("", "");
      break;
    case "delong":
      d = new Array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
      f = new Array("", "Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
      l = new Array("", "");
      break;
    case "deshort":
      d = new Array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa");
      f = new Array("", "Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");
      l = new Array("", "");
      break;
    case "eslong":
      d = new Array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
      f = new Array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
      l = new Array("pm", "am");
      break;
    case "esshort":
      d = new Array("dom", "lun", "mar", "mié", "jue", "vie", "sáb");
      f = new Array("", "ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");
      l = new Array("pm", "am");
      break;
    case "itlong":
      d = new Array("Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato");
      f = new Array("", "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
      l = new Array("", "");
      break;
    case "itshort":
      d = new Array("Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab");
      f = new Array("", "Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic");
      l = new Array("", "");
      break;
    default:
      return false
  }
  var i = new Date();
  var j = d[i.getDay()];
  var e = f[i.getMonth() + 1];
  var b = null;
  if (m == "long") {
    b = i.getYear();
    if (b < 1000) {
      b += 1900
    }
  } else {
    b = ""
  }
  var g = i.getHours();
  if (g < 10) {
    g = "0" + g
  }
  var a = i.getMinutes();
  if (a < 10) {
    a = "0" + a
  }
  var h = j + ", " + i.getDate() + " " + e + " " + b + "&nbsp;" + g + ":" + a;
  if (document.getElementById) {
    document.getElementById("dateinformation").innerHTML = h
  } else {
    if (document.all) {
      document.all.dateinformation.innerHTML = h
    }
  }
}

$(document).ready(function () {

	// Open new tab on anchor click
	$(document).on('click', 'a[rel*=external]', function (e) {

		window.open(this.href);
		return false;

	});

	// Search by location on figure click
	$("#imageGrid").on("click", "figure", function () {

		top.location.href ="index.html?pickupLocation=" + $(this).data("ctid");
		return true;

	});

	// Scroll imageGrid left by 300px
	$("#scrollLeft").on("click", function () {

		$('#imageGrid').animate( { scrollLeft: '-=320px' });

	});

	// Scroll imageGrid right by 300px
	$("#scrollRight").on("click", function () {

		$('#imageGrid').animate( { scrollLeft: '+=320px' });

	});


});

