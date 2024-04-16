<?php
/*
 * VizuHAL - Générez des stats HAL - Generate HAL stats
 *
 * Copyright (C) 2023 Olivier Troccaz (olivier.troccaz@cnrs.fr) and Laurent Jonchère (laurent.jonchere@univ-rennes.fr)
 * Released under the terms and conditions of the GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.txt)
 *
 * Préfixe DOI d'éditeurs - Publisher DOI prefix
 */
 
$Prefixe_DOI = array(
0 => array("editeur_ng"=>"Académie des sciences", "editeur"=>"Académie des sciences", "prefixe"=>"10.62686"),
1 => array("editeur_ng"=>"Association for Computing Machinery", "editeur"=>"Association for Computing Machinery", "prefixe"=>"10.1145"),
2 => array("editeur_ng"=>"American Chemical Society", "editeur"=>"American Chemical Society", "prefixe"=>"10.1021"),
3 => array("editeur_ng"=>"American Chemical Society", "editeur"=>"American Chemical Society", "prefixe"=>"10.26434"),
4 => array("editeur_ng"=>"American Chemical Society", "editeur"=>"American Chemical Society (ACS)", "prefixe"=>"10.29200"),
5 => array("editeur_ng"=>"American Chemical Society", "editeur"=>"American Chemical Society (C&EN)", "prefixe"=>"10.47287"),
6 => array("editeur_ng"=>"American Physical Society", "editeur"=>"American Physical Society", "prefixe"=>"10.1103"),
7 => array("editeur_ng"=>"American Physical Society", "editeur"=>"American Physical Society (APS)", "prefixe"=>"10.29172"),
8 => array("editeur_ng"=>"American Association for the Advancement of Science (AAAS)", "editeur"=>"American Association for the Advancement of Science (AAAS)", "prefixe"=>"10.1126"),
9 => array("editeur_ng"=>"American Association for the Advancement of Science (AAAS)", "editeur"=>"American Association for the Advancement of Science (AAAS)", "prefixe"=>"10.34133"),
10 => array("editeur_ng"=>"American Association for the Advancement of Science (AAAS)", "editeur"=>"American Association for the Advancement of Science (AAAS)", "prefixe"=>"10.1126"),
11 => array("editeur_ng"=>"American Association for the Advancement of Science (AAAS)", "editeur"=>"American Association for the Advancement of Science (AAAS)", "prefixe"=>"10.34133"),
12 => array("editeur_ng"=>"American Astronomical Society", "editeur"=>"American Astronomical Society", "prefixe"=>"10.3847"),
13 => array("editeur_ng"=>"American Geographical Society", "editeur"=>"American Geographical Society", "prefixe"=>"10.21690"),
14 => array("editeur_ng"=>"American Geophysical Union", "editeur"=>"American Geophysical Union", "prefixe"=>"10.1029"),
15 => array("editeur_ng"=>"American Geosciences Institute", "editeur"=>"American Geosciences Institute", "prefixe"=>"10.62322"),
16 => array("editeur_ng"=>"American Institute of Mathematical Sciences", "editeur"=>"American Institute of Mathematical Sciences", "prefixe"=>"10.3934"),
17 => array("editeur_ng"=>"American Mathematical Society", "editeur"=>"American Mathematical Society", "prefixe"=>"10.1090"),
18 => array("editeur_ng"=>"American Society for Biochemistry and Molecular Biology", "editeur"=>"American Society for Biochemistry and Molecular Biology", "prefixe"=>"10.1074"),
19 => array("editeur_ng"=>"American Society for Biochemistry and Molecular Biology", "editeur"=>"American Society for Biochemistry and Molecular Biology, Journal of Lipid Research", "prefixe"=>"10.1194"),
20 => array("editeur_ng"=>"American Society for Microbiology", "editeur"=>"American Society for Microbiology", "prefixe"=>"10.1128"),
21 => array("editeur_ng"=>"American Society of Hematology", "editeur"=>"American Society of Hematology", "prefixe"=>"10.1182"),
22 => array("editeur_ng"=>"American Society of Hematology", "editeur"=>"American Society of Hematology", "prefixe"=>"10.1182"),
23 => array("editeur_ng"=>"Beilstein-Institut", "editeur"=>"Beilstein-Institut", "prefixe"=>"10.3762"),
24 => array("editeur_ng"=>"Bentham Science", "editeur"=>"Bentham Science", "prefixe"=>"10.2174"),
25 => array("editeur_ng"=>"Biomed Central", "editeur"=>"Springer (Biomed Central Ltd.)", "prefixe"=>"10.1186"),
26 => array("editeur_ng"=>"BMJ", "editeur"=>"BMJ", "prefixe"=>"10.1136"),
27 => array("editeur_ng"=>"Cairn", "editeur"=>"CAIRN", "prefixe"=>"10.3917"),
28 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press", "prefixe"=>"10.1017"),
29 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press (Anthem Press)", "prefixe"=>"10.7135"),
30 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press (Australian Academic Press)", "prefixe"=>"10.1375"),
31 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press (CUP)", "prefixe"=>"10.5949"),
32 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press (Entomological Society of Canada)", "prefixe"=>"10.4039"),
33 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press (Materials Research Society)", "prefixe"=>"10.1557"),
34 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press (Mathematical Association of America)", "prefixe"=>"10.5948"),
35 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press (Nottingham University Press)", "prefixe"=>"10.7313"),
36 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press (Society for the Promotion of Roman Studies)", "prefixe"=>"10.3815"),
37 => array("editeur_ng"=>"Cambridge University Press", "editeur"=>"Cambridge University Press pre-prints", "prefixe"=>"10.33774"),
38 => array("editeur_ng"=>"CNAF", "editeur"=>"", "prefixe"=>"N/A"),
39 => array("editeur_ng"=>"CNRS Éditions", "editeur"=>"", "prefixe"=>"N/A"),
40 => array("editeur_ng"=>"Copernicus Publications", "editeur"=>"", "prefixe"=>"N/A"),
41 => array("editeur_ng"=>"Dalloz", "editeur"=>"", "prefixe"=>"N/A"),
42 => array("editeur_ng"=>"De Boeck", "editeur"=>"", "prefixe"=>"N/A"),
43 => array("editeur_ng"=>"De Gruyter", "editeur"=>"", "prefixe"=>"N/A"),
44 => array("editeur_ng"=>"Edilaix", "editeur"=>"", "prefixe"=>"N/A"),
45 => array("editeur_ng"=>"Editions Francis Lefebvre", "editeur"=>"", "prefixe"=>"N/A"),
46 => array("editeur_ng"=>"EDP Sciences", "editeur"=>"EDP Sciences", "prefixe"=>"10.1051"),
47 => array("editeur_ng"=>"EDP Sciences", "editeur"=>"EDP Sciences", "prefixe"=>"10.2515"),
48 => array("editeur_ng"=>"EDP Sciences", "editeur"=>"EDP Sciences", "prefixe"=>"10.2516"),
49 => array("editeur_ng"=>"EDP Sciences", "editeur"=>"EDP Sciences", "prefixe"=>"10.9742"),
50 => array("editeur_ng"=>"eLife ", "editeur"=>"eLife Sciences Publications, Ltd.", "prefixe"=>"10.7554"),
51 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier", "prefixe"=>"10.1016"),
52 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier (Society for Range Management)", "prefixe"=>"10.2111"),
53 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Academic Press", "prefixe"=>"10.1006"),
54 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Ambulatory Pediatric Associates", "prefixe"=>"10.1367"),
55 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - American Society for Experimental Neurotherapeutics", "prefixe"=>"10.1602"),
56 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - American Society for Investigative Pathology", "prefixe"=>"10.2353"),
57 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Biophysical Society", "prefixe"=>"10.1529"),
58 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Central Mining Institute", "prefixe"=>"10.7424"),
59 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - CIG Media Group LP", "prefixe"=>"10.3816"),
60 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Colegio Nacional de Opticos-Optometristas de Espana", "prefixe"=>"10.3921"),
61 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Ediciones Doyma", "prefixe"=>"10.1157"),
62 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Institution of Chemical Engineers", "prefixe"=>"10.1205"),
63 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - International Federation of Automatic Control (IFAC)", "prefixe"=>"10.3182"),
64 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Mayo Clinic Proceedings", "prefixe"=>"10.4065"),
65 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Medicine Publishing Company", "prefixe"=>"10.1383"),
66 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Mosby", "prefixe"=>"10.1067"),
67 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Urban & Fischer Verlag", "prefixe"=>"10.1078"),
68 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - WB Saunders", "prefixe"=>"10.1053"),
69 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier - Wilderness Medical Society", "prefixe"=>"10.1580"),
70 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier- Churchill Livingstone", "prefixe"=>"10.1054"),
71 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier- Hanley and Belfus Inc.", "prefixe"=>"10.1197"),
72 => array("editeur_ng"=>"Elsevier", "editeur"=>"Elsevier- Spektrum Akademischer Verlag", "prefixe"=>"10.1240"),
73 => array("editeur_ng"=>"Emerald", "editeur"=>"Emerald (MCB UP)", "prefixe"=>"10.1108"),
74 => array("editeur_ng"=>"Emerald", "editeur"=>"Emerald - Emerald Open Research", "prefixe"=>"10.35241"),
75 => array("editeur_ng"=>"Emerald", "editeur"=>"Emerald - Pier Professional", "prefixe"=>"10.5042"),
76 => array("editeur_ng"=>"Emerald", "editeur"=>"EmeraldTree Publishing", "prefixe"=>"10.36259"),
77 => array("editeur_ng"=>"Erudit", "editeur"=>"Consortium Erudit", "prefixe"=>"10.7202"),
78 => array("editeur_ng"=>"European Geosciences Union", "editeur"=>"", "prefixe"=>"N/A"),
79 => array("editeur_ng"=>"European Mathematical Society", "editeur"=>"", "prefixe"=>"N/A"),
80 => array("editeur_ng"=>"Ferrata Storti Foundation", "editeur"=>"Ferrata Storti Foundation", "prefixe"=>"10.3324"),
81 => array("editeur_ng"=>"Frontiers", "editeur"=>"Frontiers Media SA", "prefixe"=>"10.3389"),
82 => array("editeur_ng"=>"Frontiers", "editeur"=>"Frontiers Media SA", "prefixe"=>"10.4175"),
83 => array("editeur_ng"=>"Frontiers", "editeur"=>"Frontiers Media SA", "prefixe"=>"10.3389"),
84 => array("editeur_ng"=>"Frontiers", "editeur"=>"Frontiers Media SA", "prefixe"=>"10.4175"),
85 => array("editeur_ng"=>"Geological Society of America", "editeur"=>"Geological Society of America", "prefixe"=>"10.1130"),
86 => array("editeur_ng"=>"Hindawi", "editeur"=>"Hindawi (Scientifica)", "prefixe"=>"10.6064"),
87 => array("editeur_ng"=>"Hindawi", "editeur"=>"Hindawi (Conference Papers in Science)", "prefixe"=>"10.7217"),
88 => array("editeur_ng"=>"Hindawi", "editeur"=>"Hindawi (Datasets International)", "prefixe"=>"10.7167"),
89 => array("editeur_ng"=>"Hindawi", "editeur"=>"Hindawi (International Scholarly Research Network)", "prefixe"=>"10.5402"),
90 => array("editeur_ng"=>"Hindawi", "editeur"=>"Hindawi (The Scientific World)", "prefixe"=>"10.1100"),
91 => array("editeur_ng"=>"Hindawi", "editeur"=>"Hindawi Limited", "prefixe"=>"10.1155"),
92 => array("editeur_ng"=>"Hindawi", "editeur"=>"Hindawi Publishing Corporation (Sage-Hindawi Access to Research)", "prefixe"=>"10.4061"),
93 => array("editeur_ng"=>"Hindawi", "editeur"=>"Hindawi Publishing Corporation (Syrexe)", "prefixe"=>"10.3814"),
94 => array("editeur_ng"=>"IEEE", "editeur"=>"Institute of Electrical and Electronics Engineers", "prefixe"=>"10.1109"),
95 => array("editeur_ng"=>"IEEE", "editeur"=>"Institute of Electrical and Electronics Engineers", "prefixe"=>"10.23919"),
96 => array("editeur_ng"=>"IEEE", "editeur"=>"Institute of Electrical and Electronics Engineers - Bell Labs", "prefixe"=>"10.15325"),
97 => array("editeur_ng"=>"IEEE", "editeur"=>"Institute of Electrical and Electronics Engineers - preprint", "prefixe"=>"10.36227"),
98 => array("editeur_ng"=>"IEEE", "editeur"=>"Institute of Electrical and Electronics Engineers - StandardDocs", "prefixe"=>"10.47962"),
99 => array("editeur_ng"=>"INIST-CNRS", "editeur"=>"INIST-CNRS", "prefixe"=>"10.4267"),
100 => array("editeur_ng"=>"Inrap", "editeur"=>"", "prefixe"=>"N/A"),
101 => array("editeur_ng"=>"Institute of Mathematical Statistics", "editeur"=>"Institute of Mathematical Statistics", "prefixe"=>"10.1214"),
102 => array("editeur_ng"=>"Institution of Engineering and Technology (IET)", "editeur"=>"Institution of Engineering and Technology (IET)", "prefixe"=>"10.1049"),
103 => array("editeur_ng"=>"International Union of Crystallography", "editeur"=>"International Union of Crystallography", "prefixe"=>"10.1107"),
104 => array("editeur_ng"=>"IOP", "editeur"=>"IOP Publishing", "prefixe"=>"10.1088"),
105 => array("editeur_ng"=>"IOP", "editeur"=>"IOP Publishing", "prefixe"=>"10.35848"),
106 => array("editeur_ng"=>"IOP", "editeur"=>"IOP Publishing - Europhysics Letters", "prefixe"=>"10.1209"),
107 => array("editeur_ng"=>"IOS Press", "editeur"=>"IOS Press", "prefixe"=>"10.3233"),
108 => array("editeur_ng"=>"John Libbey", "editeur"=>"John Libbey Eurotext", "prefixe"=>"10.1684"),
109 => array("editeur_ng"=>"Karger", "editeur"=>"S. Karger AG", "prefixe"=>"10.1159"),
110 => array("editeur_ng"=>"Lavoisier", "editeur"=>"Lavoisier SAS", "prefixe"=>"10.3166"),
111 => array("editeur_ng"=>"Lexis Publisher (OMICS)", "editeur"=>"Lexis Publisher (OMICS)", "prefixe"=>"10.15412"),
112 => array("editeur_ng"=>"LexisNexis", "editeur"=>"", "prefixe"=>"N/A"),
113 => array("editeur_ng"=>"Lextenso", "editeur"=>"", "prefixe"=>"N/A"),
114 => array("editeur_ng"=>"L'Harmattan", "editeur"=>"", "prefixe"=>"N/A"),
115 => array("editeur_ng"=>"Mary Ann Liebert", "editeur"=>"Mary Ann Liebert", "prefixe"=>"10.1089"),
116 => array("editeur_ng"=>"MDPI", "editeur"=>"MDPI AG", "prefixe"=>"10.1989"),
117 => array("editeur_ng"=>"MDPI", "editeur"=>"MDPI AG", "prefixe"=>"10.3390"),
118 => array("editeur_ng"=>"MDPI", "editeur"=>"MDPI AG", "prefixe"=>"10.20944"),
119 => array("editeur_ng"=>"MDPI", "editeur"=>"MDPI AG - Encyclopedia", "prefixe"=>"10.32545"),
120 => array("editeur_ng"=>"MIT Press", "editeur"=>"MIT Press", "prefixe"=>"10.1162"),
121 => array("editeur_ng"=>"MIT Press", "editeur"=>"MIT Press", "prefixe"=>"10.7551"),
122 => array("editeur_ng"=>"MIT Press", "editeur"=>"MIT Press", "prefixe"=>"10.1162"),
123 => array("editeur_ng"=>"MIT Press", "editeur"=>"MIT Press", "prefixe"=>"10.7551"),
124 => array("editeur_ng"=>"MIT Press", "editeur"=>"MIT Press - Blogs", "prefixe"=>"10.31859"),
125 => array("editeur_ng"=>"Nature Publishing Group", "editeur"=>"Springer Nature", "prefixe"=>"10.1038"),
126 => array("editeur_ng"=>"Nature Publishing Group", "editeur"=>"Springer Nature", "prefixe"=>"10.1013"),
127 => array("editeur_ng"=>"Nature Publishing Group", "editeur"=>"Springer Nature", "prefixe"=>"10.1057"),
128 => array("editeur_ng"=>"Nature Publishing Group", "editeur"=>"Springer Nature", "prefixe"=>"10.3858"),
129 => array("editeur_ng"=>"Nature Publishing Group", "editeur"=>"Springer Nature - VVW", "prefixe"=>"10.33283"),
130 => array("editeur_ng"=>"Nature Publishing Group", "editeur"=>"SpringerNature", "prefixe"=>"10.26777"),
131 => array("editeur_ng"=>"Nature Publishing Group", "editeur"=>"SpringerNature", "prefixe"=>"10.26778"),
132 => array("editeur_ng"=>"Nature Research Centre -NRC", "editeur"=>"Nature Research Centre -NRC", "prefixe"=>"10.35513"),
133 => array("editeur_ng"=>"OpenEdition", "editeur"=>"OpenEdition", "prefixe"=>"10.4000"),
134 => array("editeur_ng"=>"OSA", "editeur"=>"The Optical Society", "prefixe"=>"10.1364"),
135 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - Anesthesia & Analgesia", "prefixe"=>"10.1213"),
136 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - Lippincott Williams & Wilkins", "prefixe"=>"10.1097"),
137 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - Neurosurgery", "prefixe"=>"10.1227"),
138 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - Triological Society", "prefixe"=>"10.1288"),
139 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - American Academy of Neurology", "prefixe"=>"10.1212"),
140 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - ENSTINET", "prefixe"=>"10.7123"),
141 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - International Pediatric Research Foundation", "prefixe"=>"10.1203"),
142 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - Italian Federation of Cardiology", "prefixe"=>"10.2459"),
143 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters Kluwer) - National Strength & Conditioning", "prefixe"=>"10.1519"),
144 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies (Wolters-Kluwer) - American College of Sports Medicine", "prefixe"=>"10.1249"),
145 => array("editeur_ng"=>"Ovid", "editeur"=>"Ovid Technologies Wolters Kluwer -American Heart Association", "prefixe"=>"10.1161"),
146 => array("editeur_ng"=>"Oxford University Press", "editeur"=>"Oxford University Press", "prefixe"=>"10.1093"),
147 => array("editeur_ng"=>"Peer Community In", "editeur"=>"Peer Community In", "prefixe"=>"10.24072"),
148 => array("editeur_ng"=>"PeerJ", "editeur"=>"PeerJ", "prefixe"=>"10.7717"),
149 => array("editeur_ng"=>"PeerJ", "editeur"=>"PeerJ", "prefixe"=>"10.7287"),
150 => array("editeur_ng"=>"PeerJ", "editeur"=>"PeerJ", "prefixe"=>"10.7717"),
151 => array("editeur_ng"=>"PeerJ", "editeur"=>"PeerJ", "prefixe"=>"10.7287"),
152 => array("editeur_ng"=>"Pergola / Université de Rennes", "editeur"=>"Pergola / Université de Rennes", "prefixe"=>"10.56078"),
153 => array("editeur_ng"=>"PLOS", "editeur"=>"Public Library of Science", "prefixe"=>"10.1371"),
154 => array("editeur_ng"=>"PLOS", "editeur"=>"Public Library of Science (PLoS)", "prefixe"=>"10.24196"),
155 => array("editeur_ng"=>"PNAS", "editeur"=>"Proceedings of the National Academy of Sciences", "prefixe"=>"10.1073"),
156 => array("editeur_ng"=>"Presses Universitaires de France", "editeur"=>"", "prefixe"=>"N/A"),
157 => array("editeur_ng"=>"The Royal Society of Chemistry", "editeur"=>"The Royal Society of Chemistry", "prefixe"=>"10.1039"),
158 => array("editeur_ng"=>"Sage", "editeur"=>"SAGE", "prefixe"=>"10.14240"),
159 => array("editeur_ng"=>"Sage", "editeur"=>"Sage - Corwin", "prefixe"=>"10.17322"),
160 => array("editeur_ng"=>"Sage", "editeur"=>"SAGE Publications", "prefixe"=>"10.1177"),
161 => array("editeur_ng"=>"Sage", "editeur"=>"SAGE Publications", "prefixe"=>"10.31124"),
162 => array("editeur_ng"=>"Sage", "editeur"=>"Sage Publications - Technomic Publishing Company", "prefixe"=>"10.1106"),
163 => array("editeur_ng"=>"Sage", "editeur"=>"Sage Publications (JRAAS Limited)", "prefixe"=>"10.3317"),
164 => array("editeur_ng"=>"Sage", "editeur"=>"Sage Publications (Prufrock Press, Inc.)", "prefixe"=>"10.4219"),
165 => array("editeur_ng"=>"Sage", "editeur"=>"Sage Publications - Bulletin of the Atomic Scientists", "prefixe"=>"10.2968"),
166 => array("editeur_ng"=>"Sage", "editeur"=>"Sage Publications - Reference E-Books", "prefixe"=>"10.4135"),
167 => array("editeur_ng"=>"Sage", "editeur"=>"Sage Publications- Academy of Traumatology", "prefixe"=>"10.1528"),
168 => array("editeur_ng"=>"Sage", "editeur"=>"Sage Publications-International Institute for Environment and Development", "prefixe"=>"10.1630"),
169 => array("editeur_ng"=>"Sage", "editeur"=>"SAGE Publicaitons - Society for Experimental Biology and Medicine", "prefixe"=>"10.3181"),
170 => array("editeur_ng"=>"Sage", "editeur"=>"SAGE Publications", "prefixe"=>"10.47515"),
171 => array("editeur_ng"=>"Sage", "editeur"=>"SagePublications - National Association of School Nurses", "prefixe"=>"10.1622"),
172 => array("editeur_ng"=>"SIAM", "editeur"=>"Society for Industrial and Applied Mathematics", "prefixe"=>"10.1137"),
173 => array("editeur_ng"=>"Société archéologique et historique d'Ille-et-Vilaine", "editeur"=>"", "prefixe"=>"N/A"),
174 => array("editeur_ng"=>"Société d'histoire et d'archéologie de Bretagne", "editeur"=>"", "prefixe"=>"N/A"),
175 => array("editeur_ng"=>"Société Française de Santé Publique", "editeur"=>"", "prefixe"=>"N/A"),
176 => array("editeur_ng"=>"Societe Mathematique de France", "editeur"=>"Societe Mathematique de France", "prefixe"=>"10.24033"),
177 => array("editeur_ng"=>"Société préhistorique française", "editeur"=>"", "prefixe"=>"N/A"),
178 => array("editeur_ng"=>"Societe Royale de Chimie", "editeur"=>"Societe Royale de Chimie", "prefixe"=>"10.52809"),
179 => array("editeur_ng"=>"SPIE", "editeur"=>"SPIE - International Society for Optical Engineering", "prefixe"=>"10.1117"),
180 => array("editeur_ng"=>"Springer", "editeur"=>"Springer (Biological Procedures Online)", "prefixe"=>"10.1251"),
181 => array("editeur_ng"=>"Springer", "editeur"=>"Springer (Biomed Central Ltd.)", "prefixe"=>"10.1186"),
182 => array("editeur_ng"=>"Springer", "editeur"=>"Springer (Cases Network, Ltd.)", "prefixe"=>"10.4076"),
183 => array("editeur_ng"=>"Springer", "editeur"=>"Springer (Kluwer Academic Publishers - Biomedical Engineering Society (BMES))", "prefixe"=>"10.1114"),
184 => array("editeur_ng"=>"Springer", "editeur"=>"Springer (Kluwer Academic Publishers)", "prefixe"=>"10.1023"),
185 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - (backfiles)", "prefixe"=>"10.5819"),
186 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - Adis", "prefixe"=>"10.2165"),
187 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - ASM International", "prefixe"=>"10.1361"),
188 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - Cell Stress Society International", "prefixe"=>"10.1379"),
189 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - Ecomed Publishers", "prefixe"=>"10.1065"),
190 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - FD Communications", "prefixe"=>"10.1381"),
191 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - Global Science Journals", "prefixe"=>"10.7603"),
192 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - Humana Press", "prefixe"=>"10.1385"),
193 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - Psychonomic Society", "prefixe"=>"10.3758"),
194 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - Real Academia de Ciencias Exactas, Fisicas y Naturales", "prefixe"=>"10.5052"),
195 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - RILEM Publishing", "prefixe"=>"10.1617"),
196 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - Society of Surgical Oncology", "prefixe"=>"10.1245"),
197 => array("editeur_ng"=>"Springer", "editeur"=>"Springer - The Korean Society of Pharmaceutical Sciences and Technology", "prefixe"=>"10.4333"),
198 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Fachmedien Wiesbaden GmbH", "prefixe"=>"10.1365"),
199 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Publishing Company", "prefixe"=>"10.1891"),
200 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1038"),
201 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1013"),
202 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1057"),
203 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.3858"),
204 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.7123"),
205 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.33283"),
206 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1038"),
207 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1013"),
208 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1057"),
209 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.3858"),
210 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.7123"),
211 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.33283"),
212 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1038"),
213 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1013"),
214 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1057"),
215 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.3858"),
216 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.7123"),
217 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.33283"),
218 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1038"),
219 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1013"),
220 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1057"),
221 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.3858"),
222 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.7123"),
223 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.33283"),
224 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1038"),
225 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1013"),
226 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1057"),
227 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.3858"),
228 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.7123"),
229 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.33283"),
230 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1038"),
231 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1013"),
232 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.1057"),
233 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.3858"),
234 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.7123"),
235 => array("editeur_ng"=>"Springer", "editeur"=>"Springer Science and Business Media LLC", "prefixe"=>"10.33283"),
236 => array("editeur_ng"=>"Taylor & Francis", "editeur"=>"Informa UK (Taylor & Francis Books)", "prefixe"=>"10.1531"),
237 => array("editeur_ng"=>"Taylor & Francis", "editeur"=>"Informa UK (Taylor & Francis)", "prefixe"=>"10.1080"),
238 => array("editeur_ng"=>"Techniques de l'ingénieur", "editeur"=>"", "prefixe"=>"N/A"),
239 => array("editeur_ng"=>"The Royal Society", "editeur"=>"The Royal Society", "prefixe"=>"10.1098"),
240 => array("editeur_ng"=>"The Royal Society of Medicine", "editeur"=>"The Royal Society of Medicine", "prefixe"=>"10.1258"),
241 => array("editeur_ng"=>"Georg Thieme Verlag KG", "editeur"=>"Georg Thieme Verlag KG", "prefixe"=>"10.1055"),
242 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley", "prefixe"=>"10.18934"),
243 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (AHRC Research Centre)", "prefixe"=>"10.2966"),
244 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (American Cancer Society)", "prefixe"=>"10.3322"),
245 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (American College of Veterinary Internal Medicine)", "prefixe"=>"10.1892"),
246 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Blackwell Publishing)", "prefixe"=>"10.1111"),
247 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Blackwell Publishing)", "prefixe"=>"10.1046"),
248 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Blackwell Publishing)", "prefixe"=>"10.1111"),
249 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Blackwell Publishing)", "prefixe"=>"10.1046"),
250 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (British Psychological Society)", "prefixe"=>"10.1348"),
251 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Canadian Academic Accounting Association)", "prefixe"=>"10.1506"),
252 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Comparative Legislative Research Center)", "prefixe"=>"10.3162"),
253 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Equine Veterinary Journal)", "prefixe"=>"10.2746"),
254 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (International Journal of Psychoanalysis)", "prefixe"=>"10.1516"),
255 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (International Life Sciences Institute)", "prefixe"=>"10.1301"),
256 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (John Wiley & Sons)", "prefixe"=>"10.1002"),
257 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Munksgaard)", "prefixe"=>"10.1034"),
258 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (New York Academy of Sciences E-Briefings)", "prefixe"=>"10.3405"),
259 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (New York Academy of Sciences)", "prefixe"=>"10.1196"),
260 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Opulus Press)", "prefixe"=>"10.3170"),
261 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Physiological Reports)", "prefixe"=>"10.14814"),
262 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Production and Operations Management)", "prefixe"=>"10.3401"),
263 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Robotic Publications)", "prefixe"=>"10.1581"),
264 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Royal Meteorological Society)", "prefixe"=>"10.1256"),
265 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Rural Sociological Society)", "prefixe"=>"10.1526"),
266 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Society of Environmental Toxicology and Chemistry)", "prefixe"=>"10.1897"),
267 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (Teachers of English to Speakers of Other Languages, Inc.)", "prefixe"=>"10.5054"),
268 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (The Physiological Society)", "prefixe"=>"10.1113"),
269 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley (The Wildlife Society)", "prefixe"=>"10.4004"),
270 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley Blackwell (Blackwell Publishing - Foundation for Cellular and Molecular Medicine)", "prefixe"=>"10.2755"),
271 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley Blackwell (Royal College of Obstetricians & Gynecologist)", "prefixe"=>"10.1576"),
272 => array("editeur_ng"=>"Wiley", "editeur"=>"Wiley(American Society Bone & Mineral Research)", "prefixe"=>"10.1359"),
273 => array("editeur_ng"=>"World Scientific", "editeur"=>"World Scientific", "prefixe"=>"10.1142"),
274 => array("editeur_ng"=>"World Scientific Press", "editeur"=>"World Scientific Press", "prefixe"=>"10.59545")
);
?>