
// Jquery UI touch punch
! function (a) {
	function f(a, b) {
		if (!(a.originalEvent.touches.length > 1)) {
			a.preventDefault();
			var c = a.originalEvent.changedTouches[0],
				d = document.createEvent("MouseEvents");
			d.initMouseEvent(b, !0, !0, window, 1, c.screenX, c.screenY, c.clientX, c.clientY, !1, !1, !1, !1, 0, null), a.target.dispatchEvent(d)
		}
	}
	if (a.support.touch = "ontouchend" in document, a.support.touch) {
		var e, b = a.ui.mouse.prototype,
			c = b._mouseInit,
			d = b._mouseDestroy;
		b._touchStart = function (a) {
			var b = this;
			!e && b._mouseCapture(a.originalEvent.changedTouches[0]) && (e = !0, b._touchMoved = !1, f(a, "mouseover"), f(a, "mousemove"), f(a, "mousedown"))
		}, b._touchMove = function (a) {
			e && (this._touchMoved = !0, f(a, "mousemove"))
		}, b._touchEnd = function (a) {
			e && (f(a, "mouseup"), f(a, "mouseout"), this._touchMoved || f(a, "click"), e = !1)
		}, b._mouseInit = function () {
			var b = this;
			b.element.bind({
				touchstart: a.proxy(b, "_touchStart"),
				touchmove: a.proxy(b, "_touchMove"),
				touchend: a.proxy(b, "_touchEnd")
			}), c.call(b)
		}, b._mouseDestroy = function () {
			var b = this;
			b.element.unbind({
				touchstart: a.proxy(b, "_touchStart"),
				touchmove: a.proxy(b, "_touchMove"),
				touchend: a.proxy(b, "_touchEnd")
			}), d.call(b)
		}
	}
}(jQuery);

// Custom Javascript
$(document).ready(function () {

	// Enable tooltips
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})

	// Back button
	$('#backButton').on('click', null, function () {
		window.history.back();

	});

	// Budget implementation - +/-$10	+/-$20	+/-$50
	if (document.getElementById('budget_page')) {

		document.getElementById("+/-$10").onclick = function () {
			TenRange()
		};

		function TenRange() {
			document.getElementById("range").value = '10';
			document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./img/tick.png" style="height: 20px; display: inline;">';
			document.getElementById("+/-$10").classList.add('blacktext');
			document.getElementById("+/-$10").classList.remove('graytext');
			document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./img/tick.png" style="height: 20px; display: none;">';
			document.getElementById("+/-$20").classList.add('graytext');
			document.getElementById("+/-$20").classList.remove('blacktext');
			document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./img/tick.png" style="height: 20px; display: none;">';
			document.getElementById("+/-$50").classList.add('graytext');
			document.getElementById("+/-$50").classList.remove('blacktext');
		}

		document.getElementById("+/-$20").onclick = function () {
			TwentyRange()
		};

		function TwentyRange() {
			document.getElementById("range").value = '20';
			document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./img/tick.png" style="height: 20px; display: inline;">';
			document.getElementById("+/-$20").classList.add('blacktext');
			document.getElementById("+/-$20").classList.remove('graytext');
			document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./img/tick.png" style="height: 20px; display: none;">';
			document.getElementById("+/-$10").classList.add('graytext');
			document.getElementById("+/-$10").classList.remove('blacktext');
			document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./img/tick.png" style="height: 20px; display: none;">';
			document.getElementById("+/-$50").classList.add('graytext');
			document.getElementById("+/-$50").classList.remove('blacktext');
		}

		document.getElementById("+/-$50").onclick = function () {
			FiftyRange()
		};

		function FiftyRange() {
			document.getElementById("range").value = '50';
			document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./img/tick.png" style="height: 20px; display: inline;">';
			document.getElementById("+/-$50").classList.add('blacktext');
			document.getElementById("+/-$50").classList.remove('graytext');
			document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./img/tick.png" style="height: 20px; display: none;">';
			document.getElementById("+/-$10").classList.add('graytext');
			document.getElementById("+/-$10").classList.remove('blacktext');
			document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./img/tick.png" style="height: 20px; display: none;">';
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

	// Features implementation
	if (document.getElementById('features_page')) {

		// Click on feature image implementation
		$(document).on("click", ".featureImage", function () {

			// If feature is disabled then return
			if ($(this).hasClass("featureDisabled") || $(this).hasClass("featureTempDisabled"))
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

			// Temporarily disable form until ajax finishes
			$(".featureImage").addClass("featureTempDisabled");

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
					$(".featureImage").removeClass("featureDisabled").removeClass("featureTempDisabled").next().attr("disabled", false);
					return;
				}

				// Make all features available at each ajax call
				$(".featureImage").removeClass("featureDisabled").removeClass("featureTempDisabled").next().attr("disabled", false);

				// Loop ajax response and disable unavailable features
				$.each(featuresCheckResponse, function (index, value) {

					var featureImage = $('#' + value);

					if (!(featureImage.hasClass("featureDisabled"))) {

						featureImage.addClass("featureDisabled").next().attr("disabled", true);

					}

				});

			});

		});

	}

	// Usage implementation
	if (document.getElementById('usage_page')) {

		// Hide usage choice container on custom button click
		$('#btn-custom').on('click', null, function () {
			$('#usageChoiceContainer').hide("slow");
			$('#resultsButton').attr("disabled", false);

		});

		// Submit form on button click
		$('#resultsButton').on('click', null, function () {
			$('#usageForm').submit();
		});

		// Social slider
		$(function () {
			$("#socialSlider").slider({
				range: "min",
				value: 2,
				min: 0,
				max: 4,
				step: 1,
				slide: function (event, ui) {
					$(".usageSocialSelected").removeClass("usageSocialSelected");
					var usageAmount = $("#usageSocialAmount");
					usageAmount.val(ui.value);
					switch (ui.value) {
						case 0:
							$(".usageSocialUnimportant").addClass("usageSocialSelected");
							break;
						case 1:
							$(".usageSocialSomewhat").addClass("usageSocialSelected");
							break;
						case 2:
							$(".usageSocialRelatively").addClass("usageSocialSelected");
							break;
						case 3:
							$(".usageSocialVery").addClass("usageSocialSelected");
							break;
						case 4:
							$(".usageSocialTop").addClass("usageSocialSelected");
							break;
					}
				},
				create: function (event, ui) {
					$(this).children("span").addClass("sliderSpan");
					$(this).children("div").addClass("sliderSocialDiv");
				}
			});
			$("#usageSocialAmount").val($("#socialSlider").slider("value"));
		});

		// Video slider
		$(function () {
			$("#videoSlider").slider({
				range: "min",
				value: 2,
				min: 0,
				max: 4,
				step: 1,
				slide: function (event, ui) {
					$(".usageVideoSelected").removeClass("usageVideoSelected");
					var usageAmount = $("#usageVideoAmount");
					usageAmount.val(ui.value);
					switch (ui.value) {
						case 0:
							$(".usageVideoUnimportant").addClass("usageVideoSelected");
							break;
						case 1:
							$(".usageVideoSomewhat").addClass("usageVideoSelected");
							break;
						case 2:
							$(".usageVideoRelatively").addClass("usageVideoSelected");
							break;
						case 3:
							$(".usageVideoVery").addClass("usageVideoSelected");
							break;
						case 4:
							$(".usageVideoTop").addClass("usageVideoSelected");
							break;
					}
				},
				create: function (event, ui) {
					$(this).children("span").addClass("sliderSpan");
					$(this).children("div").addClass("sliderVideoDiv");
				}
			});
			$("#usageVideoAmount").val($("#videoSlider").slider("value"));
		});

		// Gaming slider
		$(function () {
			$("#gamingSlider").slider({
				range: "min",
				value: 2,
				min: 0,
				max: 4,
				step: 1,
				slide: function (event, ui) {
					$(".usageGamingSelected").removeClass("usageGamingSelected");
					var usageAmount = $("#usageGamingAmount");
					usageAmount.val(ui.value);
					switch (ui.value) {
						case 0:
							$(".usageGamingUnimportant").addClass("usageGamingSelected");
							break;
						case 1:
							$(".usageGamingSomewhat").addClass("usageGamingSelected");
							break;
						case 2:
							$(".usageGamingRelatively").addClass("usageGamingSelected");
							break;
						case 3:
							$(".usageGamingVery").addClass("usageGamingSelected");
							break;
						case 4:
							$(".usageGamingTop").addClass("usageGamingSelected");
							break;
					}
				},
				create: function (event, ui) {
					$(this).children("span").addClass("sliderSpan");
					$(this).children("div").addClass("sliderGamingDiv");
				}
			});
			$("#usageGamingAmount").val($("#gamingSlider").slider("value"));
		});

	}

});