%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%output[show(COST_RANGE)];

output["session:"++show(s-position_session_class(s))++";course:"++course_name[part_course(class_part(session_class(s)))]++";part:"++ part_name[class_part(session_class(s))]++";class:"++class_name[session_class(s)]++";teachers:"++ show([teacher_name[i]|i in x_teachers[s]]) ++";rooms:"++show([room_name[i]|i in x_rooms[session_class(s)]])++";group:"++show([group_name[i]|i in class_groups[session_class(s)]])++";slot:[\""++show(x_slot[s])++"\", \""++show(session_length(s))++"\"]\n"|s in SESSION]

%output["\n"]++[" Classe : "++course_name[part_course(class_part(c))]++" "++ part_name[class_part(c)]++" "++show(c)++" Prof :"++ show([teacher_name[i]|i in x_teachers[c]]) ++" ROOM : "++show([room_name[i]|i in x_rooms[c]])++" GROUP : "++show([group_name[i]|i in class_groups[c]])++"\n Creneau : "++show([x_slot[s]|s in class_sessions(c)])++"\n"|c in CLASS]