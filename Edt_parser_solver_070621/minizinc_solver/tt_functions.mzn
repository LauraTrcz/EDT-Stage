%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% FONCTIONS (MONO-VALUEES OU MULITVALUEES) INSTANCE DEPENDANTES
%% RECIPROQUES DE FONCTIONS (LES TABLEAUX) SOURCES
%% CORRESPONDANCES ENTRE ENTITES
%% FONCTIONS IMPLEMENTANT L'API GENERATIVE


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%% MODELE D'INSTANCES UTT
%%%%%
%%% ELEMENTS UTT : TYPES ET VALEURS
%%% Les types d'éléments sont :
%%% - les équipements (`utt_equipment`)
%%% - les salles (`utt_room`)
%%% - les enseignants (`utt_teacher`)
%%% - les groupes d'étudiants (`utt_group`)
%%% - les cours (`utt_courses`)
%%% - les parties de cours (`utt_part`)
%%% - les classes (`utt_class`)
%%% - les séances (`utt_session}
%%% - les formations (`utt_course`)
%%%
%%% NB. Le type "formations" est un type singleton qui regroupe l'ensemble des séances.
%%%
%%% Les éléments de chaque type sont numérotés consécutivement en démarrant à 1, déterminant ainsi une plage d'identifiants par type (eg. `1..nr_sessions` pour les séances).
%%%
%%% L'ensemble des différents types d'éléments forme un type abstrait dénoté `UTT_TYPE`.
%%% L'union des plages d'identifiants des différents types d'éléments forme un type abstrait dénoté `UTT_ELEMENT`.
%%%
%%%
%%%%%
%%% CORRESPONDANCES ENTRE SEANCES ET ELEMENTS
%%% Différentes correspondances relient séances et autres éléments : 
%%% - une séance se correspond (bijection).
%%% - une séance appartient à une unique classe (surjection)
%%% - une séance appartient à une unique partie, celle de sa classe (surjection)
%%% - une séance appartient à un unique cours, celui de sa partie (surjection)
%%% - une séance appartient à la formation (surjection)
%%% - une séance est associée à l'ensemble, potentiellement vide, des équipements requis par sa partie (multifonction quelconque)
%%% - une séance est associée à l'ensemble, potentiellement vide, des salles requises par sa partie (multifonction quelconque)
%%% - une séance est associée à l'ensemble, potentiellement vide, des enseignants requis par sa partie (multifonction quelconque).
%%% - une séance est associée à l'ensemble non-vide des groupes attribués à sa classe (multifonction quelconque).
%%%
%%% Toutes ces correspondances ont une réciproque (les fonctions sont supposées surjectives).
%%%
%%% On dira d'une séance et d'un élément donné qu'ils se *correspondent* si l'un est image ou appartient à l'image de l'autre pour la fonction/multifonction associée au type de l'élément).
%%%
%%%
%%%%%
%%% NUMEROTATION ET RANG DES SEANCES
%%% Le schéma de numérotation des cours, parties, classes et séances suit l'organisation hiérarchique des cours :
%%% - les séances d'un cours, d'une partie ou d'une classe forment une plage
%%% - les plages de séances de deux cours consécutifs, de deux parties consécutives ou de deux classes consécutives sont consécutives.
%%%
%%% Le *rang d'une séance* désigne le rang de son numéro dans la liste des numéros des séances de sa classe (rang 1 par convention pour la première séance d'une liste).
%%% L'ensemble des rangs de séances forme une plage d'entiers dénotée `PART_SESSION`.
%%%
%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%% FONCTIONS RECIPROQUES
% réciproque de `course_parts`
function COURSE: part_course(PART: p) = 
  min(c in COURSE where p in course_parts[c])(c);

% réciproque de `part_classes`
function PART: class_part(CLASS: c) =
  min(p in PART where c in part_classes[p])(p);
  
% réciproque de `part_equipments`
function set of PART: equipment_parts(EQUIPMENT: e) =
  {p | p in PART where e in part_equipments[p]};

% réciproque de `part_rooms`
function set of PART: room_parts(ROOM: r) =
  {p | p in PART where r in part_rooms[p]};

% réciproque de `part_teachers`
function set of PART: teacher_parts(TEACHER: t) =
  {p | p in PART where t in part_teachers[p]};

% réciproque de `class_groups`
function set of CLASS: group_classes(GROUP: g) =
  {c | c in CLASS where g in class_groups[c]};
  

%réciproque de `part_sessions`
function int: session_part(SESSION:s)=
class_part(session_class(s))
;


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%% FONCTIONS DE NUMEROTATION ET RANGEMENT DES SEANCES
% fonction récursive renvoyant les séances d'un cours
% !! les cours sous-divisent la plage des séances en sous-plages consécutives
function set of SESSION: course_sessions(COURSE: c) =
  let {
    SESSIONS: s = sum(p in course_parts[c])(card(part_classes[p])*part_nr_sessions[p]); % nombre de séances du cours
  } in
  if c==1
  then 1..s % plage de séances du premier cours
  else max(course_sessions(c-1))+1..max(course_sessions(c-1))+s % plage de séances du c-ième cours
  endif;

% fonction récursive renvoyant les séances d'une partie
% !! les parties sous-divisent la plage des séances de leur cours en sous-plages consécutives
function set of SESSION: part_sessions(PART: p) =
  let {
    COURSE: c = part_course(p); % cours de la partie
    SESSIONS: s = card(part_classes[p])*part_nr_sessions[p]; % nombre de séances de la partie
    SESSIONS: n = sum(q in course_parts[c] where q<p)(card(part_classes[q])*part_nr_sessions[q]); % nombre de séances des parties jumelles précédentes
  } in
  if c==1
  then n+1..n+s
  else max(course_sessions(c-1))+n+1..max(course_sessions(c-1))+n+s
  endif;

% fonction récursive renvoyant les séances d'une classe
% !! les classes sous-divisent la plage des séances de leur partie en sous-plages consécutives
function set of SESSION: class_sessions(CLASS: c) =
  let {
    %int: a1 = trace("\n CLASS c = " ++ show(c),1);
    PART: p = class_part(c); % partie de la classe
    SESSIONS: s = part_nr_sessions[p]; % nombre de séances de la classe
    SESSIONS: n = sum(d in part_classes[p] where d<c)(part_nr_sessions[p]); % nombre de séances des classes précédentes de la partie
  } in
  if p==1
  then n+1..n+s
  else max(part_sessions(p-1))+n+1..max(part_sessions(p-1))+n+s % plage de séances de la c-ième classe
  endif;
  
% renvoie la classe d'une séance
function CLASS: session_class(SESSION: s) =
  min({c | c in CLASS where s in class_sessions(c)}); %TODO pas optimal


% renvoie le rang d'une séance
function SESSION_RANK: session_rank(SESSION: s) = 
  s-min(class_sessions(session_class(s)))+1;

% renvoie les séances d'un équipement, ie. l'union des ensembles de séances des parties requérant l'équipement
function set of SESSION: equipment_sessions(EQUIPMENT: e) =
  array_union([part_sessions(p) | p in equipment_parts(e)]);

% renvoie les séances d'une salle, ie. l'union des ensembles de séances des parties requérant la salle
function set of SESSION: room_sessions(ROOM: r) =
  array_union([part_sessions(p) | p in room_parts(r)]);

% renvoie les séances d'un enseignant, ie. l'union des ensembles de séances des parties requérant l'enseignant
function set of SESSION: teacher_sessions(TEACHER: t) =
  array_union([part_sessions(p) | p in teacher_parts(t)]);

% renvoie les séances d'un groupe, ie. l'union des ensembles de séances des classes requérant le groupe
function set of SESSION: group_sessions(GROUP: g) =
  array_union([class_sessions(c) | c in group_classes(g)]);


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%% FONCTIONS IMPLEMENTANT L'API GENERATIVE
% renvoie l'ensemble d'éléments d'un type
function set of UTT_ELEMENT: utt_elements(int: t) = %TODO recheck UTT_TYPE: t) =
  if t==utt_equipment then EQUIPMENT
  elseif t==utt_room then ROOM
  elseif t==utt_teacher then TEACHER
  elseif t==utt_group then GROUP
  elseif t==utt_courses then 1..1 % !! plage non réifiée (élément racine)
  elseif t==utt_course then COURSE
  elseif t==utt_part then PART
  elseif t==utt_class then CLASS
  else SESSION
  endif;
  
% renvoie les séances d'un élément selon son identifiant et son type
%% renvoie la séance en entrée (singleton) si le type est `utt_session`
%% renvoie la plage des séances si le type est `utt_courses`
function set of SESSIONS: utt_element_sessions(int: t, int: e) = %TODO recheck UTT_TYPE: t, UTT_ELEMENT: e) = 
  if t==utt_equipment then equipment_sessions(e)
  elseif t==utt_room then room_sessions(e)
  elseif t==utt_teacher then teacher_sessions(e)
  elseif t==utt_group then group_sessions(e)
  elseif t==utt_courses then SESSION % plage des séances
  elseif t==utt_course then course_sessions(e)
  elseif t==utt_part then part_sessions(e)
  elseif t==utt_class then class_sessions(e)
  else {e}
  endif;
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
  
%Toujours pas une réciproque

%réciproque de `truc`
function int: session_length(SESSION:s)=
part_length[min(p in PART where s in part_sessions(p))(p)]
;
%search parameter name
function U_PARAMETER_VALUE:search_value_name(array[int] of int: numero,string :name)=
let{
array[int] of int: tab_of_value=[if (parameter_name[numero[i]] == name)then numero[i] else -1 endif | i in index_set(numero)];
}
in
max(tab_of_value)
;
%récupère sur le nombre de sessions global le numéro de session local
function int: position_session_class(SESSIONS: s)=
let{
  int: class_of_s = session_class(s);
  int: pos_min = sum(i in 2..class_of_s)(part_nr_sessions[class_part(i-1)]);
}in
pos_min
;