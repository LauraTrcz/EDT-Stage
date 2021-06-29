%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% TYPES, DIMENSIONS ET ELEMENTS (PLAGES/ENUMERATIONS/CONSTANTES)

%% TYPES, DIMENSIONS ET ELEMENTS UTT (ENUMERATIONS/PLAGES/CONSTANTES INSTANCES INDEPENDANTES)
% les types d'éléments ou pseudo-éléments UTT servant à générer les portées de contraintes
enum UTT_TYPE = {utt_equipment,utt_room,utt_teacher,utt_group,utt_courses,utt_course,utt_part,utt_class,utt_session};
array[UTT_TYPE] of string: utt_type_name = ["utt_equipment","utt_room","utt_teacher","utt_group","utt_courses","utt_course","utt_part","utt_class","utt_session"];
% les politiques d'allocation pour un pool de ressources unitaires (salles, enseignants)
enum UTT_RESSOURCE_USE = {none,single,multiple,all,star};%TODO any : reserved MZN keyword?
array[UTT_RESSOURCE_USE] of string: utt_resource_use_name = ["none","single","multiple","all","star"];
% les deux seuils d'allocation propres à chaque ressource unitaire dans un pool
enum UTT_RESOURCE_BOUND = {min_resource_bound,max_resource_bound};
array[UTT_RESOURCE_BOUND] of string: utt_resource_bound_name = ["min_resource_bound","max_resource_bound"];
% les noms des fonctions de contraintes UTT
enum UTT_FUNCTION = {same_rooms,same_slots,same_teachers,same_week,sequenced,weekly,teacher_repartition,forbidden_slots,not_consecutive_rooms,connected_rooms,at_most_daily,allocate_slot};%TODO ITC functions : same_start, same_time, same_days, same_weeks, same_room, different_time, different_days, different_weeks, different_room, overlap, same_attendees, precedence, work_day, min_gap, not_overlap, max_days, max_day_load, max_breaks, max_block};
array[UTT_FUNCTION] of string: utt_function_name = ["same_rooms","same_slots","same_teachers","same_week","sequenced","weekly","teacher_repartition","forbidden_slots","not_consecutive_rooms","connected_rooms","at_most_daily","allocate_slot"];%TODO
% les catégories de contraintes UTT
enum UTT_HARDNESS = {utt_hard,utt_soft};
array[UTT_HARDNESS] of string: utt_hardness_name = ["utt_hard","utt_soft"];
% les valeurs possibles de paramètres de contraintes UTT

enum  UTT_PARAMETER_SPECIAL = {utt_single,utt_halfhalf};
set of int: UTT_PARAMETER = -1000000..100000 union UTT_PARAMETER_SPECIAL;%TODO ideally min(int)+1..max(int)
% TODO les critères de coût UTT
enum UTT_CRITERION = {k_time,k_equipment,k_room,k_teacher,k_group};
array[UTT_CRITERION] of string: utt_criterion_name = ["k_time","k_equipment","k_room","k_teacher","k_group"];

%%% ELEMENTS VIRTUELS (CONSTANTES INSTANCES INDEPENDANTES)
%%%% On ajoute à certaines classes/types un *élément nul* modélisant une valeur fictive afin de réifier l'absence ou l'optionalité de représentation.
%%%% NB : la valeur adoptée peut simplifier - ou non ! - l'expression de contraintes
% salle fictive allouée à une séance n'exigeant aucune salle
int: cst_null_room = 0;
% enseignant fictif affecté à une séance n'exigeant aucun enseignant
int: cst_null_teacher = 0;
% rang fictif de séance
int: cst_null_session_rank = 0;
% capacité illimitée de salle
int: cst_null_room_capacity = -1;
% capacité illimitée d'équipement
int: cst_null_equipment_capacity = -1;
% demande fictive de partie en équipements
int: cst_null_equipment_demand = -1;
% borne fictive en nombre de classes pour salles/enseignants
int: cst_null_bound = -1;


%% TYPES D'ELEMENTS (PLAGES INSTANCES DEPENDANTES)
%%% !!! 1 identifie toujours le premier élément
set of int: WEEK = 1..nr_weeks;
set of int: WEEKDAY = 1..nr_days_per_week;
set of int: DAYSLOT = 1..nr_slots_per_day;

set of int: EQUIPMENT = 1..nr_equipments; 
set of int: ROOM = 1..nr_rooms;
set of int: TEACHER = 1..nr_teachers; 
set of int: GROUP = 1..nr_groups;
set of int: COURSE = 1..nr_courses;
set of int: PART = 1..nr_parts;
set of int: CLASS = 1..nr_classes;
set of int: CONSTRAINT = 1..nr_constraints;
set of int: LABEL = 1..nr_labels;

set of int: PART_EQUIPMENT = 1..nr_part_equipments; 
set of int: PART_ROOM = 1..nr_part_rooms; 
set of int: PART_TEACHER = 1..nr_part_teachers; 
set of int: SCOPE = 1..nr_scopes;
set of int: FILTER = 1..nr_filters;
set of int: PARAMETER = 1..nr_parameters;
set of int: PART_ROOM_MANDATORY=1..nr_part_room_mandatory;
set of int: PART_SESSIONS_TEACHER=1..nr_part_sessions_teacher;

%% TYPES D'ELEMENTS AUXILIAIRES (PLAGES INSTANCES DEPENDANTES)
% créneau de l'horizon
set of int: SLOT = 1..nr_slots;
% les séances
set of int: SESSION = 1..nr_sessions;
% les rangs de séances
set of int: SESSION_RANK = 1..max_session_rank;
%les rangs des parametres
set of int: ELEMENT_PARAMETER = 1..max_element_parameter;

% identifiant d'élément UTT
% NB. COURSES, COURSE, PART, CLASS redondants : COURSES omis car non-défini (inutile)
set of int: UTT_ELEMENT = 1..max(array_union([EQUIPMENT,ROOM,TEACHER,GROUP,COURSE,PART,CLASS,SESSION]));


%% DIMENSIONS AUXILIAIRES (PLAGES INSTANCES DEPENDANTES)
% créneau hebdomadaire
set of int: WEEKLY_SLOT = 1..nr_weekly_slots;
% capacité d'équipement-type en appoint de séances mesurée, par convention, en nombre d'équipements
set of int: E_COUNT = 0..max_equipment_count;
% capacité de salle en hébergement de séance mesurée, par convention, en nombre d'étudiants
set of int: R_CAPACITY = 0..max_room_capacity;
% capacité d'enseignant en encadrement de séance mesurée, par convention, en nombre d'étudiants
%set of int: T_CAPACITY = 0..max_teacher_capacity;
% taille de groupe
set of int: G_HEADCOUNT = 0..max_group_size;
% demande de séance mesurée en nombre d'équipements par équipement-type
set of int: PE_DEMAND = 0..max_part_equipment_count;
% demande de partie en nombre de classes par salle
set of int: PRC_DEMAND = 0..max_part_room_class_bound;
% demande de partie en nombre de classes par enseignant
set of int: PTC_DEMAND = 0..max_part_teacher_class_bound;
% taille d'effectif en nombre d'étudiants
set of int: HEADCOUNT = 0..total_group_size;

%TODO à borner avec constance d'instance ou à calculer en fonction des dimensions de l'instance de sorte à pouvoir ordonner les critères lexicographiquement
%set of int: WEIGHT = 0..10;


%%% DECOMPTES D'ELEMENTS
% décompte de créneaux (ie. durée)
set of int: SLOTS = 0..nr_slots;
% décompte de classes
set of int: CLASSES = 0..nr_classes;
% décompte de séances
set of int: SESSIONS = 0..nr_sessions;


%%% TYPES ET DIMENSIONS VIRTUALISES
% salle
set of int: ROOM_V = {cst_null_room} union ROOM;
% enseignant
set of int: TEACHER_V = {cst_null_teacher} union TEACHER;
% rang de séance
set of int: SESSION_RANK_V = {cst_null_session_rank} union SESSION_RANK;
% capacité d'équipement
set of int: E_COUNT_V = {cst_null_equipment_capacity} union E_COUNT;
% demande en équipements
set of int: PE_DEMAND_V = {cst_null_equipment_demand} union PE_DEMAND;
% capacité de salle
set of int: R_CAPACITY_V = {cst_null_room_capacity} union R_CAPACITY;
% demande de partie en nombre de classes par salle
set of int: PRC_DEMAND_V = {cst_null_bound} union PRC_DEMAND;
% demande de partie en nombre de classes par enseignant
set of int: PTC_DEMAND_V = {cst_null_bound} union PTC_DEMAND;
