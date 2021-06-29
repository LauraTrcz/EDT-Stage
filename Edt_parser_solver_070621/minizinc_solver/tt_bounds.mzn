%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% BORNES

% BORNES LUES EN ENTREES
int: nr_weeks; % nombre de semaines sur l'horizon de temps
int: nr_days_per_week; % nombre de journées hebdomadaires
int: nr_slots_per_day; % nombre de créneaux quotidiens

int: nr_equipments; % nombre d'équipements
int: nr_rooms; % nombre de salles
int: nr_teachers; % nombre d'enseignants
int: nr_groups; % nombre de groupes d'étudiants
int: nr_courses; % nombre de cours
int: nr_parts; % nombre total de parties
int: nr_classes; % nombre total de classes
int: nr_constraints; % nombre de contraintes
int: nr_labels;% nombre de label

int: nr_part_equipments; % nombre total d'équipements possibles pour les parties
int: nr_part_rooms; % nombre total de salles possibles pour les parties
int: nr_part_teachers; % nombre total d'enseignants possibles pour les parties
int: nr_scopes; % nombre total de portées de contraintes
int: nr_filters; % nombre total de filtres de portées
int: nr_parameters; % nombre total de paramètres de fonctions
int: nr_part_room_mandatory;% nombre total de salle mandatory
int: nr_part_sessions_teacher;% nombre total de sessions par tecaher pour les parts

int: max_session_rank; % rang maximum de séance sur les parties
int: max_equipment_count;  % décompte maximum recensé sur les équipements
int: max_room_capacity; % capacité maximum recensée sur les salles
%int: max_teacher_capacity; % capacité maximum recensée sur les enseignants
int: max_group_size; % taille d'effectif maximum recensée sur les groupes
int: max_part_equipment_count; % décompte maximum recensé sur les demandes en équipements des parties
int: max_part_room_class_bound; % maximum de classes possibles par salle par partie
int: max_part_teacher_class_bound; % maximum de classes possibles par enseignant par partie
int: max_element_parameter;% maximum d'element d'un parametre


%% BORNES AUXILIAIRES
% nombre de créneaux hebdomadaires
int: nr_weekly_slots = nr_days_per_week * nr_slots_per_day;
 % nombre de créneaux sur l'horizon de temps
 int: nr_slots = nr_weeks * nr_weekly_slots;
% nombre total de séances
int: nr_sessions = sum(c in 1..nr_courses)(sum(p in course_parts[c])(card(part_classes[p])*part_nr_sessions[p]));
% taille des effectifs cumulés des groupes
int: total_group_size = sum(g in 1..nr_groups)(group_size[g]);


%TODO  int: nr_criteria = 4;