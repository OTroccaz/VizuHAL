<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Détails techniques de chaque extraction - Technical details of each extraction
 */
 
//Détails techniques
echo '<a id="DT"></a>';

//Requête 1
echo '<div id="DTreq1" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion1"><div class="card mb-0"><div class="card-header" id="heading1"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion1"><div class="card-body">';
echo '
<span class="font-weight-bold">Pour les utilisateurs hors Rennes 1</span> : pour exploiter cette requête, il faut au préalable compléter la liste des codes collections des secteurs ou pôles et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES.php. En l\'absence de secteurs ou pôles, il suffit de reporter le code collection (ex : UNIV-RENNES) comme valeur des champs « secteurs » ou « pôles » du tableau PHP.<br>
<br>
# dépôts HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions 2017</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions 2017 sans texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions 2017 avec texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication (= colonne « <span class="font-weight-bold">Productions 2017 sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=-submitType_s:file</a><br>
<br>
# manuscrits et lien open access HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions 2017 avec texte intégral déposé dans HAL ou librement accessible hors HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<span class="font-weight-bold">Notes :</span><br>
<ul>
<li>Les données obtenues pour les secteurs ou pôles ne sont pas la somme des données collections : certains dépôts sont en effet des co-publications et peuvent apparaître dans plusieurs collections à la fois au sein d\'un même secteur ou pôle. En les additionnant, on fausserait les résultats.</li>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div></div></div></div>';

//Requête 24 (>1A)
echo '<div id="DTreq24" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion24"><div class="card mb-0"><div class="card-header" id="heading24"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse24" aria-expanded="true" aria-controls="collapse24"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse24" class="collapse" aria-labelledby="heading24" data-parent="#accordion24"><div class="card-body">';
echo '
<span class="font-weight-bold">Pour les utilisateurs hors Rennes 1</span> : pour exploiter cette requête, il faut au préalable compléter la liste des codes collections des secteurs ou pôles et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES.php. En l\'absence de secteurs ou pôles, il suffit de reporter le code collection (ex : UNIV-RENNES) comme valeur des champs « secteurs » ou « pôles » du tableau PHP.<br>
<br>
# dépôts HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions 2017</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=docType_s:ART</a><br>
<br>
# notices HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions 2017 sans texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111&fq=docType_s:ART</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions 2017 avec texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111&fq=docType_s:ART</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication (= colonne « <span class="font-weight-bold">Productions 2017 sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=docType_s:ART&fq=-submitType_s:file</a><br>
<br>
# manuscrits et lien open access HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions 2017 avec texte intégral déposé dans HAL ou librement accessible hors HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111&fq=docType_s:ART</a><br>
<br>
<span class="font-weight-bold">Notes :</span><br>
<ul>
<li>Les données obtenues pour les secteurs ou pôles ne sont pas la somme des données collections : certains dépôts sont en effet des co-publications et peuvent apparaître dans plusieurs collections à la fois au sein d\'un même secteur ou pôle. En les additionnant, on fausserait les résultats.</li>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div></div></div></div>';

//Requête 2
echo '<div id="DTreq2" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion2"><div class="card mb-0"><div class="card-header" id="heading2"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion2"><div class="card-body">';
echo '
<span class="font-weight-bold">Pour les utilisateurs hors Rennes 1</span> : pour exploiter la requête portail, il faut au préalable compléter la liste des codes collections des secteurs ou pôles et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES.php. En l\'absence de secteurs ou pôles, il suffit de reporter le code collection (ex : UNIV-RENNES) comme valeur des champs « secteurs » ou « pôles » du tableau PHP.<br>
<br>
# notices et texte intégral HAL-UR1 (toutes les années de publication) :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*:*&wt=xml&rows=0&facet=true&facet.pivot=producedDateY_i,submitType_s">https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*:*&wt=xml&rows=0&facet=true&facet.pivot=producedDateY_i,submitType_s</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions avec texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111</a><br> 
<br>
# notices HAL-UR1 (= colonne « <span class="font-weight-bold">Productions sans texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication  (= colonne « <span class="font-weight-bold">Productions sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=-submitType_s:file</a><br>
<br>
<span class="font-weight-bold">Notes :</span><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div></div></div></div>';

//Requête 25 (>2A)
echo '<div id="DTreq25" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion2"><div class="card mb-0"><div class="card-header" id="heading25"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion2"><div class="card-body">';
echo '
<span class="font-weight-bold">Pour les utilisateurs hors Rennes 1</span> : pour exploiter la requête portail, il faut au préalable compléter la liste des codes collections des secteurs ou pôles et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES.php. En l\'absence de secteurs ou pôles, il suffit de reporter le code collection (ex : UNIV-RENNES) comme valeur des champs « secteurs » ou « pôles » du tableau PHP.<br>
<br>
# notices et texte intégral HAL-UR1 (toutes les années de publication) :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*:*&wt=xml&fq=docType_s:ART&rows=0&facet=true&facet.pivot=producedDateY_i,submitType_s">https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*:*&wt=xml&fq=docType_s:ART&rows=0&facet=true&facet.pivot=producedDateY_i,submitType_s</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Productions avec texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2022&fq=submitType_s:file&fq=docType_s:ART&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2022&fq=submitType_s:file&fq=docType_s:ART&fq=-status_i=111</a><br> 
<br>
# notices HAL-UR1 (= colonne « <span class="font-weight-bold">Productions sans texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2022&fq=submitType_s:notice&fq=docType_s:ART&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2022&fq=submitType_s:notice&fq=docType_s:ART&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication  (= colonne « <span class="font-weight-bold">Productions sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2022&fq=docType_s:ART&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2022&fq=docType_s:ART&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<span class="font-weight-bold">Notes :</span><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div></div></div></div>';

//Requête 3
echo '<div id="DTreq3" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion3"><div class="card mb-0"><div class="card-header" id="heading3"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse3" aria-expanded="true" aria-controls="collapse3"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion3"><div class="card-body">';
echo '
Liste des portails : <a target="_blank" href="https://api.archives-ouvertes.fr/ref/instance/">https://api.archives-ouvertes.fr/ref/instance/</a><br> (un filtre interne au programme est appliqué pour n\'extraire que les portails université : « université » doit figurer dans le champ « name »).<br>
<br>
# articles HAL-UR1 par année de publication (= colonne « <span class="font-weight-bold">Articles</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:ART&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:ART&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 sans texte intégral par année de publication (= colonne « <span class="font-weight-bold">Articles 2017 sans texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 avec texte intégral par année de publication (= colonne « <span class="font-weight-bold">Articles 2017 avec texte intégral déposé dans HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:file&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=-submitType_s:file</a><br>
<br>
# articles HAL-UR1 avec texte intégral ou texte intégral accessible hors HAL par année de publication (= colonne « <span class="font-weight-bold">Articles 2017 avec texte intégral déposé dans HAL ou librement accessible hors HAL</span> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<span class="font-weight-bold">Notes :</span><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div></div></div></div>';

//Requête 4
echo '<div id="DTreq4" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion4"><div class="card mb-0"><div class="card-header" id="heading4"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse4" aria-expanded="true" aria-controls="collapse4"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion4"><div class="card-body">';
echo '
Il est désormais recommandé d\'utiliser les dashboards <a target="_blank" href="https://halstats.archives-ouvertes.fr/app/kibana#/home">Kibana</a> pour ce type de requête ESGBU.<br>
<br>
<span class="font-weight-bold">Stocks :</span><br>
AO1 = nombre de notices au 31/12/XXXX (remplacer par année renseignée par l\'utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:%5B1600-01-01-%20TO%202017-12-31/HOUR%5D">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]</a><br>
AO2 = nombre de fichiers au 31/12/XXXX (remplacer par année renseignée par l\'utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:%5B1600-01-01-%20TO%202017-12-31/HOUR%5D">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]</a><br>
<br>
<span class="font-weight-bold">Flux :</span><br>
AO3 = nombre de notices ajoutées en XXXX (remplacer par année renseignée par l\'utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:%5B2017-01-01-%20TO%202017-12-31/HOUR%5D">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]</a><br>
AO4 = nombre de fichiers ajoutés en XXXX (remplacer par année renseignée par l\'utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:%5B2017-01-01-%20TO%202017-12-31/HOUR%5D">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]</a><br>
<br>
<span class="font-weight-bold">Note :</span> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 5
echo '<div id="DTreq5" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion5"><div class="card mb-0"><div class="card-header" id="heading5"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse5" aria-expanded="true" aria-controls="collapse5"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion5"><div class="card-body">';
echo '
Ce chiffre est calculé à partir de la métadonnée « éditeur » (journalPublisher_s), présente dans la majorité des dépôts HAL.<br>
<br>
Requête API :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes/?fq=producedDateY_i:2024&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:ART&fl=label_s,doiId_s,journalPublisher_s&rows=10000">https://api.archives-ouvertes.fr/search/univ-rennes/?fq=producedDateY_i:2024&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:ART&fl=label_s,doiId_s,journalPublisher_s&rows=10000</a><br>
<br>
La ligne "Publications sans indication d\'éditeur" indique les dépôts où la métadonnée éditeur (journalPublisher_s) est manquante, dans le champ "revue". La revue n\'est pas valide (statut INCOMING) dans le référentiel des revues. Il est possible de corriger ce problème dans l\'application CrossHAL, avec la fonctionnalité "Compléter et corriger les métadonnées HAL" : CrossHAL repère et remplace les formes INCOMING des revues par les formes VALID.<br>
<br>
<span class="font-weight-bold">Note :</span> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 6
echo '<div id="DTreq6" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion6"><div class="card mb-0"><div class="card-header" id="heading6"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse6" aria-expanded="true" aria-controls="collapse6"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion6"><div class="card-body">';
echo '
Ce chiffre n\'est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n\'est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d\'une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l\'appellation « Hors regroupement éditorial ».<br>
<br>
Export CSV non disponible car la fonction retourne un tableau avec un comptage global et non une itération avec test sur chaque notice.<br>
<br>
Requêtes API :<br>
Communications 2017 (exemple pour préfixe 10.1016) : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:COMM">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:COMM</a><br>
La ligne "Hors regroupement éditorial" est calculée en retranchant le nombre total d\'articles recensés chez les éditeurs principaux (liste abrégée) du nombre total d\'articles du portail pour 2017 : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:COMM&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:COMM&fq=-status_i=111</a><br>
<br>
<span class="font-weight-bold">Note :</span> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 7
echo '<div id="DTreq7" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion7"><div class="card mb-0"><div class="card-header" id="heading7"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse7" aria-expanded="true" aria-controls="collapse7"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion7"><div class="card-body">';
echo '
Requête API (on additionne les valeurs des balises « count » du 1er niveau) :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=docType_s:ART&fq=producedDateY_i:2017&facet.limit=10000">https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=docType_s:ART&fq=producedDateY_i:2017&facet.limit=10000</a><br>
La requête n\'est pas basée sur l\'ISSN car certaines revues du référentiel AuréHAL n\'ont pas d\'ISSN. C\'est donc le titre de la revue (journalTitle_s) qui est pris en compte.<br>
<br>
<span class="font-weight-bold">Note :</span> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 8
echo '<div id="DTreq8" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion8"><div class="card mb-0"><div class="card-header" id="heading8"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse8" aria-expanded="true" aria-controls="collapse8"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion8"><div class="card-body">';
echo '
';
echo '<br></div></div></div></div></div>';

//Requête 9
echo '<div id="DTreq9" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion9"><div class="card mb-0"><div class="card-header" id="heading9"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse9" aria-expanded="true" aria-controls="collapse9"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion9"><div class="card-body">';
echo '
';
echo '<br></div></div></div></div></div>';

//Requête 10
echo '<div id="DTreq10" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion10"><div class="card mb-0"><div class="card-header" id="heading10"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse10" aria-expanded="true" aria-controls="collapse10"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordion10"><div class="card-body">';
echo '
Ce chiffre est calculé à partir de la métadonnée « éditeur » (journalPublisher_s), présente dans la majorité des dépôts HAL.<br>
<br>
Requête API :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2023&fq=submitType_s:notice&fq=docType_s:ART&fq=-status_i=111&fl=label_s,doiId_s,journalPublisher_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2023&fq=submitType_s:notice&fq=docType_s:ART&fq=-status_i=111&fl=label_s,doiId_s,journalPublisher_s&rows=10000</a><br>
<br>
La ligne "Publications sans indication d\'éditeur" indique les dépôts où la métadonnée éditeur (journalPublisher_s) est manquante, dans le champ "revue". La revue n\'est pas valide (statut INCOMING) dans le référentiel des revues. Il est possible de corriger ce problème dans l\'application CrossHAL, avec la fonctionnalité "Compléter et corriger les métadonnées HAL" : CrossHAL repère et remplace les formes INCOMING des revues par les formes VALID.<br>
<br>
<span class="font-weight-bold">Note :</span> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 11
echo '<div id="DTreq11" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion11"><div class="card mb-0"><div class="card-header" id="heading11"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse11" aria-expanded="true" aria-controls="collapse11"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion11"><div class="card-body">';
echo '
Ce chiffre est calculé à partir de la métadonnée « éditeur » (journalPublisher_s), présente dans la majorité des dépôts HAL.<br>
<br>
Requête API :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2023&fq=submitType_s:file&fq=-submitType_s:annex&fq=docType_s:ART&fq=-status_i=111&fl=label_s,doiId_s,journalPublisher_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2023&fq=submitType_s:file&fq=-submitType_s:annex&fq=docType_s:ART&fq=-status_i=111&fl=label_s,doiId_s,journalPublisher_s&rows=10000</a><br>
<br>
La ligne "Publications sans indication d\'éditeur" indique les dépôts où la métadonnée éditeur (journalPublisher_s) est manquante, dans le champ "revue". La revue n\'est pas valide (statut INCOMING) dans le référentiel des revues. Il est possible de corriger ce problème dans l\'application CrossHAL, avec la fonctionnalité "Compléter et corriger les métadonnées HAL" : CrossHAL repère et remplace les formes INCOMING des revues par les formes VALID.<br>
<br>
<span class="font-weight-bold">Note :</span> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 12
echo '<div id="DTreq12" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion12"><div class="card mb-0"><div class="card-header" id="heading12"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse12" aria-expanded="true" aria-controls="collapse12"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion12"><div class="card-body">';
echo '
Ce chiffre est calculé à partir de la métadonnée « éditeur » (journalPublisher_s), présente dans la majorité des dépôts HAL.<br>
<br>
Requête API :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=docType_s:ART&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111&fl=label_s,doiId_s,journalPublisher_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=docType_s:ART&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111&fl=label_s,doiId_s,journalPublisher_s&rows=10000</a><br>
<br>
La ligne "Publications sans indication d\'éditeur" indique les dépôts où la métadonnée éditeur (journalPublisher_s) est manquante, dans le champ "revue". La revue n\'est pas valide (statut INCOMING) dans le référentiel des revues. Il est possible de corriger ce problème dans l\'application CrossHAL, avec la fonctionnalité "Compléter et corriger les métadonnées HAL" : CrossHAL repère et remplace les formes INCOMING des revues par les formes VALID.<br>
<br>
<span class="font-weight-bold">Note :</span> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 13
echo '<div id="DTreq13" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion13"><div class="card mb-0"><div class="card-header" id="heading13"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse13" aria-expanded="true" aria-controls="collapse13"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion13"><div class="card-body">';
echo '
Requêtes API :<br>
Nombre de notices sans texte intégral :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:notice&fq=-status_i=111</a><br>
Nombre de notices avec texte intégral :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:file&fq=-status_i=111</a><br>
Nombre de notices avec texte intégral OU lien externe :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
Nombre de notices sans texte intégral déposé dans HAL + lien externe vers PDF en open access :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=-submitType_s:file">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=-submitType_s:file</a><br>
<br>
<span class="font-weight-bold">Notes :</span><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c\'est-à-dire portant la mention d\'un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s\'écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div></div></div></div>';

//Requête 14
echo '<div id="DTreq14" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion14"><div class="card mb-0"><div class="card-header" id="heading14"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse14" aria-expanded="true" aria-controls="collapse14"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordion14"><div class="card-body">';
echo '
Nombre de références HAL dans la collection LTSI pour 2019 ayant un projet ANR (incluant le champ « financement ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl=anrProjectId_i,anrProjectAcronym_s,funding_s,anrProjectId_i,anrProjectReference_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl=anrProjectId_i,anrProjectAcronym_s,funding_s,anrProjectId_i,anrProjectReference_s&rows=10000</a><br>
';
echo '<br></div></div></div></div></div>';

//Requête 15
echo '<div id="DTreq15" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion15"><div class="card mb-0"><div class="card-header" id="heading15"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse15" aria-expanded="true" aria-controls="collapse15"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordion15"><div class="card-body">';
echo '
Nombre de références HAL dans la collection LTSI pour 2019 ayant un projet européen (incluant le champ « financement ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl=europeanProjectId_i,europeanProjectAcronym_s,funding_s,europeanProjectId_i,europeanProjectReference_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl=europeanProjectId_i,europeanProjectAcronym_s,funding_s,europeanProjectId_i,europeanProjectReference_s&rows=10000</a><br>
<br>
Les lignes sans acronyme et/ou référence de projets ne sont pas des formes valides du référentiel (INCOMING, créées par le déposant). Elles sont néanmoins reportées dans les autres lignes du tableau.<br>
';
echo '<br></div></div></div></div></div>';

//Requête 16
echo '<div id="DTreq16" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion16"><div class="card mb-0"><div class="card-header" id="heading16"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse16" aria-expanded="true" aria-controls="collapse16"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion16"><div class="card-body">';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/UNIV-RENNES1/?fq=submittedDateY_i:2019&fl=contributorFullName_s,submittedDate_s,submitType_s,halId_s&rows=10000&sort=contributorFullName_s%20desc">https://api.archives-ouvertes.fr/search/UNIV-RENNES1/?fq=submittedDateY_i:2019&fl=contributorFullName_s,submittedDate_s,submitType_s,halId_s&rows=10000&sort=contributorFullName_s%20desc</a><br>
<br>
Champs exploités :<br>
<ul>
<li>contributorFullName_s</li>
<li>submittedDate_s pour la date de dépôt (année)</li>
<li>submitType_s pour le type de dépôt (notice, file)</li>
<li>sid_i : identifiant du portail de dépôt (avec <a target="_blank" href="https://api.archives-ouvertes.fr/search/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.field=sid_i">une liste</a>, mais non documentée selon ticket <a target="_blank" href="https://support.ccsd.cnrs.fr/SelfService/Display.html?id=87256">HAL#87256</a> : on n\'en a traduit que quelques-uns)</li>
</ul>
';
echo '<br></div></div></div></div></div>';

//Requête 17
echo '<div id="DTreq17" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion17"><div class="card mb-0"><div class="card-header" id="heading17"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse17" aria-expanded="true" aria-controls="collapse17"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordion17"><div class="card-body">';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
Les 3 niveaux (collCategory_s):<br>
Laboratoires = uniquement les tampons LABO et THEME<br>
Etablissements = uniquement les tampons INSTITUTION, UNIV et ECOLE<br>
Autres = uniquement les tampons AUTRE<br>
';
echo '<br></div></div></div></div></div>';

//Requête 18
echo '<div id="DTreq18" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion18"><div class="card mb-0"><div class="card-header" id="heading18"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse18" aria-expanded="true" aria-controls="collapse18"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse18" class="collapse" aria-labelledby="heading18" data-parent="#accordion18"><div class="card-body">';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Laboratoires = uniquement les tampons LABO et THEME<br>
';
echo '<br></div></div></div></div></div>';

//Requête 19
echo '<div id="DTreq19" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion19"><div class="card mb-0"><div class="card-header" id="heading19"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse19" aria-expanded="true" aria-controls="collapse19"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse19" class="collapse" aria-labelledby="heading19" data-parent="#accordion19"><div class="card-body">';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Etablissements = uniquement les tampons INSTITUTION, UNIV et ECOLE<br>
';
echo '<br></div></div></div></div></div>';

//Requête 20
echo '<div id="DTreq20" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion20"><div class="card mb-0"><div class="card-header" id="heading20"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse20" aria-expanded="true" aria-controls="collapse20"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse20" class="collapse" aria-labelledby="heading20" data-parent="#accordion20"><div class="card-body">';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Autres = uniquement les tampons AUTRE<br>
';
echo '<br></div></div></div></div></div>';

//Requête 21
echo '<div id="DTreq21" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion21"><div class="card mb-0"><div class="card-header" id="heading21"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse21" aria-expanded="true" aria-controls="collapse21"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse21" class="collapse" aria-labelledby="heading21" data-parent="#accordion21"><div class="card-body">';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Sont exclus des résultats les territoires français d\'outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<span class="font-weight-bold">Note :</span> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 22
echo '<div id="DTreq22" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion22"><div class="card mb-0"><div class="card-header" id="heading22"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse22" aria-expanded="true" aria-controls="collapse22"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse22" class="collapse" aria-labelledby="heading22" data-parent="#accordion22"><div class="card-body">';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Sont exclus des résultats les territoires français d\'outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<span class="font-weight-bold">Note :</span> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
';
echo '<br></div></div></div></div></div>';

//Requête 23
echo '<div id="DTreq23" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion23"><div class="card mb-0"><div class="card-header" id="heading23"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse23" aria-expanded="true" aria-controls="collapse23"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse23" class="collapse" aria-labelledby="heading23" data-parent="#accordion23"><div class="card-body">';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Données utilisées pour le label « institution » :<br>
structType_s = "institution", "regroupinstitution", "regrouplaboratory", "department"<br>
Sont exclus des résultats les territoires français d\'outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<span class="font-weight-bold">Note :</span> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
';
echo 'Vous pouvez générer différents types de cartes en exportant ces données dans l\'outil open source <a target="_blank" href="https://www.sciencespo.fr/cartographie/khartis/">Khartis</a> (voir <a target="_blank" href="https://www.sciencespo.fr/cartographie/khartis/docs/premiers-pas-avec-Khartis-(1)/">documentation</a>)';
echo '<br></div></div></div></div></div>';

//Requête 26
echo '<div id="DTreq26" class="col-12 float-left bg-gray border border-gray-700 rounded mb-1">';
echo '<div class="accordion d-inline" id="accordion26"><div class="card mb-0"><div class="card-header" id="heading26"><a class="custom-accordion-title d-block" data-toggle="collapse" href="#collapse26" aria-expanded="true" aria-controls="collapse26"><span class="font-weight-bold">Consultez la documentation technique&nbsp;</span><span style="color: #aaaaaa;"><em>(Cliquez)</em></span></a></div>';
echo '<div id="collapse26" class="collapse" aria-labelledby="heading26" data-parent="#accordion26"><div class="card-body">';
echo 'A détailer ...';
echo '<br></div></div></div></div></div>';

if (!isset($_POST["valider"]) && !isset($_GET["reqt"])) {
	echo '<script>
		for(let i=1; i<=imax; i++) {
			document.getElementById("DTreq"+i).className = "form-group d-none";
		}
	</script>';
}else{
	for ($i=1; $i<=26; $i++) { 
		if ($reqt == "req".$i) {
			echo '<script>document.getElementById("DTreq'.$i.'").className = "col-12 float-left bg-gray border border-gray-700 rounded mb-1";</script>';
		}else{
			echo '<script>document.getElementById("DTreq'.$i.'").className = "form-group d-none";</script>';
		}
	}
}
echo '<br>';
?>