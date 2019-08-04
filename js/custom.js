$(document).ready(function () {

	// Enable tooltips
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})

	// Budget page implementation - +/-$10	+/-$20	+/-$50
	if (document.getElementById('budget_page')) {

		document.getElementById("+/-$10").onclick = function () {
			TenRange()
		};

		function TenRange() {
			document.getElementById("range").value = '10';
			document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./img/tick.png" style="height: 10px; display: inline;">';
			document.getElementById("+/-$10").classList.add('blacktext');
			document.getElementById("+/-$10").classList.remove('graytext');
			document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./img/tick.png" style="height: 10px; display: none;">';
			document.getElementById("+/-$20").classList.add('graytext');
			document.getElementById("+/-$20").classList.remove('blacktext');
			document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./img/tick.png" style="height: 10px; display: none;">';
			document.getElementById("+/-$50").classList.add('graytext');
			document.getElementById("+/-$50").classList.remove('blacktext');
		}

		document.getElementById("+/-$20").onclick = function () {
			TwentyRange()
		};

		function TwentyRange() {
			document.getElementById("range").value = '20';
			document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./img/tick.png" style="height: 10px; display: inline;">';
			document.getElementById("+/-$20").classList.add('blacktext');
			document.getElementById("+/-$20").classList.remove('graytext');
			document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./img/tick.png" style="height: 10px; display: none;">';
			document.getElementById("+/-$10").classList.add('graytext');
			document.getElementById("+/-$10").classList.remove('blacktext');
			document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./img/tick.png" style="height: 10px; display: none;">';
			document.getElementById("+/-$50").classList.add('graytext');
			document.getElementById("+/-$50").classList.remove('blacktext');
		}

		document.getElementById("+/-$50").onclick = function () {
			FiftyRange()
		};

		function FiftyRange() {
			document.getElementById("range").value = '50';
			document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./img/tick.png" style="height: 10px; display: inline;">';
			document.getElementById("+/-$50").classList.add('blacktext');
			document.getElementById("+/-$50").classList.remove('graytext');
			document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./img/tick.png" style="height: 10px; display: none;">';
			document.getElementById("+/-$10").classList.add('graytext');
			document.getElementById("+/-$10").classList.remove('blacktext');
			document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./img/tick.png" style="height: 10px; display: none;">';
			document.getElementById("+/-$20").classList.add('graytext');
			document.getElementById("+/-$20").classList.remove('blacktext');
		}

		document.getElementById("submit").onclick = function () {
			SubmitForm();
		};

		function SubmitForm() {
			document.getElementById("form").submit();
		}

	}

	// Click on feature image implementation
	$(document).on("click", ".featureImage", function () {

		// If feature is disabled then return
		if ($(this).hasClass("featureDisabled"))
			return;

		// If feature is already selected then unselect it and vice versa
		if ($(this).hasClass("featureImageSelected")) {

			$(this).removeClass("featureImageSelected");
			$(this).next().prop("checked", false).trigger('change');

		} else {

			$(this).addClass("featureImageSelected");
			$(this).next().prop("checked", true).trigger('change');

		}

	});

	// Check features on the fly implementation
	$('#featuresForm').on('change', null, function () {

		// Serialize form inputs
		var serializedForm = $('#featuresForm').serializeArray();

		// Ajax check available features
		$.ajax({

			type: "POST",
			timeout: 30000,
			url: "ajax/features-check.html",
			data: {
				action: "features_check",
				features: serializedForm
			}

		}).always(function (featuresCheckResponse) {

			// If no feature is selected then make them all available and return. Same on error
			if (featuresCheckResponse == "none-selected" || featuresCheckResponse == "error") {
				$(".featureImage").removeClass("featureDisabled").next().attr("disabled", false);
				return;
			}

			$.each(featuresCheckResponse, function (index, value) {

				var featureImage = $('#' + value);

				if (!(featureImage.hasClass("featureDisabled"))) {

					featureImage.addClass("featureDisabled").next().attr("disabled", true);

				}

			});

		});

	});

});