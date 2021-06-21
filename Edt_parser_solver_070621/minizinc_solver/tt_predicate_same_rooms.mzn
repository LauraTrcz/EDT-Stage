%% SALLES COMMUNES
% salles communes à 1 n-uplet de séances
predicate same_rooms(U_HARDNESS: h, array[int] of SESSION: sessions, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : same_rooms");
  int: a1 = my_trace(u_lupredicate,"1 tuple de séances",my_show("S",sessions,true));
  } in
  forall(s1,s2 in index_set(sessions) where s1<s2)(
    x_rooms[session_class(sessions[s1])] == x_rooms[session_class(sessions[s2])]
  )
;

% salles communes à 2 n-uplets de séances
predicate same_rooms(U_HARDNESS: h, array[int] of SESSION: sessions1, array[int] of SESSION: sessions2, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : same_rooms");
  int: a1 = my_trace(u_lupredicate,"2 tuples de séances " ,my_show("S",sessions1,true) ++ " --  " ++ my_show("S",sessions2,true));
  } in
  %Definis [1,2] [3,4,5] -> (1 op 3) (1 op 4) (1 op 5) (2 op 3)(2 op 4)(2 op 5)
  if h == utt_hard then
    forall(i in index_set(sessions1))(
    %x[i] = x[i+1]
      forall(j in index_set(sessions2))(
     % same_room(% TODO REduire le nbr de contraintes)
        x_rooms[session_class(sessions1[i])] == x_rooms[session_class(sessions2[j])]
      )
    )
  endif
;

% salles communes à 1 n-uplet de n-uplets alignés de séances
predicate same_rooms(U_HARDNESS: h, array[int,SESSION] of SESSION_V: sessions, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : same_rooms");
  int: a1 = my_trace(u_lupredicate,"empilement des tuples d'ensembles à multiplier",sessions);
  set of int: T = index_set_1of2(sessions);
  int: t = max(T);
  set of int: T1 = T diff {t};
  } in
  forall(i in T1)(same_rooms(h,unpad_quple(sessions[i..i,SESSION]),unpad_quple(sessions[i+1..i+1,SESSION]),parameters));
  