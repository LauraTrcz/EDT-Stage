include "all_different.mzn";
include "all_equal.mzn";
include "arg_max.mzn";
include "disjunctive.mzn";
include "cumulative.mzn";


%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% PREDICATS

%%% UTILITAIRES
%% PREDICATS UTT
/*
% Weekly
predicate weekly(array[int] of SESSION: cs_ens) = 
forall(i,j in cs_ens where i!=j /\ i<j)(x_slot[i] mod (nr_weekly_slots+1) == x_slot[j] mod (nr_weekly_slots+1));
%sameweek
predicate same_week(array[int] of SESSION: session_tab) = 
forall(i,j in index_set(session_tab) where i<j)(x_slot[session_tab[i]] div nr_weekly_slots == x_slot[session_tab[j]] div nr_weekly_slots)
;
%precedence

predicate sequenced(array[int] of SESSION: session_tab)=
forall(i,j in index_set(session_tab) where i<j)(x_slot[session_tab[i]]<=x_slot[session_tab[j]])
;
%same_teachers
predicate same_teachers(array[int] of CLASS: classes_use)= 
let{
array[int] of set of TEACHER:class_teachers = [part_teachers[class_part(classes_use[u])]| u in index_set(classes_use)] ;
}in forall(c1,c2 in index_set(classes_use) where c1<c2)(class_teachers[classes_use[c1]] == class_teachers[classes_use[c2]]) ;
%same_slot
predicate same_slot(array[int] of SESSION: session_slot)= 
forall(i,j in index_set(session_slot) where i<j)(x_slot[session_slot[i]]== x_slot[session_slot[j]])
;
predicate same_room(array[int] of SESSION:sessions)=
forall(s1,s2 in index_set(sessions) where s1<s2)(x_rooms[session_class(sessions[s1])] == x_rooms[session_class(sessions[s2])])
;
*/

%CONTRAINTE


%ROOM
%VALEUR DE ROOM POSSIBLE
predicate class_room_autorized()=
let{
   array[CLASS] of set of ROOM: class_room = [part_rooms[class_part(ci)]|ci in CLASS];
}
in forall(c in CLASS)(x_rooms[c] subset class_room[c])
;

%% COUPLAGE SALLE POUR GROUPE ET SALLE POUR CLASSE
% (c-*-1) [dure] %TODO
predicate room_assignement()=
forall(r in ROOM)(
  disjunctive(
    [x_slot[s]|s in room_sessions(r) ],
    [session_length(s)*bool2int(r in x_rooms[session_class(s)])|s in room_sessions(r)]
    %[bool2int(r in x_rooms[session_class(s)])*session_length(s)|s in room_sessions(r)]
  )
)
;

%% ALLOCATION DE SALLES (CLASSES SANS SALLES, MONO-SALLE, OU MULTI-SALLES)
% (c-r-1) [dure] Une classe doit être placée dans un nombre de salles conforme à son type.
predicate allocation_room_option()=
forall(c in CLASS)(
  ((part_room_use[class_part(c)]==none) <-> (x_rooms[c] == {}))
  /\
  ((part_room_use[class_part(c)]==single) -> (card(x_rooms[c]) == 1))
  /\
  ((part_room_use[class_part(c)]==multiple) -> (card(x_rooms[c])>=1))
)
;

%TEACHER

%Teacher assignment

%% UTILISATION D'ENSEIGNANTS
% (c-t-1) [dure] Les sessions des classes placées affectée à un enseignant non-ubiquitaire doivent être séquencées en dehors des plages interdites pour l'enseignant.%TODO PLAGE INTERDITE

predicate teacher_assignement()=
forall(t in TEACHER  )(
  disjunctive(
    [x_slot[s]         | s in teacher_sessions(t)], % [2,35,68]
    [session_length(s)*bool2int(t in x_teachers[session_class(s)]) | s in teacher_sessions(t)]
    %[bool2int(t in x_teachers[session_class(s)])*session_length(s) | s in teacher_sessions(t)]%++Cas des forbidden slot
    )
)
;
%% ALLOCATION DES ENSEIGNANTS (CLASSES SANS PROF, MONO-PROF, OU MULTI-PROF)
% (c-r-1) [dure] Une classe doit être placée avec un nombre d'enseignats conforme à son type.
/*predicate allocation_teacher_option()=
forall(c in CLASS)(
  ((part_teacher_use[class_part(c)]==none) <-> (x_teachers[c] == {}))
  \/
  ((part_teacher_use[class_part(c)]==single) -> (card(x_teachers[c]) ==1))
  \/
  ((part_teacher_use[class_part(c)]==multiple) -> (card(x_teachers[c])>=1))
)
;*/

%VALEUR DE TEACHER POSSIBLE
predicate teacher_consomation()=
forall(s in SESSION)(
  x_teachers[s] subset part_teachers[session_part(s)] 
)
;

%VERIFICATION DE LA FEUILLE DE SERVICE
%Function de vérification
function int:position_teacher(int:t,set of int:soi,int :posit)=
let{
array[int]of int:tab=set2array(soi);
int :soi_min = min(soi);
set of int :soip = array2set([tab[i]|i in index_set(tab) where tab[i]!=soi_min]);
}
in
if t == soi_min then
posit
else
position_teacher(t,soip,posit+1)
endif
;
/*
predicate reparition_teacher()=
let {
array[int] of PART_TEACHER:part_partteacher=[1]++[card(part_teachers[i-1])+i-1+bool2int({}==part_teachers[i-1])|i in 2..nr_parts];
}
in
forall(t in TEACHER)(
  forall(p in teacher_parts(t))(
    sum(c in part_classes[p])(bool2int(t in x_teachers[c]))<=part_teacher_class_bound[(part_partteacher[p]+position_teacher(t,part_teachers[p],0)),max_resource_bound]
    /\
       sum(c in part_classes[p])(bool2int(t in x_teachers[c]))>=part_teacher_class_bound[part_partteacher[p]+position_teacher(t,part_teachers[p],0),min_resource_bound]
  )
)
;*/

%EQUIPEMENT

%% CONSOMMATION D'EQUIPEMENTS
% (c-e-1) [dure] Un équipement doit avoir la capacité suffisante pour satisfaire aux demandes cumulées des sessions des parties les exigeant.
predicate equipment_assignement()=
/*let {
array[int] of PART_EQUIPMENT:part_partequipement=[1]++[card(part_equipments[i-1])+i-1+bool2int({}==part_equipments[i-1])|i in 2..nr_parts];
}
in*/
forall(e in EQUIPMENT)(  
let{
array[int] of PART_EQUIPMENT:part_partequipement=[1]++[card(part_equipments[i-1])+i-1+bool2int({}==part_equipments[i-1])|i in 2..nr_parts];
int:limit_e = equipment_count[e];
}in
  cumulative(
    [x_slot[s]                         | s in equipment_sessions(e)],%++ equipment_fs_starts
    [session_length(s)                 |s in equipment_sessions(e)],
    [part_equipment_count[position_teacher(e,part_equipments[session_part(s)],0)+part_partequipement[session_part(s)]]|s in equipment_sessions(e)],
    limit_e
  )
)
;

%GROUPE
% un group ne peut avoir qu'une seul seance par creneau
predicate group_disjonctive()=
forall(g in GROUP)(
  disjunctive(
    [x_slot[s]                |s in group_sessions(g)],
    [session_length(s)        |s in group_sessions(g)]
  )
)
;

%==============tmp

%% U-FONCTIONS
% domaine virtualisé des séances incluant padder pour alignement de tuples de séances
set of int: SESSION_V = SESSION union {qquark_padder};

include "tt_predicate_weekly.mzn";
include "tt_predicate_sequenced.mzn";
include "tt_predicate_teacher_repartition.mzn";
include "tt_predicate_same_week.mzn";
include "tt_predicate_allocat_slot.mzn";
include "tt_predicate_at_most_daily.mzn";
include "tt_predicate_connected_rooms.mzn";
include "tt_predicate_same_rooms.mzn";
include "tt_predicate_same_slots.mzn";
include "tt_predicate_same_teachers.mzn";
include "tt_predicate_not_consecutive_rooms.mzn";
include "tt_predicate_forbidden_slots.mzn";








 

 
 
 




