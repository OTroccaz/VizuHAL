<?php
//Détails techniques
echo '<a name="DT"></a>';

//Requête 1
echo '<div id="DTreq1" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<strong>Pour les utilisateurs hors Rennes 1</strong> : pour exploiter cette requête, il faut au préalable compléter la liste des codes collections des secteurs et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES1.php. En l’absence de secteurs, il suffit de reporter le code collection (ex : UNIV-RENNES1) comme valeur des champs « secteurs » du tableau PHP.<br>
<br>
# dépôts HAL-UR1 par année de publication (= colonne « <strong>Productions 2017</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 par année de publication (= colonne « <strong>Productions 2017 sans texte intégral déposé dans HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <strong>Productions 2017 avec texte intégral déposé dans HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication (= colonne « <strong>Productions 2017 sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=-submitType_s:file</a><br>
<br>
# manuscrits et lien open access HAL-UR1 par année de publication (= colonne « <strong>Productions 2017 avec texte intégral déposé dans HAL ou librement accessible hors HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<strong>Notes :</strong><br>
<ul>
<li>Les données obtenues pour les secteurs ne sont pas la somme des données collections : certains dépôts sont en effet des co-publications et peuvent apparaître dans plusieurs collections à la fois au sein d’un même secteur. En les additionnant, on fausserait les résultats.</li>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div>';

//Requête 24 (>1A)
echo '<div id="DTreq24" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<strong>Pour les utilisateurs hors Rennes 1</strong> : pour exploiter cette requête, il faut au préalable compléter la liste des codes collections des secteurs et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES1.php. En l’absence de secteurs, il suffit de reporter le code collection (ex : UNIV-RENNES1) comme valeur des champs « secteurs » du tableau PHP.<br>
<br>
# dépôts HAL-UR1 par année de publication (= colonne « <strong>Productions 2017</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=docType_s:ART</a><br>
<br>
# notices HAL-UR1 par année de publication (= colonne « <strong>Productions 2017 sans texte intégral déposé dans HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111&fq=docType_s:ART</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <strong>Productions 2017 avec texte intégral déposé dans HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111&fq=docType_s:ART</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication (= colonne « <strong>Productions 2017 sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=docType_s:ART&fq=-submitType_s:file</a><br>
<br>
# manuscrits et lien open access HAL-UR1 par année de publication (= colonne « <strong>Productions 2017 avec texte intégral déposé dans HAL ou librement accessible hors HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111&fq=docType_s:ART</a><br>
<br>
<strong>Notes :</strong><br>
<ul>
<li>Les données obtenues pour les secteurs ne sont pas la somme des données collections : certains dépôts sont en effet des co-publications et peuvent apparaître dans plusieurs collections à la fois au sein d’un même secteur. En les additionnant, on fausserait les résultats.</li>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via <a target="_blank" href="https://unpaywall.org/">Unpaywall</a>), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div>';

//Requête 2
echo '<div id="DTreq2" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<strong>Pour les utilisateurs hors Rennes 1</strong> : pour exploiter la requête portail, il faut au préalable compléter la liste des codes collections des secteurs et unités dans un tableau PortHAL-UNIV-XXXXX.php, sur le modèle du fichier PortHAL-RENNES1.php. En l’absence de secteurs, il suffit de reporter le code collection (ex : UNIV-RENNES1) comme valeur des champs « secteurs «  du tableau PHP.<br>
<br>
# notices et texte intégral HAL-UR1 (toutes les années de publication) :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*:*&wt=xml&rows=0&facet=true&facet.pivot=producedDateY_i,submitType_s">https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*:*&wt=xml&rows=0&facet=true&facet.pivot=producedDateY_i,submitType_s</a><br>
<br>
# manuscrits HAL-UR1 par année de publication (= colonne « <strong>Productions avec texte intégral déposé dans HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:file&fq=-status_i=111</a><br> 
<br>
# notices HAL-UR1 (= colonne « <strong>Productions sans texte intégral déposé dans HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# notices HAL-UR1 avec lien open access par année de publication  (= colonne « <strong>Productions sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=-submitType_s:file</a><br>
<br>
<strong>Notes :</strong><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div>';

//Requête 3
echo '<div id="DTreq3" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Liste des portails : <a target="_blank" href="https://api.archives-ouvertes.fr/ref/instance/?wt=xml">https://api.archives-ouvertes.fr/ref/instance/?wt=xml</a><br> (un filtre interne au programme est appliqué pour n’extraire que les portails université : « université » doit figurer dans le champ « name »).<br>
<br>
# articles HAL-UR1 par année de publication (= colonne « <strong>Articles</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice OR file)&fq=docType_s:ART&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice OR file)&fq=docType_s:ART&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 sans texte intégral par année de publication (= colonne « <strong>Articles 2017 sans texte intégral déposé dans HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 avec texte intégral par année de publication (= colonne « <strong>Articles 2017 avec texte intégral déposé dans HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=submitType_s:file&fq=-status_i=111</a><br>
<br>
# articles HAL-UR1 sans texte intégral déposé dans HAL mais avec texte intégral librement accessible hors HAL :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=linkExtId_s:*&fq=-linkExtId_s:istex&fq=-status_i=111&fq=-submitType_s:file</a><br>
<br>
# articles HAL-UR1 avec texte intégral ou texte intégral accessible hors HAL par année de publication (= colonne « <strong>Articles 2017 avec texte intégral déposé dans HAL ou librement accessible hors HAL</strong> ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=docType_s:ART&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<strong>Notes :</strong><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div>';

//Requête 4
echo '<div id="DTreq4" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<strong>Stocks :</strong><br>
AO1 = nombre de notices au 31/12/XXXX (remplacer par année renseignée par l’utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]</a><br>
AO2 = nombre de fichiers au 31/12/XXXX (remplacer par année renseignée par l’utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[1600-01-01-%20TO%202017-12-31/HOUR]</a><br>
<br>
<strong>Flux :</strong><br>
AO3 = nombre de notices ajoutées en XXXX (remplacer par année renseignée par l’utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:notice&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]</a><br>
AO4 = nombre de fichiers ajoutés en XXXX (remplacer par année renseignée par l’utilisateur)<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=submitType_s:file&fq=-status_i=111&fq=submittedDate_s:[2017-01-01-%20TO%202017-12-31/HOUR]</a><br>
<br>
<strong>Note :</strong> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div>';

//Requête 5
echo '<div id="DTreq5" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ». Une exception est faite pour les éditeurs Dalloz et Lextenso qui n’ont pas de DOI (interrogation du champ « journalPublisher_s »).<br>
<br>
Liste restreinte des préfixes de DOI : <a target="_blank" href="https://github.com/OTroccaz/VizuHAL/blob/master/Prefixe_DOI.php">Prefixe_DOI.php</a><br>
<br>
Requêtes API :<br>
Articles 2017 (exemple pour préfixe 10.1016) : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:ART</a><br>
La ligne "Hors regroupement éditorial" est calculée en retranchant le nombre total d\'articles recensés chez les éditeurs principaux (liste abrégée) du nombre total d\'articles du portail pour 2017 : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:ART&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:ART&fq=-status_i=111</a><br>
Lextenso : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=journalPublisher_t:lextenso&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=journalPublisher_t:lextenso&fq=docType_s:ART</a><br>
Dalloz : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=journalPublisher_t:dalloz&fq=docType_s:ART">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=journalPublisher_t:dalloz&fq=docType_s:ART</a><br>
<br>
<strong>Note :</strong> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div>';

//Requête 6
echo '<div id="DTreq6" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ».<br>
<br>
Requêtes API :<br>
Communications 2017 (exemple pour préfixe 10.1016) : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:COMM">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=-submitType_s:annex&fq=-status_i=111&fq=doiId_s:10.1016*&fq=docType_s:COMM</a><br>
La ligne "Hors regroupement éditorial" est calculée en retranchant le nombre total d\'articles recensés chez les éditeurs principaux (liste abrégée) du nombre total d\'articles du portail pour 2017 : <a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:COMM&fq=-status_i=111">https://api.archives-ouvertes.fr/search/univ-rennes1/?fq=producedDateY_i:2017&fq=submitType_s:(notice%20OR%20file)&fq=docType_s:COMM&fq=-status_i=111</a><br>
<br>
<strong>Note :</strong> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div>';

//Requête 7
echo '<div id="DTreq7" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Requête API (on additionne les valeurs des balises « count » du 1er niveau) :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=docType_s:ART&fq=producedDateY_i:2017&facet.limit=10000">https://api.archives-ouvertes.fr/search/univ-rennes1/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.pivot=journalTitle_s,journalPublisher_s,journalValid_s&fq=-status_i=111&fq=docType_s:ART&fq=producedDateY_i:2017&facet.limit=10000</a><br>
La requête n’est pas basée sur l’ISSN car certaines revues du référentiel AuréHAL n’ont pas d’ISSN. C’est donc le titre de la revue (journalTitle_s) qui est pris en compte.<br>
<br>
<strong>Note :</strong> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div>';

//Requête 8
echo '<div id="DTreq8" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
';
echo '<br></div></div>';

//Requête 9
echo '<div id="DTreq9" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
';
echo '<br></div></div>';

//Requête 10
echo '<div id="DTreq10" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ». Une exception est faite pour les éditeurs Dalloz et Lextenso qui n’ont pas de DOI (interrogation du champ « journalPublisher_s »).<br>
<br>
Liste restreinte des préfixes de DOI : <a target="_blank" href="https://github.com/OTroccaz/VizuHAL/blob/master/Prefixe_DOI.php">Prefixe_DOI.php</a><br>
<br>
Requête API :<br>
Nombre de notices sans texte intégral :<br>
 <a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:notice&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:notice&fq=-status_i=111</a><br>
<br>
<strong>Note :</strong> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div>';

//Requête 11
echo '<div id="DTreq11" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ». Une exception est faite pour les éditeurs Dalloz et Lextenso qui n’ont pas de DOI (interrogation du champ « journalPublisher_s »).<br>
Liste restreinte des préfixes de DOI : <a target="_blank" href="https://github.com/OTroccaz/VizuHAL/blob/master/Prefixe_DOI.php">Prefixe_DOI.php</a><br>
<br>
Requête API :<br>
Nombre de notices avec texte intégral : <br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:file&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=submitType_s:file&fq=-status_i=111</a><br>
<br>
<strong>Note :</strong> Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).<br>
';
echo '<br></div></div>';

//Requête 12
echo '<div id="DTreq12" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Ce chiffre n’est pas calculé à partir de la métadonnée « éditeur » (journalPublisher_s) car elle n’est pas présente dans tous les dépôts HAL. La requête est basée sur le préfixe du DOI des principaux éditeurs, extrait d’une version interne abrégée de la <a target="_blank" href="https://www.crossref.org/06members/50go-live.html">liste à jour des préfixes DOI de CrossRef</a>. Les éditeurs non répertoriées dans la liste interne sont rassemblés sous l’appellation « Hors regroupement éditorial ». Une exception est faite pour les éditeurs Dalloz et Lextenso qui n’ont pas de DOI (interrogation du champ « journalPublisher_s »).<br>
Liste restreinte des préfixes de DOI : <a target="_blank" href="https://github.com/OTroccaz/VizuHAL/blob/master/Prefixe_DOI.php">Prefixe_DOI.php</a><br>
<br>
Requête API :<br>
Nombre de notices avec texte intégral OU lien externe : <br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fq=(submitType_s:file%20OR%20linkExtId_s:*)&fq=-linkExtId_s:istex&fq=-status_i=111</a><br>
<br>
<strong>Notes :</strong><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div>';

//Requête 13
echo '<div id="DTreq13" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
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
<strong>Notes :</strong><br>
<ul>
<li>Dans les requêtes API, il faut éliminer les dépôts ayant le statut 111, c’est-à-dire portant la mention d’un numéro de version (versions 2, 3 etc.). Voir ticket HAL #60428. Dans la requête API, cela peut s’écrire fq=-status_i=111 (avec signe - devant le champ « status_i »).</li>
<li>Dans les requêtes API portant sur le lien vers un PDF librement disponible hors de HAL (via Unpaywall), il faut exclure les liens ISTEX (uniquement accessibles aux membres ESR) : fq=-linkExtId_s:istex</li>
</ul>
';
echo '<br></div></div>';

//Requête 14
echo '<div id="DTreq14" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Nombre de références HAL dans la collection LTSI pour 2019 ayant un projet ANR (incluant le champ « financement ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl=anrProjectId_i,anrProjectAcronym_s,funding_s,anrProjectId_i,anrProjectReference_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl=anrProjectId_i,anrProjectAcronym_s,funding_s,anrProjectId_i,anrProjectReference_s&rows=10000</a><br>
';
echo '<br></div></div>';

//Requête 15
echo '<div id="DTreq15" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
Nombre de références HAL dans la collection LTSI pour 2019 ayant un projet européen (incluant le champ « financement ») :<br>
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl= europeanProjectId_i,europeanProjectAcronym_s,funding_s,europeanProjectId_i,europeanProjectReference_s &rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2019&fl= europeanProjectId_i,europeanProjectAcronym_s,funding_s,europeanProjectId_i,europeanProjectReference_s &rows=10000</a><br>
';
echo '<br></div></div>';

//Requête 16
echo '<div id="DTreq16" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/UNIV-RENNES1/?fq=producedDateY_i:2019&fl=contributorFullName_s,submittedDate_s,submitType_s,halId_s&rows=10000&sort=contributorFullName_s%20desc">https://api.archives-ouvertes.fr/search/UNIV-RENNES1/?fq=producedDateY_i:2019&fl=contributorFullName_s,submittedDate_s,submitType_s,halId_s&rows=10000&sort=contributorFullName_s%20desc</a><br>
<br>
Champs exploités :<br>
<ul>
<li>contributorFullName_s</li>
<li>submittedDate_s pour la date de dépôt (année)</li>
<li>submitType_s pour le type de dépôt (notice, file)</li>
<li>sid_i : identifiant du portail de dépôt (avec <a target="_blank" href="https://api.archives-ouvertes.fr/search/?q=*%3A*&rows=0&wt=xml&indent=true&facet=true&facet.field=sid_i">une liste</a>, mais non documentée selon ticket <a target="_blank" href="https://support.ccsd.cnrs.fr/SelfService/Display.html?id=87256">HAL#87256</a> : on n’en a traduit que quelques-uns)</li>
</ul>
';
echo '<br></div></div>';

//Requête 17
echo '<div id="DTreq17" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
Les 3 niveaux (collCategory_s):<br>
Laboratoires = uniquement les tampons LABO et THEME<br>
Etablissements = uniquement les tampons INSTITUTION, UNIV et ECOLE<br>
Autres = uniquement les tampons AUTRE<br>
';
echo '<br></div></div>';

//Requête 18
echo '<div id="DTreq18" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Laboratoires = uniquement les tampons LABO et THEME<br>
';
echo '<br></div></div>';

//Requête 19
echo '<div id="DTreq19" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Etablissements = uniquement les tampons INSTITUTION, UNIV et ECOLE<br>
';
echo '<br></div></div>';

//Requête 20
echo '<div id="DTreq20" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s">https://api.archives-ouvertes.fr/search/ECOBIO/?fq=producedDateY_i:2019&fl=collName_s,collCategory_s,collCode_s,halId_s</a><br>
collCategory_s / Autres = uniquement les tampons AUTRE<br>
';
echo '<br></div></div>';

//Requête 21
echo '<div id="DTreq21" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Liens XML/JSON : l’export des références en csv n’est malheureusement pas possible (même si théoriquement proposé par le CCSD).<br>
Sont exclus des résultats les territoires français d’outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<strong>Note :</strong> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
';
echo '<br></div></div>';

//Requête 22
echo '<div id="DTreq22" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Liens XML/JSON : l’export des références en csv n’est malheureusement pas possible (même si théoriquement proposé par le CCSD).<br>
Données utilisées pour le label « institution » :<br>
structType_s = "institution", "regroupinstitution", "regrouplaboratory", "department"<br>
Sont exclus des résultats les territoires français d’outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<strong>Note :</strong> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
';
echo '<br></div></div>';
echo 'Vous pouvez générer différents types de cartes en exportant ces données dans l\'outil open source <a target="_blank" href="https://www.sciencespo.fr/cartographie/khartis/">Khartis</a> (voir <a target="_blank" href="https://www.sciencespo.fr/cartographie/khartis/docs/premiers-pas-avec-Khartis-(1)/">documentation</a>)';

//Requête 23
echo '<div id="DTreq23" style="width:100%;float: left;background-color:#f5f5f5;border:1px solid #dddddd;padding: 3px;border-radius: 3px;margin-bottom: 10px;">';
echo($cstDoc);
echo '<div class="panel" style="margin-bottom: 0px; border: 0px;"><br>';
echo '
<a target="_blank" href="https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000">https://api.archives-ouvertes.fr/search/LTSI/?fq=producedDateY_i:2018&fl=docType_s,structName_s,structType_s,halId_s,structCountry_s&rows=10000</a><br> 
Liens XML/JSON : l’export des références en csv n’est malheureusement pas possible (même si théoriquement proposé par le CCSD).<br>
Sont exclus des résultats les territoires français d’outre-mer de la <a target="_blank" href="http://documentation.abes.fr/sudoc/formats/CodesPays.htm">liste ISO 3166</a> : "Martinique" MQ,"Guadeloupe" GP, etc.<br>
<br>
<strong>Note :</strong> ces résultats sont à relativiser car beaucoup de structures étrangères non valides du référentiel AuréHAL ont un code pays = France. Par ailleurs, les co-auteurs étrangers ne sont pas systématiquement affiliés dans HAL, voire ont une affiliation erronée (attribuée automatiquement par HAL).<br>
';
echo '<br></div></div>';

echo '<script type="text/javascript" language="Javascript">';
echo 'var acc = document.getElementsByClassName("accordeon");';
echo 'var i;';
echo 'for (i = 0; i < acc.length; i++) {';
echo '  acc[i].onclick = function() {';
echo '    this.classList.toggle("active");';
echo '    var panel = this.nextElementSibling;';
echo '    if (panel.style.maxHeight){';
echo '      panel.style.maxHeight = null;';
echo '    } else {';
echo '      panel.style.maxHeight = panel.scrollHeight + "px";';
echo '    }';
echo '  }';
echo '}';
echo '</script>';

if (!isset($_POST["valider"]) && !isset($_GET["reqt"])) {
	echo '<script type="text/javascript" language="Javascript">
		for(let i=1; i<=imax; i++) {
			document.getElementById("DTreq"+i).style.display = "none";
		}
	</script>';
}else{
	for ($i=1; $i<=24; $i++) { 
		if ($reqt == "req".$i) {
			echo '<script type="text/javascript" language="Javascript">document.getElementById("DTreq'.$i.'").style.display = "block";</script>';
		}else{
			echo '<script type="text/javascript" language="Javascript">document.getElementById("DTreq'.$i.'").style.display = "none";</script>';
		}
	}
}
echo '<br>';
?>