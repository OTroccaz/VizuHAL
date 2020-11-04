document.getElementById("tabg").className = "form-group d-none";

var imax = 24;//Nombre total de requêtes

for(let i=1; i<=imax; i++) {
	document.getElementById("req"+i).className = "form-group d-none";
}

function freqt() {
//alert(document.getElementById("reqt").value);
  if (document.getElementById("reqt").value == "tabg") {
    //document.getElementById("tabg").style.display = "block";
		document.getElementById("tabg").className = "form-group d-block d-inline";
    for(let i=1; i<=imax; i++) {
			document.getElementById("req"+i).className = "form-group d-none";
		}
  }else{
		document.getElementById("tabg").className = "form-group d-none";
		for(let i=1; i<=imax; i++) {
			if (document.getElementById("reqt").value == "req"+i) {
				//document.getElementById("req"+i).style.display = "block";
				document.getElementById("req"+i).className = "form-group d-block d-inline";
			}else{
				document.getElementById("req"+i).className = "form-group d-none";
			}
		}
	}
}
