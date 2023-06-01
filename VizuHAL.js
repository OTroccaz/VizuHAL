/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Scripts
 */
 
document.getElementById("tabg").className = "form-group d-none";

var imax = 25;//Nombre total de requêtes

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
