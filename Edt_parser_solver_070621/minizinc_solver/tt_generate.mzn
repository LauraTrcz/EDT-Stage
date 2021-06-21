%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% GENERATEUR DE U-CONTRAINTES

include "tt_utils.mzn";


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%% MODULARISATION ET TRI DE TUPLES
%%%%%
%%% TUPLES MODULAIRES
%%%
%%% Soit `k>0`, un tuple `t` à valeurs dans un domaine `D` est modulaire en `k` si :
%%% - il peut être "replié" en une matrice de `k` lignes
%%% - où une même valeur est répétée sur chaque ligne.
%%%
%%% Le générateur d'un tuple modulaire en `k` correspond à sa première "colonne".
%%%
%%% NB.
%%% - Un tuple est modulaire en sa taille.
%%% - Un tuple modulaire en `k` est modulaire en tout multiple de `k` inférieur à sa taille.
%%%
%%% Formellement, soit `k>0`, un tuple `t` est modulaire en `k` si :
%%% - `|t| mod k=0`, et
%%% - `t_{(|t| div k)(i-1)+j}=t_{(|t| div k)(i-1)+1}`pour tout `i in 1..k,j in 1..|t| div k`.
%%%
%%% Le *générateur* d'un tuple `t` modulaire en `k` est le `k`-uplet t_{1}t_{(|t| div k)+1}...t_{(|t| div k)(k-1)+1}.
%%%
%%%
%%%%%
%%% TRI LEXICOGRAPHIQUE DE TUPLES MODULAIRES
%%%
%%% Des tuples modulaires peuvent être comparés lexicographiquement ligne après ligne.
%%%
%%% Notation. Si `t` est un tuple modulaire en `k`, on note `t[i]` la `i`-ème "ligne" de `t`(ie. `t[i]=t_{(|t| div k)(i-1)+1}...t_{(|t| div k)(i-1)+|t| div k)}`). 
%%%
%%%  Soit <= un ordre total sur `D`, < dénote l'ordre lexicographique strict induit par <= sur les tuples à valeurs dans `D` et défini par :
%%% - `t<u <-> (pour tout j : (0<j<=min(|t|,|u|) /\ t_j>=u_j) -> (il existe i : 0<i<j /\ t_i<u_i))`.  
%%% 
%%%  Soit <= un ordre total sur `D` et `k>0`, << dénote l'ordre lexicographique strict induit par <= sur les tuples modulaires en `k` à valeurs dans `D` et défini par :
%%%  - `t<<u` <-> (pour tout i : (0<i<=k /\ t[i]>=u[i]) -> (il existe h : 0<h<i /\ t[h]<u[h]))`.
%%%
%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%% QUARK, Q-QUARK, TABLEAU DE Q-QUARKS
%%%%%
%%% QUARK
%%% On considère un domaine :
%%% - dénoté `U_QUARK`
%%% - de valeurs entières appelées *quarks*
%%% - représentant des objets fondamentaux d'un domaine, eg
%%% -- séances d'une instance EDT
%%% -- étudiants d'une instance de sectionnement d'effectifs
%%% -- attribution individuelle de classes d'une instance d'affectation de services
%%% -- ...
%%%
%%%
%%%%%
%%% Q-QUARK
%%% Un *q-quark* dénote un tuple, éventuellement vide, de *quarks tous différents*.
%%%
%%% Un q-quark se représente par un tableau unidimensionel :
%%% - aligné avec un caractère réservé appelé *padder* et dénoté `qquark_padder`
%%% - sur la plage d'indexation normée `Q_QUARK==1..card(QUARK)`
%%% - à valeurs dans le domaine `Q_VALUE = {qquark_padder} union U_QUARK`.
%%%
%%% NB.
%%% - Un q-quark se termine par une répétition, éventuellement vide, du padder.
%%% - Le *q-quark nul* dénotant le tuple vide ne comporte que des occurences du padder.
%%% - Les opérations de padding, unpadding, concaténation, projection et permutation de q-quark s'implément sur leurs représentations alignées.
%%%
%%% Un q-quark s'interprète comme le tuple de quarks obtenu en supprimant toute occurence du padder.
%%%
%%%
%%%%%
%%% TABLEAU DE QUARKS
%%% Un tableau de quarks dénote l'ensemble des tuples que dénote les quarks.
%%%
%%%
%%% Un ensemble d'ensembles de tuples peut se représenter par :
%%% - un tableau de quarks
%%% - joint à un tableau d'entiers dont la somme est égale au nombre de quarks et dont le i-ème entier dénote la cardinalité du i-ème ensemble.
%%%
%%% Le tableau peut alors s'interpréter comme l'empilement des tableaux représentant chaque ensemble.
%%%
%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%  COLLECTEUR DE U-CONTRAINTES
%%%%%
%%% PORTEE DE U-CONTRAINTE
%%% Une *portée (de U-contrainte)* est un n-uplet non-vide de q-quarks non-nuls.
%%% L'*arité* d'une portée est la taille du n-uplet associé.
%%%
%%% Les notions d'appartenance et de correspondance de quark sont étendues aux portées : 
%%% - une portée est *conforme à* un ensemble de quarks si tous ses quarks appartiennent à cet ensemble
%%% - une portée *correspond à* un élément  de `U_ELEMENT` si tous ses quarks correspondent à cet élément.
%%%
%%% NB :
%%% - Toute portée correspond aux quarks qu'elle comporte.
%%% - Selon le type de correspondance fonctionnelle entre quarks et éléments (fonction monovaluée/multivaluée, injection/surjection/bijection), une portée peut :
%%% -- ne correspondre à aucun des éléments d'un type donné
%%% -- correspondre à exactement 1 élément d'un type donné
%%% -- correspondre à plus d'1 élément d'un type donné
%%% -- correspondre à tous les éléments d'un type donné.
%%%
%%% Exemples :
%%%  - p(2,1,5) désigne la portée comportant dans l'ordre les quarks 13, 11 et 15.
%%%  - p() et p(1,1) sont des portées mal formées.
%%%  - p(2,1,5) est conforme à tout ensemble de quarks incluant {2,1,5}.
%%%  - p(2,1,5) correspond à tout élément `e` si les quarks 2, 1 et 5 correspondent à `e`.
%%%
%%%
%%%%%
%%% PORTEE RELATIVE
%%% Une portée relative est un tuple de rangs de quarks (ie. à valeurs dans `U_RANK`) non vide (`n>0`) et sans répétitions.
%%%
%%% La *relativisation* d'une portée désigne la portée relative obtenue en y substituant chaque quark par son rang.
%%%
%%% Exemples :
%%% - r(2,1,1) désigne la portée relative comportant dans l'ordre les rangs 2, 1 et 1.
%%% - r(2,1,1) relativise p(s(2,10),s(1,8),s(1,3)) où s(r,n) dénote le quark `n` de rang `r`.
%%% - p(s(3,3),s(3,6),s(1,4),s(1,2),s(2,5),s(2,2)) est de portée relative r(3,3,1,1,2,2) qui est modulaire en k=3 et de générateur (3,1,2).
%%%
%%%
%%%%%
%%% MASQUE DE PORTEE
%%% Un masque de portée représente en intension un ensemble de portées modulaires.
%%%
%%% Un masque de portée se définit par une portée relative.
%%%
%%% Une portée satisfait un masque si sa portée relative est modulaire et admet le masque pour générateur.
%%%
%%% Exemples :
%%% - m(2,1,4) désigne le masque comportant dans l'ordre les rangs de quarks 2, 1 et 4.
%%% - m(1,1) est un masque mal formé.
%%% - p(s(1,10)) ne satisfait que m(1).
%%% - p(s(1,12),(1,10)) ne satisfait que m(1).
%%% - p(s(2,13),(1,10)) ne satisfait que m(2,1).
%%% - p(s(1,12),(1,10),s(2,12)) ne satisfait aucun masque.
%%% - p(s(2,15),(2,13),(1,12),s(1,10)) ne satisfait que m(2,1).
%%% - p(s(3,3),s(3,6),s(1,4),s(1,2),s(2,5),s(2,2)) satisfait m(3,1,2).
%%%
%%%
%%%%%
%%% FILTRE DE QUARKS
%%% Un filtre représente en intension un ensemble de quarks potentiellement vide.
%%%
%%% Un filtre se définit par un sous-ensemble d'éléments du même type.
%%%
%%% Un filtre s'interprète comme l'union des ensembles de quarks qui correspondent à ses éléments.
%%%
%%%
%%%%%
%%% LISTE DE FILTRES
%%%
%%% Une liste de filtres représente en intension un ensemble de quarks potentiellement vide.
%%%
%%% Une liste de filtres se définit par un multi-ensemble, potentiellement vide, de filtres.
%%%
%%% Une liste de filtres s'interprète comme :
%%% - l'intersection des ensembles de quarks de ses filtres si elle est non vide,
%%% - l'ensemble des quarks sinon.
%%%
%%% NB. L'ordre des filtres dans une liste est sans incidence sur son interprétation.
%%%
%%%
%%%%%
%%% COLLECTEUR DE PORTEES
%%% Un collecteur de portées représente en intension un ensemble de portées potentiellement vide.
%%%
%%% Un collecteur de portées se définit par :
%%% - une liste de filtres
%%% - un type d'éléments (ie. une valeur dans `U_TYPE`)
%%% - et un masque de portée.
%%%
%%% Une portée est *compatible* avec un élément du type considéré si :
%%% - elle est conforme à la liste de filtres
%%% - elle correspond à l'élément, et
%%% - elle satisfait au masque.
%%%
%%% NB.
%%% - Un élément peut n'admettre aucune portée compatible.
%%% - Un élément peut admettre des portées compatibles de tailles différentes ou égales.
%%% - Si un élément admet des portées compatibles, il admet une unique portée <<-minimale parmi l'ensemble de ses portées compatibles qui ont la taille maximum. Cette portée est dite *lex-min-max*.
%%% - Deux éléments peuvent avoir des portées compatibles communes.
%%% - Deux éléments peuvent avoir la même portée lex-min-max.
%%%
%%% L'ensemble de portées représenté par un collecteur contient la portée lex-min-max de chaque élément du type considéré si elle existe. L'ensemble de portées est vide, et le collecteur est dit *nul*, si aucun élément n'admet de portée lex-min-max.
%%%
%%% NB.
%%% - La collection de portées est invariante par :
%%% -- suppression des éléments sans portées compatibles
%%% -- choix d'un élément arbitraire parmi les éléments de même portée-lex-min-max (classe d'équivalence).
%%%
%%% - Pour les U-contraintes qui sont anti-monotones pour la subsumption de tuples, la collection de portées est invariante par :
%%% -- suppression des éléments de portées sous-sommées
%%% - La maximisation de la taille des portées compatibles élimine les portées qui ne couvrent pas tous les quarks correspondant à l'élément.
%%% - La <<-minimisation conserve une unique portée représentative par classe de portées compatibles qui sont équivalentes modulo permutation des quarks.
%%%
%%%
%%%%%
%%% LISTE DE COLLECTEURS
%%% Une liste de collecteurs se définit par un ensemble non vide de collecteurs de portées.
%%%
%%% Une liste de `k` collecteurs s'interprète comme le produit cartésien des `k` ensembles de portées associés.
%%%
%%%
%%%%%
%%% U-FONCTION
%%% Une U-fonction dénote une fonction de valuation de portée, d'arité fixe, paramétrée ou non, étiquettable en contrainte dure ou souple.
%%%
%%% Une U-fonction se définit par :
%%% - sa catégorie : dure (`hard_constraint`) ou souple (`soft_constraint`)
%%% - son nom, auquel est associé son arité
%%% - sa liste, potentiellement vide, de paramètres.
%%%
%%% Le domaine d'une U-fonction est l'ensemble des portées de taille égale à son arité.
%%%
%%% Le co-domaine d'une U-fonction est :
%%% - booléen si elle est dure
%%% - un domaine de valuation quelconque sinon (TODO revoir -> VCSP).
%%%
%%%
%%%%%
%%% U-CONTRAINTE
%%% Une U-contrainte dénote une contrainte sur un ou plusieurs tuples de variables associées chacune à une quark et toutes du même type dans chaque tuple :
%%% - variables de programmation : choix du créneau pour une quark
%%% - variables d'équipement : choix du nombre d'équipements par type d'équipements requis pour une quark
%%% - variables d'allocation : choix des salles hébergeant une quark
%%% - variables d'encadrement : choix des enseignants encadrant une quark.
%%%
%%% Une U-contrainte se définit par une portée et une U-fonction.
%%%
%%% Une U-contrainte s'interprète par la contrainte définie par l'instantiation de la U-fonction à sa portée.
%%%
%%%
%%%%%
%%% COLLECTEUR DE U-CONTRAINTES
%%% Un collecteur de U-contraintes représente en intension une conjonction de U-contraintes.
%%%
%%% Un collecteur de U-contraintes se définit par un collecteur de portées et une U-fonction.
%%%
%%% Le multi-ensemble de U-contraintes représenté comprend les U-contraintes associant chacune la U-fonction à une portée du collecteur.
%%%
%%% Un collecteur de U-contraintes s'interprète par la conjonction des contraintes correspondantes.
%%%
%%% NB :
%%% - Les contraintes représentées par un collecteur de U-contraintes partagent la même U-fonction.
%%% - Les contraintes représentées par un collecteur de U-contraintes peuvent avoir des portées différentes en taille ou valeurs.
%%%


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%% API DE LIAISON A UN PROBLEME CIBLE (TIMETABLING, COURSE PLANNING, COURSE STAFFING, STUDENT SECTIONNING ...)

%%% API fonctionnelle/structurelle :
% function set of SESSIONS: utt_element_sessions(UTT_TYPE: t, UTT_ELEMENT: e) = 
% function set of UTT_ELEMENT: utt_elements(UTT_TYPE: t) =
% array[CONSTRAINT] of set of SCOPE: constraint_scopes; % les portées d'une contrainte
% array[SCOPE] of set of FILTER: scope_filters; % les filtres d'une portée
% array[CONSTRAINT] of UTT_FUNCTION: constraint_function; % la fonction d'une contrainte
% array[CONSTRAINT] of set of PARAMETER: function_parameters; % les paramètres d'une contrainte
% array[SCOPE] of UTT_TYPE: scope_clustering; % le critère de regroupement d'une portée 
% array[SCOPE,SESSION_RANK] of SESSION_RANK_V: scope_mask; % le masque sur rangs de séances d'une portée
% array[FILTER] of UTT_TYPE: filter_type; % le type d'un filtre (de ses éléments)
% array[FILTER] of set of UTT_ELEMENT: filter_elements; % les éléments résultant d'un filtre
% array[CONSTRAINT] of UTT_HARDNESS: function_type; % la dureté d'une contrainte
% array[PARAMETER] of UTT_PARAMETER: parameter_value; % la valeur d'un paramètre


%%% TYPES ET DOMAINES DU GENERATEUR
% le type des types d'U-éléments
set of int: U_TYPE = UTT_TYPE;
% le type des U-éléments
set of int: U_ELEMENT = UTT_ELEMENT;
% le type des collecteurs de U-contraintes
set of int: U_CONSTRAINT_COLLECTOR = CONSTRAINT;
% le type des collecteurs de U-portées
set of int: U_SCOPE_COLLECTOR = SCOPE;
% le type des U-filtres
set of int: U_FILTER = FILTER;
% le type des U-paramètres
set of int: U_PARAMETER = PARAMETER;
set of int :U_PARAMETER2 =ELEMENT_PARAMETER;
% le type des U-fonctions
set of int: U_FUNCTION = UTT_FUNCTION;
% le type des catégories de U-fonctions
set of int: U_HARDNESS = UTT_HARDNESS;
% le domaine de valeurs commun aux paramètres de U-fonctions
set of int: U_PARAMETER_VALUE = UTT_PARAMETER;

% le type des U-critères
set of int: U_CRITERION = UTT_CRITERION;
% le type des U-quarks
set of int: U_QUARK = SESSION;
% le type des U-rangs
set of int: U_RANK = SESSION_RANK;

%%% CONSTANTES (PROBLEME-INDEPENDANTES)
% valeur fictive délimitant la fin d'un q-quark
int: qquark_padder = 0;
% valeur fictive séparant les q-quarks dans un tuple de q-quarks
int: tquark_delimiter = -1;
% valeur fictive délimitant la fin d'un masque
int: mask_padder = 0;

%%% TYPES ET DOMAINES (PROBLEME-INDEPENDANTS)
% le type des types d'arité de U-fonction
enum U_ARITY_TYPE = {u_arity_1,u_arity_n};
array[U_ARITY_TYPE] of string: utt_arity_type_name = ["u_arity_1","u_arity_n"];
% plage d'arités des U-contraintes
set of int: U_ARITY = 1..10;%TODO à lier et borner par instance
% domaine virtualisé des quarks incluant padder pour représenter les valeurs de q-quarks
set of int: Q_VALUE = {qquark_padder} union U_QUARK;
% plage d'indexation de q-quark
set of int: QUPLE = 1..card(U_QUARK);
% domaine virtualisé des quarks incluant délimiteur et padder pour représenter les valeurs de t-quarks
set of int: T_VALUE = {tquark_delimiter} union Q_VALUE;
% plage d'indexation de t-quark
set of int: TUPLE = 1..2*card(QUPLE);
% domaine virtualisé des rangs de quarks incluant padder pour représenter les valeurs de masques
set of int: M_VALUE = {mask_padder} union U_RANK;
% plage d'indexation de masque
set of int: MASK = U_RANK;


%%% FONCTIONS
%%%% NOMENCLATURE DES U-FONCTIONS
% TODO
% arité des u-fonctions
array[U_FUNCTION] of set of U_ARITY_TYPE: u_function_arities = [
{u_arity_1,u_arity_n}, %same_rooms
{u_arity_1,u_arity_n}, %same_slots
{u_arity_1,u_arity_n}, %same_teachers
{u_arity_1,u_arity_n}, %same_week
{u_arity_1,u_arity_n}, %sequenced
{u_arity_1,u_arity_n}, %weekly
{u_arity_1,u_arity_n}, %repartitionteacher
{u_arity_1,u_arity_n},%forbiddenSlots
{u_arity_1,u_arity_n},%not_consecutive_rooms
{u_arity_1,u_arity_n},%connected_rooms
{u_arity_1,u_arity_n},%at_most_daily
{u_arity_1,u_arity_n}%allocat_slot
];

%%% TUPLES VIDES
% le *q-quark nul*
function array[QUPLE] of Q_VALUE: null_qquark() =
  [qquark_padder | i in QUPLE];

% *q-quark nul*
function bool: null_qquark(array[QUPLE] of Q_VALUE: Q) =
  Q==null_qquark();

% le *masque nul*
function array[MASK] of M_VALUE: null_mask() =
  [mask_padder | i in MASK];

% *masque nul*
function bool: null_mask(array[MASK] of M_VALUE: M) =
  M==null_mask();

% ensemble contenant au moins 1 q-quark vide
function bool: null_qquark_in_list(array[int,QUPLE] of Q_VALUE: L) =
  exists(i in index_set_1of2(L))(null_qquark(array_2d_to_1d(L[i..i,QUPLE])));

%%%
% linéarise le tableau supposé mono-ligne `qquark` et renvoie le désalignement de son q-quark 
function array[int] of U_QUARK: unpad_quple(array[int,QUPLE] of Q_VALUE: qquark) =
  let {
  bool: checkarg1 = assert(card(index_set_1of2(qquark))==1,"expecting single-line array " ++ show(qquark),true);
  } in
  unpad_tuple(array_2d_to_1d(qquark),qquark_padder);


%%%
%
function string: my_show(string: t, array[int,int] of int: O, bool: start) =
  if start==true
  then  "<<" ++ my_show(t,O,false) ++ ">>"
  elseif card(index_set_1of2(O))==1
  then  my_show(t,O[min(index_set_1of2(O)),index_set_2of2(O)],true)
  else  my_show(t,O[min(index_set_1of2(O)),index_set_2of2(O)],true) ++ "," ++ my_show(t,O[index_set_1of2(O) diff {min(index_set_1of2(O))},index_set_2of2(O)],false)
  endif;

 %  
function string: my_show(string: t, array[int] of int: O, bool: start) =
  if start==true
  then  "<" ++ my_show(t,O,false) ++ ">"
  elseif card(index_set(O))==1
  then  my_show(t,O[min(index_set(O))])
  else  my_show(t,O[min(index_set(O))]) ++ "," ++ my_show(t,O[index_set(O) diff {min(index_set(O))}],false)
  endif;
  
%
function string: my_show(string: t, int: obj) = 
  if       t=="W"
  then "element type=" ++ utt_type_name[to_enum(UTT_TYPE,obj)]
  elseif t=="R"
  then "room=" ++ room_name[obj]
  elseif t=="T"
  then "teacher=" ++ teacher_name[obj]
  elseif t=="E"
  then "equipment=" ++ equipment_name[obj]
  elseif t=="G"
  then "group=" ++ group_name[obj]
  elseif t=="U"
  then "" ++ course_name[obj]
  elseif t=="P"
  then "" ++ course_name[part_course(obj)] ++ "-"  ++ part_name[obj]
  elseif t=="C"
  then "" ++ course_name[part_course(class_part(obj))] ++ "-"  ++ part_name[class_part(obj)] ++ "-"  ++ show(obj)
  elseif t=="S"
  then "" ++ course_name[part_course(class_part(session_class(obj)))] ++ "-"  ++ part_name[class_part(session_class(obj))] ++ "-("  ++ show(obj) ++  "," ++ show(session_rank(obj)) ++ ")"
  elseif t=="O"
  then "rank=" ++ show(obj)
  elseif t=="CC"
  then "c-collector=" ++ show(obj)
  elseif t=="SC"
  then "s-collector=" ++ show(obj)
  elseif t=="M"
  then "" ++ show(obj)
  elseif t=="f"
  then "filter=" ++ show(obj)
  elseif t=="F"
  then "function=" ++ utt_function_name[to_enum(UTT_FUNCTION,obj)]
  elseif t=="H"
  then "hardness=" ++ utt_hardness_name[to_enum(UTT_HARDNESS,obj)]
  elseif t=="A"
  then if obj>2 then "arity-type=" ++ utt_arity_type_name[to_enum(U_ARITY_TYPE,2)] else "arity-type=" ++ utt_arity_type_name[to_enum(U_ARITY_TYPE,obj)]endif
  elseif t=="K"
  then "criterion=" ++ utt_criterion_name[to_enum(UTT_CRITERION,obj)]
  elseif t=="V"
  then "parameter=" ++ show(obj)
  else trace("BUG: did not capture/implement expected name code","NAMING ERROR") 
  endif;


%%% API FONCTIONNELLE
% renvoie l'ensemble d'éléments d'un type
function set of U_ELEMENT: elements(U_TYPE: t) = utt_elements(t);
% renvoie l'ensemble des quarks correspondant à un élément selon son identifiant et son type
function set of U_QUARK: element_quarks(U_TYPE: t, U_ELEMENT: e) = utt_element_sessions(t,e);
% renvoie le rang d'un quark
function U_RANK: quark_rank(U_QUARK: q) = session_rank(q);
% les portées d'un collecteur de contraintes
function array[int] of U_SCOPE_COLLECTOR: constraint_collector_scopes(U_CONSTRAINT_COLLECTOR: c) = set2array(constraint_scopes[c]);
 % !! les collecteurs de U-portées doivent être numérotés dans l'ordre de leur déclaration XML pour que la conversion ensemble-tableau soit correcte;
% les filtres d'un collecteur de portées
function set of U_FILTER: scope_collector_filters(U_SCOPE_COLLECTOR: s) = scope_filters[s];
% la fonction d'un collecteur de contraintes
function U_FUNCTION: constraint_collector_function(U_CONSTRAINT_COLLECTOR: c) = constraint_function[c];
% les paramètres d'un collecteur de contraintes
function set of PARAMETER: constraint_collector_parameters(U_CONSTRAINT_COLLECTOR: c) = function_parameters[c];
% le critère de regroupement d'un collecteur de portées
function U_TYPE: scope_collector_field(U_SCOPE_COLLECTOR: s) = scope_clustering[s];
% le masque d'un collecteur de portées
function array[MASK] of M_VALUE: scope_collector_mask(U_SCOPE_COLLECTOR: s) = array_2d_to_1d(scope_mask[s..s,MASK]);
% le type d'un filtre (de ses éléments)
function U_TYPE: filter_type(U_FILTER: f) = filter_type[f];
% les éléments résultant d'un filtre
function set of U_ELEMENT: filter_elements(U_FILTER: f) = filter_elements[f];
% la catégorie d'une U-fonction
function U_HARDNESS: u_function_type(U_FUNCTION: f) = function_type[f];
% la valeur d'un U-paramètre
function U_PARAMETER_VALUE: u_parameter_value(U_PARAMETER: p,U_PARAMETER2: k) = parameter_value[p,k];


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%% GENERATEUR DE U-CONTRAINTES
  
%% EVALUATION DE FILTRE : UNION D'ENSEMBLES DE QUARKS
% renvoie l'ensemble des quarks satisfaisant un filtre (ie. l'union des ensembles de quarks correspondant aux éléments du filtre)
function set of U_QUARK: eval_filter(U_FILTER: f) =
  array_union([element_quarks(filter_type(f),e) | e in filter_elements(f)]);

%% EVALUATION DE LISTE DE FILTRES : INTERSECTION D'ENSEMBLES DE QUARKS
% renvoie l'ensemble des quarks satisfaisant une liste de filtres (ie. l'intersection des ensembles de quarks satisfaisant chaque filtre)
function set of U_QUARK: eval_filter_list(U_SCOPE_COLLECTOR: s) =
  if scope_collector_filters(s)=={}
  then U_QUARK % pas de filtres -> le domaine de quarks
  else array_intersect([eval_filter(f) | f in scope_collector_filters(s)])
  endif;

%% EVALUATION DE MASQUE SUR ENSEMBLE DE QUARKS : GENERATION DU Q-QUARK LEX-MIN-MAX S'IL EXISTE, Q-QUARK NUL SINON
% calcule le q-quark lex-min-max de l'ensemble de quarks `V` masqué par le masque `mask`
% - s'il existe, renvoie le q-quark aligné
% - sinon renvoie le q-quark nul
function array[QUPLE] of Q_VALUE: eval_mask(set of U_QUARK: V, array[MASK] of M_VALUE: mask) =
  if null_mask(mask)
  then pad_tuple(set2array(V),length(QUPLE),qquark_padder)
  else eval_non_null_mask(V,mask)
  endif;
  
% calcule le q-quark lex-min-max de l'ensemble de quarks `V` masqué par le masque non-nul `mask`
% - s'il existe, renvoie le q-quark aligné
% - sinon renvoie le q-quark nul
function array[QUPLE] of Q_VALUE: eval_non_null_mask(set of U_QUARK: V, array[MASK] of M_VALUE: mask) =
  let {
  bool: checkarg1 = assert(not null_mask(mask),"mask is nul " ++ show(mask),true);
  bool: checkarg2 = assert(index_set(mask)==MASK,"mask has incorrect range " ++ show(index_set(mask)),true);
  bool: checkarg3 = assert(array2set(MASK) subset M_VALUE,"mask has incorrect rank values " ++ show(mask),true);
  bool: checkarg4 = assert(forall(i in 1..(card(MASK)-1))(mask[i]==mask_padder -> mask[i+1]==mask_padder),"mask is ill-formed '" ++ show(mask) ++ " (reserved padding symbol)",true);
  int: a0 = my_trace(u_lmask,"MASK EVALUATION");
  int: a1 = my_trace(u_lmask,"quarks to evaluate",V);
  int: a2 = my_trace(u_lmask,"mask",mask);
  array[int] of U_RANK: u_mask = unpad_tuple(mask,mask_padder); % unpadding du masque
  int: a3 = my_trace(u_lmask,"unpadded mask",u_mask);
  set of int: UM_SPAN = index_set(u_mask);
  int: a4 = my_trace(u_lmask,"range of unpadded mask ",UM_SPAN);
  int: UM_length = card(UM_SPAN);
  set of U_QUARK: ok_V = {v | v in V where exists(i in UM_SPAN)(quark_rank(v)==u_mask[i])}; % ensemble des quarks de rang compatible au masque
  int: a5 = my_trace(u_lmask,"mask-compatible quarks",ok_V);
  array[UM_SPAN] of set of U_QUARK: ranked_V = [ {v | v in ok_V where quark_rank(v)==u_mask[i]} | i in UM_SPAN]; % partition ordonnée par rang du masque des ensemble des quarks compatibles
  int: a6 = my_trace(u_lmask,"mask-ordered partition of compatible quarks",ranked_V);
  bool: modular = card(ranked_V[1])>0 /\ forall(i in 1.. UM_length-1)(card(ranked_V[i])==card(ranked_V[i+1])); % possibilité de modularisation
  int: a7 = my_trace(u_lmask,"modularity of partition",modular);
  array[int] of U_QUARK: u_qquark = [v | i in UM_SPAN, v in set2array(ranked_V[i])]; % q-quark lex-min-max
  int: a8 = my_trace(u_lmask,"linearised candidate lex-min-max q-quark",u_qquark);
  } in
  if modular==false
  then null_qquark()
  else pad_tuple(u_qquark,length(QUPLE),qquark_padder)
  endif;

% GENERATION DES Q-QUARKS LEX-MIN-MAX D'UN COLLECTEUR DE PORTEES
% calcule la liste des q-quarks lex-min-max du collecteur de portées `s`
% - échoue si la liste est vide
% - sinon renvoie le tableau des q-quarks alignés sur `QUPLE`
% -- en supprimant doublons et q-quarks sous-sommés (TODO check if justified) 
function array[int,QUPLE] of Q_VALUE: eval_single_scope_collector(U_SCOPE_COLLECTOR: s) =
  let {
  int: a0 = my_trace(u_lsingle_sc,"SINGLE SCOPE COLLECTOR EVALUATION");
  set of U_QUARK: f_quarks=eval_filter_list(s); % ensemble filtré des quarks du collecteur
  int: a1 = my_trace(u_lsingle_sc,"ensemble filtré de quarks",f_quarks);
  U_TYPE: E_TYPE = scope_collector_field(s); % type de regroupement du collecteur
  int: a2 = my_trace(u_lsingle_sc,"type de regroupement ",my_show("W",E_TYPE));
  set of U_ELEMENT: elts = elements(E_TYPE); % éléments de regroupement du collecteur
  int: a3 = my_trace(u_lsingle_sc,"éléments regroupants",elts);
  set of int: E_ID = 1..card(elts);
  int: a4 = my_trace(u_lsingle_sc,"plage normalisée des éléments regroupants",E_ID);
  array[E_ID] of U_ELEMENT: e_id = set2array(elts);
  int: a5 = my_trace(u_lsingle_sc,"réindexation des éléments regroupants",e_id);
  array[E_ID] of set of U_QUARK: e_quarks = [array_intersect([f_quarks,element_quarks(E_TYPE,e_id[i])]) | i in E_ID]; % ensemble des quarks compatibles (ie. filtrés et correspondants) de chaque élément
  int: a6 = my_trace(u_lsingle_sc,"ensemble de quarks filtrés par élément",e_quarks);
  set of E_ID: E_ID1 = E_ID diff array_union([{j | j in E_ID where j>i /\ e_quarks[e_id[j]]==e_quarks[e_id[i]]} | i in E_ID]); % suppression des éléments dont les ensembles de quarks sont déjà representés
  int: a7 = my_trace(u_lsingle_sc,"ensembles représentatifs",E_ID1);
  set of E_ID: E_ID2 = E_ID1 diff array_union([{j | j in E_ID1 where j>i /\ e_quarks[e_id[j]] subset e_quarks[e_id[i]]} | i in E_ID1]); % suppression des éléments dont les ensembles de quarks sont déjà couverts à gauche
  int: a8 = my_trace(u_lsingle_sc,"ensembles droite-subsumant",E_ID2);
  set of E_ID: E_ID3 = E_ID2 diff array_union([{j | j in E_ID2 where j<i /\ e_quarks[e_id[j]] subset e_quarks[e_id[i]]} | i in E_ID2]); % suppression des éléments dont les ensembles de quarks sont déjà couverts à droite
  int: a9 = my_trace(u_lsingle_sc,"ensembles gauche-subsumant",E_ID3);
  set of E_ID: E_ID4 = {i | i in E_ID3 where e_quarks[e_id[i]]!={}}; % suppression de l'ensemble de quarks vide s'il apparaît (-> seul ensemble du tableau dans ce cas -> vidage du tableau)
  bool: checkarg1 = assert(E_ID4!={},"!!! Scope collector is null" ++ show(s) ++ ". Amend filter list, clustering or mask.",true);
  int: a10 = my_trace(u_lsingle_sc,"ensembles non-vides",E_ID4);
  array[MASK] of M_VALUE: mask = scope_collector_mask(s);
  bool: success = (card(E_ID4)==1);
  array[int,QUPLE] of Q_VALUE: qquarks = eval_single_scope_collector_([e_quarks[e_id[i]] | i in E_ID4],mask,success);
  set of int: M = {i | i in index_set_1of2(qquarks) where null_qquark(array_2d_to_1d(qquarks[i..i,QUPLE]))==false};
  array[int,QUPLE] of Q_VALUE: ok_qquarks = array2d(1..card(M),QUPLE,[qquarks[i,j] | i in M, j in QUPLE]);
  int: a11 = my_trace(u_lsingle_sc,"Q-quarks du collecteur",ok_qquarks);
  } in
  ok_qquarks;

% calcule le q-quark lex-min-max, s'il existe, de chaque ensemble de q-quarks de la liste `quarks_sets_list` pour le masque `mask`
% - échoue si aucun n'existe
% - sinon renvoie le tableau des q-quarks lex-min-max alignés sur `QUPLE`
function array[int,QUPLE] of Q_VALUE: eval_single_scope_collector_(array[int] of set of U_QUARK: quarks_sets_list, array[MASK] of M_VALUE: mask, bool: success) =
  let {
  int: a0 = my_trace(u_lsingle_sc,"Masque" ,my_show("M",mask,true));
  int: a1 = my_trace(u_lsingle_sc,"liste d'ensembles de quarks à masquer",quarks_sets_list);
  bool: checkarg1 = assert(length(quarks_sets_list)>0,"empty list " ++ show(quarks_sets_list),true);
  set of U_ELEMENT: E = index_set(quarks_sets_list);
  int: a2 = my_trace(u_lsingle_sc,"plage d'indexation des ensembles",E);
  U_ELEMENT: e1 = min(E);
  set of U_ELEMENT: E2 = E diff {e1};
  bool: checkarg2 = assert(card(quarks_sets_list[e1])>0,"first set of q-quarks is empty" ++ show(quarks_sets_list),true);
  array[QUPLE] of Q_VALUE: quark1 = eval_mask(quarks_sets_list[e1],mask); % q-quark lex-min-max du premier ensemble ou q-quark nul
  int: a3 = my_trace(u_lsingle_sc,"qq-lmm",quark1);
  %array[int] of T_VALUE: tquark1 = tuplify(quark1,qquark_padder,tquark_delimiter); % délimitation du q-quark ou tuple vide sinon
  } in
  if length(quarks_sets_list)==1 /\ success==false
  then assert(false,"No compatible scope for collector. Review your scope collector definition.",array_1d_to_2d(null_qquark()))
  elseif length(quarks_sets_list)==1
  then array2d(e1..e1,QUPLE,quark1)
  else array2d(E,QUPLE,quark1 ++ array_2d_to_1d(eval_single_scope_collector_(quarks_sets_list[E2],mask,true)))
  endif;

% GENERATION DES T-QUARKS D'UNE LISTE DE COLLECTEURS DE PORTEES
% calcule le produit cartésien des ensembles de q-quarks collectés par les collecteurs de la liste `s_list`
% - échoue si un ensemble est vide
% - sinon renvoie l'ensemble de t-quarks résultants sous forme de tableau modulaire de q-quarks
function array[int,QUPLE] of Q_VALUE: eval_multiple_scope_collector(array[int] of U_SCOPE_COLLECTOR: s_list) =
  let {
  int: a0 = my_trace(u_lmultiple_sc,"MULTIPLE SCOPE COLLECTOR EVALUATION ");
  set of int: SLIST = index_set(s_list); % plage d'indexation des ensembles de q-quarks sur lesquels s'effectuera le produit
  int: arity = length(s_list); % arité des t-quarks du produit
  bool: checkarg1 = assert(arity>1,"list has less than 2 scope collectors" ++ show(s_list),true);
  bool: checkarg2 = assert(SLIST=1..arity,"indexing set of scope collectors list is not a range" ++ show(s_list),true);
  array[SLIST] of int: cardinalities = [ card(index_set_1of2(eval_single_scope_collector(s_list[s]))) | s in SLIST]; % cardinalité des ensembles de q-quarks collectés
  int: a1 = my_trace(u_lmultiple_sc,"cardinalités des ensembles de q-quarks (arité du collecteur de U-contraintes)",cardinalities);
  bool: checkarg3 = assert(product(cardinalities)!=0,"one of the scope collectors is nul :" ++ show(cardinalities),true);
  int: np = product(cardinalities); % nombre total de t-quarks à calculer (taille du produit cartésien)
  int: a2 = my_trace(u_lmultiple_sc,"nombre de t-quarks",np);
  int: nt = sum(cardinalities); % sommes des cardinalités des ensembles
%  array[1..nt,QUPLE] of Q_VALUE: quarks = array2d(1..nt,QUPLE,[qquarks[i,j] | s in SLIST, qquarks=eval_single_scope_collector(s_list[s]), i in index_set_1of2(qquarks), j in QUPLE]);
  array[1..nt,QUPLE] of Q_VALUE: quarks = eval_scope_collectors(s_list);
  int: a3 = my_trace(u_lmultiple_sc,"ensemble d'ensembles de q-quarks (tableau)" ,show(quarks) ++ "  de cardinalités " ++ show(cardinalities));
  int: a4 = my_trace(u_lmultiple_sc,"taille du tableau modulaire de q-quarks",nt);
  } in
  cartesian_product(quarks,cardinalities);

%
function array[int,QUPLE] of Q_VALUE: eval_scope_collectors(array[int] of U_SCOPE_COLLECTOR: s_list) =
  let {
  set of int: SLIST = index_set(s_list);
  int: s1 = min(SLIST);
  set of int: SLIST2 = SLIST diff {s1};
  } in
  if length(s_list)==2
  then stack_arrays(eval_single_scope_collector(s_list[s1]),eval_single_scope_collector(s_list[min(SLIST2)]))
  else stack_arrays(eval_single_scope_collector(s_list[s1]),eval_scope_collectors(s_list[SLIST2]))
  endif;  


% GENERATION DES Q-QUARKS OU T-QUARKS D'UN COLLECTEUR DE CONTRAINTES SELON L'ARITE DE SA LISTE DE COLLECTEURS DE PORTEES
% - si `c` a un unique collecteur de portées, calcule s'il existe l'ensemble des q-quarks lex-min-max sinon échoue
% - sinon, calcule s'il existe le produit cartésien des ensembles des q-quarks lex-min-max des collecteurs de portées, sinon échoue
% -- Dans les deux cas, renvoie un tableau de q-quarks alignés
function array[int,QUPLE] of Q_VALUE: generate_tquarks(U_CONSTRAINT_COLLECTOR: c) =
  let {
  bool: checkarg1 = assert(length(constraint_collector_scopes(c))!=0,"empty scope collector for constraint collector " ++ my_show("CC",c),true);
  } in 
  if length(constraint_collector_scopes(c))==1
  then eval_single_scope_collector(constraint_collector_scopes(c)[1]) % 1 seul collecteur
  else eval_multiple_scope_collector(constraint_collector_scopes(c)) % plusieurs collecteurs
  endif;


%
function bool: check_constraint_collector(U_CONSTRAINT_COLLECTOR: c) =
  let {
  U_FUNCTION: f = constraint_collector_function(c);
  int: a1 = my_trace(u_lcc,"function" ,my_show("F",f));
  U_HARDNESS: h = u_function_type(f);
  int: a2 = my_trace(u_lcc,"hardness " ,my_show("H",h));
  int: a = if length(constraint_collector_scopes(c))>=2 then 2 else 1 endif;
  int: a3 = my_trace(u_lcc,"arity " ,my_show("A",a));
  set of U_ARITY_TYPE: f_arities = u_function_arities[f];
  } in
  a in  f_arities; % TODO /\ h in f_types /\  parameters (number/types) ...

%%% GENERATION DES CONTRAINTES INDUITE PAR UN COLLECTEUR DE U-CONTRAINTES
%% GENERATION DES U-CONTRAINTES DE CHAQUE COLLECTEUR DE U-CONTRAINTES
% génère, pour chaque collecteur de U-contraintes, la conjonction de U-contraintes qui associe chacune à sa U-fonction l'un des t-quarks générés par son collecteur de portées
constraint
forall(c in U_CONSTRAINT_COLLECTOR)(
  let {
  int: a0 = my_trace(u_lcc,"**************************************");
  int: a1 = my_trace(u_lcc,"CONSTRAINT COLLECTOR");
  int: a11 = my_trace(u_lcc,my_show("CC",c));
  U_FUNCTION: f = constraint_collector_function(c); % fonction du CC
  int: a2 = my_trace(u_lcc,my_show("F",f));
  U_HARDNESS: h = u_function_type(f); % type de la fonction du CC
  int: a3 = my_trace(u_lcc,my_show("H",h));
  U_ARITY: a = length(constraint_collector_scopes(c));%if length(constraint_collector_scopes(c))>=2 then 2 else 1 endif; % arité du CC
  int: a4 = my_trace(u_lcc,my_show("A",a));
  bool: checkarg0 = assert(check_constraint_collector(c),"number of scope collectors is inconsistent with arity of function of constraint collector " ++ show(c),true);
  array[int,QUPLE] of Q_VALUE: quarksList = generate_tquarks(c); % portées de quarks, d'arités égales, sous forme de t-quark
  int: a5 = my_trace(u_lcc,"q-quarks lex-min-max collectés",quarksList);
  set of int: QL = index_set_1of2(quarksList);
  int: nt = card(QL); % nombre de quarks
  bool: checkarg1 = assert(QL!={},"no q-quark in " ++ show(quarksList),true);
  bool: checkarg2 = assert(QL=1..nt,"indexing set of q-quarks list is not a range " ++ show(QL),true);
  bool: checkarg3 = assert(not null_qquark_in_list(quarksList),"null q-quark in list " ++ show(quarksList),true);
%  bool: checkarg4 = assert(nt mod a == 0,"q-quark array is not modular wrt. constraint collector's function arity " ++ show(quarksList),true);
  int: ns = nt div a; % nombre de portées de quarks (= nombre de U-contraintes à poser)
  %set of int: QS = 1..ns; % plage des portées
  int: a6 = my_trace(u_luconstraint,"plage du nombre de quarks",nt);
  set of int: QS = 1..ns; % plage des portées
  array[QS] of set of QL: scopes = [ { i | i in QL where (k-1)*a<i /\ i<=k*a } | k in QS];
  array[int] of U_PARAMETER_VALUE: parameters = constraint_collector_parameters(c);
  } in
  forall(s in QS)(
    u_constraint(f,h,a,quarksList[scopes[s],QUPLE],parameters))
  );

%% POSE D'UNE U-CONTRAINTE
%
predicate u_constraint(U_FUNCTION: f, U_HARDNESS: h, U_ARITY: a, array[int,QUPLE] of Q_VALUE: qquarks, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_luconstraint,"Pose de U-contrainte");
  bool: checkarg1 = assert(a==card(index_set_1of2(qquarks)),"inconsistent arity and scope " ++ show(qquarks),true);
  set of int: Q = index_set_1of2(qquarks);
  int: a1 = my_trace(u_luconstraint,"plage d'indexation des q-quarks",Q);
  int: q1 = min(Q);
  set of int: Q2 = Q diff {q1};
  int: a2 = my_trace(u_luconstraint,"q-quarks",qquarks);
  array[int] of Q_VALUE: qquark1 = unpad_quple(qquarks[q1..q1,QUPLE]);
  } in
  %% arity 1
  if       a==u_arity_1 /\ f==same_rooms
  then  same_rooms(h,qquark1,parameters)
  elseif a==u_arity_1 /\ f==same_slots
  then  same_slots(h,qquark1,parameters)
  elseif a==u_arity_1 /\ f==same_teachers
  then  same_teachers(h,qquark1,parameters)
  elseif a==u_arity_1 /\ f==same_week
  then  same_week(h,qquark1,parameters)
  elseif a==u_arity_1 /\ f==sequenced
  then  sequenced(h,qquark1,parameters)
  elseif a==u_arity_1 /\ f==weekly
  then  weekly(h,qquark1,parameters)
  elseif a==u_arity_1 /\ f==teacher_repartition
  then  teacher_repartition(h,qquark1,parameters)
    elseif a==u_arity_1 /\ f==forbidden_slots
  then  forbidden_slots(h,qquark1,parameters)
      elseif a==u_arity_1 /\ f==not_consecutive_rooms
  then  not_consecutive_rooms(h,qquark1,parameters)
      elseif a==u_arity_1 /\ f==connected_rooms
  then  connected_rooms(h,qquark1,parameters)
      elseif a==u_arity_1 /\ f==at_most_daily
  then  at_most_daily(h,qquark1,parameters)
      elseif a==u_arity_1 /\ f==allocate_slot
  then  allocate_slot(h,qquark1,parameters)

  %% arity > 1 
  elseif f==same_rooms
  then  same_rooms(h,qquarks,parameters)
  elseif f==same_slots
  then  same_slots(h,qquarks,parameters)
  elseif f==same_teachers
  then  same_teachers(h,qquarks,parameters)
  elseif f==same_week
  then  same_week(h,qquarks,parameters)
  elseif f==sequenced
  then  sequenced(h,qquarks,parameters)
  elseif f==weekly
  then  weekly(h,qquarks,parameters)
   elseif f==teacher_repartition
  then  teacher_repartition(h,qquarks,parameters)
  elseif f==forbidden_slots
  then  forbidden_slots(h,qquarks,parameters)
    elseif f==not_consecutive_rooms
  then  not_consecutive_rooms(h,qquarks,parameters)
    elseif f==connected_rooms
  then  connected_rooms(h,qquarks,parameters)
    elseif f==at_most_daily
  then  at_most_daily(h,qquarks,parameters)
    elseif f==allocate_slot
  then  allocate_slot(h,qquarks,parameters)
  else trace("BUG: did not capture/implement expected U-function name",false) 
  endif;
