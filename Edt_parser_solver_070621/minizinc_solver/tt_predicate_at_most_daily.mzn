 %%%%%%%% ATMOSTDAILY
 %Maximum d'un événement tout les jours
% atMostDaily d'1 n-uplet de séances
predicate at_most_daily(U_HARDNESS: h, array[int] of SESSION: sessions, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_betatest,"U-contrainte : At most daily");
  int: a1 = my_trace(u_betatest,"1 tuple de séances",sessions);
    %int: a1 = my_trace(u_betatest,"1 tuple de séances",my_show("S",sessions,true));
  
  int:day_slot_count = parameter_value[search_value_name(parameters,"count"),1];
  int:day_slot_min = parameter_value[search_value_name(parameters,"first"),1];
  int:day_slot_max = parameter_value[search_value_name(parameters,"last"),1];
  
  set of int: set_of_day = 1..nr_days_per_week*nr_weeks;
  array[int] of int: minimum_day_slot =[1]++[(nr_slots_per_day*i)+1|i in 2..nr_days_per_week*nr_weeks];
  } in
  forall(i in set_of_day)(
    let{
      array[int] of int : day_concerned = [sessions[j] |j in index_set(sessions) where ((sessions[j]+day_slot_min-1) > (minimum_day_slot[i] + day_slot_min-1))/\ ((sessions[j]+day_slot_max-1) <= (minimum_day_slot[i] + day_slot_max-1))];
    }in
   length(day_concerned) <= day_slot_count
  )
;

% atMostDaily de 2 n-uplets de séances
predicate at_most_daily(U_HARDNESS: h, array[int] of SESSION: sessions1, array[int] of SESSION: sessions2, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_lupredicate,"U-contrainte : weekly");
  int: a1 = my_trace(u_lupredicate,"2 tuples de séances " ,my_show("S",sessions1,true) ++ " --  " ++ my_show("S",sessions2,true));
  } in
true
;

% atMostDaily d'1 n-uplet de n-uplets alignés de séances
predicate at_most_daily(U_HARDNESS: h, array[int,SESSION] of SESSION_V: sessions, array[int] of U_PARAMETER_VALUE: parameters) =
  let {
  int: a0 = my_trace(u_betatest,"U-contrainte : at most daily");
  int: a1 = my_trace(u_betatest,"empilement des tuples d'ensembles à multiplier",sessions);
  set of int: T = index_set_1of2(sessions);
  int: t = max(T);
  set of int: T1 = T diff {t};
  } in
 true;