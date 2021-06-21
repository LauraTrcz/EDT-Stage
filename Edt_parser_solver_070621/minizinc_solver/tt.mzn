%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% Version 0.1 - 10/4/2021
% D. Lesaint
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% TRAITS DE LOGGING
enum U_LOG = {
u_lany, % any aspect
u_lutils, % utilitaires
u_lfilter, % constraint generator - single filter evaluation
u_lfilters, % constraint generator - filter list evaluation
u_lmask, % constraint generator - mask evaluation
u_lgroup, % constraint generator - scope collector grouping evaluation
u_lsingle_sc, % constraint generator - single scope collector evaluation
u_lmultiple_sc, % constraint generator - multiple scope collector evaluation
u_lcc, % constraint generator - constraint collector evaluation
u_luconstraint, % constraint generator - u-constraint statement
u_lupredicate, % constraint generator - u-constraint predicate 
u_betatest % constraint generator - u-constraint predicate 
};

% ENSEMBLE DES TRAITS DE LOGGING : DONNEE D'ENTREE
%% Usage (eg. à copier-coller dans l'invitation de l'IDE comme valeur de l'ensemble  u_log)
%% - pour logging complet :
%{u_lfilter,u_lutils,u_lfilters,u_lmask,u_lgroup,u_lsingle_sc,u_lmultiple_sc,u_lcc,u_luconstraint,u_lupredicate}
%% - pour collecteur de contraintes et u-contraintes générées uniquement :
%{u_lcc,u_lupredicate}
%% - pour u-contraintes générées uniquement :
%{u_lupredicate}
set of U_LOG: u_log={u_betatest};

%see other solve
%solve satisfy;
% INCLUSIONS DE FICHIERS
include "tt_bounds.mzn";
include "tt_ranges.mzn";
include "tt_arrays.mzn";
include "tt_functions.mzn";
%include "tt_assertions.mzn";
include "tt_predicates.mzn";
include "tt_generate.mzn";
include "tt_variables.mzn";


include "tt_constraints.mzn";
% %include "tt_cost.mzn";

include "tt_solve.mzn";
include "tt_output.mzn";
