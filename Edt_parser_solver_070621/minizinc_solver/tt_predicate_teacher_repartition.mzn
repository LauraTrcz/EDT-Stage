%%%%%%%% TEACHER REPARTIITION
% TEACHER REPARTITION d'1 n-uplet de séances
%TODO VERIFICATION PARSER
predicate teacher_repartition(U_HARDNESS: h, array[int] of SESSION: sessions, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : teacher_repartition");
  int: a1 = my_trace(u_lupredicate,"1 tuple de séances",my_show("S",sessions,true));
  int: part_to_repartition = session_part(sessions[0]);
  set of TEACHER: teachers = part_teachers[part_to_repartition]; 
  } in
true
;

% TEACHER REPARTITION de 2 n-uplets de séances
predicate teacher_repartition(U_HARDNESS: h, array[int] of SESSION: sessions1, array[int] of SESSION: sessions2, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : teacher_repartition");
  int: a1 = my_trace(u_lupredicate,"2 tuples de séances " ,my_show("S",sessions1,true) ++ " --  " ++ my_show("S",sessions2,true));
  } in
true
;

% TEACHER REPARTITION d'1 n-uplet de n-uplets alignés de séances
predicate teacher_repartition(U_HARDNESS: h, array[int,SESSION] of SESSION_V: sessions, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : teacher_repartition");
  int: a1 = my_trace(u_lupredicate,"empilement des tuples d'ensembles à multiplier",sessions);
  int: a3 = my_trace(u_lupredicate,"empilement des tuples d'ensembles à multiplier",sessions);
  
  array[int] of SESSION_V: sessions_one=[sessions[1,i] | i in index_set_2of2(sessions)];
  int: maxT = arg_min(sessions_one)-1;
  set of int: T = index_set_1of2(sessions);
  set of int: T2 = 1..maxT;
  array[int,int] of SESSION_V: sessions_not_padder =  array2d(T,T2,[sessions[n,j]| n in T, j in T2]);

  int: t = max(T);
  set of int: T1 = T diff {t};
  PART: p = session_part(sessions_not_padder[1,1]);
  array[int] of TEACHER: teachers_filter = [i|i in part_teachers[p]];
  array[int] of int: teachers_work = [part_teacher_sessions_count[i-1+p]|i in index_set(teachers_filter)];
  int: a2 = my_trace(u_betatest,"teachers_filter : ",teachers_filter);
  int: a2i = my_trace(u_betatest,"teachers_work : ",teachers_work);
  int: nr_sessions=maxT;
  } in
  forall(i in index_set(parameters))(
    if(parameter_value[parameters[i],1] == utt_halfhalf) then
      forall(j in index_set_1of2(sessions_not_padder))(forall(k in 1..(nr_sessions div 2))(exists(l in index_set(teachers_filter))(x_teachers[sessions_not_padder[j,k]]=={teachers_filter[l]})))
      \/
       forall(j in index_set_1of2(sessions_not_padder))(forall(k in (nr_sessions div 2)..nr_sessions)(exists(l in index_set(teachers_filter))(x_teachers[sessions_not_padder[j,k]]=={teachers_filter[l]})))
    elseif (parameter_value[parameters[i],1] == utt_single) then
      forall(j in index_set_1of2(sessions_not_padder))(forall(k in index_set_2of2(sessions_not_padder))(exists(l in index_set(teachers_filter))(x_teachers[sessions_not_padder[j,k]]=={teachers_filter[l]})))
    else trace("BUG: parameter is false",false) 
    endif
    )
    /\ 
    forall(u in index_set(teachers_work))(teachers_work[u] == sum(i in index_set_1of2(sessions_not_padder),j in index_set_2of2(sessions_not_padder))(bool2int(teachers_filter[u] in x_teachers[sessions_not_padder[i,j]] ))) 
 ;