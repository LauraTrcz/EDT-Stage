%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% PROPRIETES ET RELATIONS SUR CLASSES D'ELEMENTS (=MULTIFONCTIONS=TABLEAUX)
% DONNEES D'ENTREE

% MULTIFONCTIONS ENTRE CLASSES D'ELEMENTS
array[COURSE] of set of PART: course_parts; % les parties d'un cours
array[PART] of set of CLASS: part_classes; % les classes d'une parties
array[PART] of set of EQUIPMENT: part_equipments; % les équipements possibles d'une partie
array[PART] of set of ROOM: part_rooms; % les salles possibles d'une partie
array[PART] of set of TEACHER: part_teachers; % les enseignants possibles d'une partie
array[CLASS] of set of GROUP: class_groups; % les groupes d'une classe
array[CONSTRAINT] of set of SCOPE: constraint_scopes; % les portées d'une contrainte
array[SCOPE] of set of FILTER: scope_filters; % les filtres d'une portée
array[CONSTRAINT] of UTT_FUNCTION: constraint_function; % la fonction d'une contrainte
array[CONSTRAINT] of set of PARAMETER: function_parameters; % les paramètres d'une contrainte

% FONCTIONS DE CLASSES D'ELEMENTS SUR DIMENSIONS
array[EQUIPMENT] of string: equipment_name; % le nom d'un équipement
array[EQUIPMENT] of E_COUNT_V: equipment_count; % le décompte d'équipements par type d'équipement (!!! potentiellement illimité)
array[ROOM] of string: room_name; % le nom d'une salle
array[ROOM] of R_CAPACITY_V: room_capacity; % la capacité d'une salle (!!! potentiellement illimitée)
array[TEACHER] of string: teacher_name; % le nom d'un enseignant
array[GROUP] of string: group_name; % le nom d'un groupe
array[GROUP] of G_HEADCOUNT: group_size; % la taille d'un groupe
array[COURSE] of string: course_name; % le nom d'un cours
array[PART] of string: part_name; % le nom d'une partie
array[CLASS] of string: class_name;%le nom d'une class
array[LABEL] of string: label_name; % le nom des labels
array[PART] of SESSION_RANK: part_nr_sessions; % le nombre de séances de toute classe d'une partie
array[PART] of SLOTS: part_length; % la durée des séances d'une partie
array[PART_EQUIPMENT] of PE_DEMAND: part_equipment_count; % le décompte d'équipements demandés par type d'équipement dans toute séance de partie
array[PART] of UTT_RESSOURCE_USE: part_room_use; % la politique d'allocation de salles par séance d'une partie
%array[PART_ROOM,UTT_RESOURCE_BOUND] of PRC_DEMAND_V: part_room_class_bound; % les seuils d'hébergement de classes par salle d'une partie (potentiellement fictifs)
%array[PART] of UTT_RESSOURCE_USE: part_teacher_use; % la politique d'encadrement enseignant par séance d'une partie
%array[PART] of T_CAPACITY: part_teacher_capacity; % le plafond d'encadrement étudiants/enseignant des séances d'une partie
%array[PART_TEACHER,UTT_RESOURCE_BOUND] of PTC_DEMAND_V: part_teacher_class_bound; % les seuils d'encadrement de classes par enseignant d'une partie (potentiellement fictifs)
%TODO suppress? array[CLASS] of MULTIROOM: class_multiroom; % classes multi-salles
array[SCOPE] of UTT_TYPE: scope_clustering; % le critère de regroupement d'une portée 
array[SCOPE,SESSION_RANK] of SESSION_RANK_V: scope_mask; % le masque sur rangs de séances d'une portée
array[FILTER] of UTT_TYPE: filter_type; % le type d'un filtre (de ses éléments)
array[FILTER] of set of UTT_ELEMENT: filter_elements; % les éléments résultant d'un filtre
array[CONSTRAINT] of UTT_HARDNESS: function_type; % la dureté d'une contrainte
array[PARAMETER,ELEMENT_PARAMETER] of UTT_PARAMETER: parameter_value; % la valeur d'un paramètre
array[PART_ROOM_MANDATORY,1..2] of int:part_room_mandatory;%salle mandatory
array[PART_SESSIONS_TEACHER] of int:part_sessions_teacher;%le nombre de teacher par class pour chaque part
array[PART_TEACHER] of int :part_teacher_sessions_count;%Le nombre de sessions pour chaque teacher pour chaque part
array[ROOM] of set of LABEL: room_label;
array[TEACHER] of set of LABEL: teacher_label;
array[GROUP] of set of LABEL: group_label;
array[COURSE] of set of LABEL: course_label;
array[PART] of set of LABEL : part_label;

array[PARAMETER] of string:parameter_name;
array[PARAMETER] of string:parameter_type;

