%%%%%%%%%%%%%%% ENSEIGNANTS COMMUNS
% enseignants communs à 1 n-uplet de séances
predicate same_teachers(U_HARDNESS: h, array[int] of SESSION: sessions, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : same_teachers");
  int: a1 = my_trace(u_lupredicate,"1 tuple de séances",my_show("S",sessions,true));
  array[int] of CLASS: classes_use =[session_class(sessions[s])| s in index_set(sessions)];
  array[int] of set of TEACHER:class_teachers = [part_teachers[class_part(classes_use[u])]| u in index_set(classes_use)] ;
  } in
  forall(c1,c2 in index_set(classes_use) where c1<c2)(
    class_teachers[classes_use[c1]] == class_teachers[classes_use[c2]]) 
;


% enseignants communs à 2 n-uplets de séances
predicate same_teachers(U_HARDNESS: h, array[int] of SESSION: sessions1, array[int] of SESSION: sessions2, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : same_teachers");
  int: a1 = my_trace(u_lupredicate,"2 tuples de séances " ,my_show("S",sessions1,true) ++ " --  " ++ my_show("S",sessions2,true));
  } in
  %Definis [1,2] [3,4,5] -> (1 op 3) (1 op 4) (1 op 5) (2 op 3)(2 op 4)(2 op 5)
  true;

% enseignants communs à 1 n-uplet de n-uplets alignés de séances
predicate same_teachers(U_HARDNESS: h, array[int,SESSION] of SESSION_V: sessions, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : same_teachers");
  int: a1 = my_trace(u_lupredicate,"empilement des tuples d'ensembles à multiplier",sessions);
  set of int: T = index_set_1of2(sessions);
  int: t = max(T);
  set of int: T1 = T diff {t};
  } in
  forall(i in T1)(same_teachers(h,unpad_quple(sessions[i..i,SESSION]),unpad_quple(sessions[i+1..i+1,SESSION]),parameters));
  