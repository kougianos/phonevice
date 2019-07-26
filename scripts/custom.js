document.getElementById("+/-$10").onclick = function () {
	TenRange()
};

function TenRange() {
	document.getElementById("range").value = '10';
	document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./images/tick.png" style="height: 10px; display: inline;">';
	document.getElementById("+/-$10").classList.add('blacktext');
	document.getElementById("+/-$10").classList.remove('graytext');
	document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./images/tick.png" style="height: 10px; display: none;">';
	document.getElementById("+/-$20").classList.add('graytext');
	document.getElementById("+/-$20").classList.remove('blacktext');
	document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./images/tick.png" style="height: 10px; display: none;">';
	document.getElementById("+/-$50").classList.add('graytext');
	document.getElementById("+/-$50").classList.remove('blacktext');
}

document.getElementById("+/-$20").onclick = function () {
	TwentyRange()
};

function TwentyRange() {
	document.getElementById("range").value = '20';
	document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./images/tick.png" style="height: 10px; display: inline;">';
	document.getElementById("+/-$20").classList.add('blacktext');
	document.getElementById("+/-$20").classList.remove('graytext');
	document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./images/tick.png" style="height: 10px; display: none;">';
	document.getElementById("+/-$10").classList.add('graytext');
	document.getElementById("+/-$10").classList.remove('blacktext');
	document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./images/tick.png" style="height: 10px; display: none;">';
	document.getElementById("+/-$50").classList.add('graytext');
	document.getElementById("+/-$50").classList.remove('blacktext');
}

document.getElementById("+/-$50").onclick = function () {
	FiftyRange()
};

function FiftyRange() {
	document.getElementById("range").value = '50';
	document.getElementById("+/-$50").innerHTML = '+/-$50 <img src="./images/tick.png" style="height: 10px; display: inline;">';
	document.getElementById("+/-$50").classList.add('blacktext');
	document.getElementById("+/-$50").classList.remove('graytext');
	document.getElementById("+/-$10").innerHTML = '+/-$10 <img src="./images/tick.png" style="height: 10px; display: none;">';
	document.getElementById("+/-$10").classList.add('graytext');
	document.getElementById("+/-$10").classList.remove('blacktext');
	document.getElementById("+/-$20").innerHTML = '+/-$20 <img src="./images/tick.png" style="height: 10px; display: none;">';
	document.getElementById("+/-$20").classList.add('graytext');
	document.getElementById("+/-$20").classList.remove('blacktext');
}

document.getElementById("submit").onclick = function () {
	SubmitForm()
};

function SubmitForm() {
	document.getElementById("form").submit();
}