document.getElementById("tabg").style.display = "none";

var imax = 24;//Nombre total de requêtes

for(let i=1; i<=imax; i++) {
	document.getElementById("req"+i).style.display = "none";
}

function freqt() {
//alert(document.getElementById("reqt").value);
  if (document.getElementById("reqt").value == "tabg") {
    document.getElementById("tabg").style.display = "block";
    for(let i=1; i<=imax; i++) {
			document.getElementById("req"+i).style.display = "none";
		}
  }else{
		document.getElementById("tabg").style.display = "none";
		for(let i=1; i<=imax; i++) {
			if (document.getElementById("reqt").value == "req"+i) {
				document.getElementById("req"+i).style.display = "block";
			}else{
				document.getElementById("req"+i).style.display = "none";
			}
		}
	}
}
