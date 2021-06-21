<?php
if (substr(php_uname(), 0, 7) == "Windows"){
include 'parser_function_php\parser_utility_function.php';
include 'parser_function_php\parser_function_solution.php';
}
else{
include 'parser_function_php/parser_utility_function.php';
include 'parser_function_php/parser_function_solution.php';

}


//============================

/**
 * Finction principale
 * Prend un tableau associatif en entrée au format suivant :
 *     [
 *       "instance"-> string
 *       "solver"->mzn chr
 *       "represnetation-> ext int"
 *       "temps_calcul"->int
 *       "foramat"->json dzn
 *      ]
 * Renvoie un tableau contenant les names des fichiers.
 * les noms sont au format suivant :
 * pour l'instance abc.xml
 * cela donne ["solution_abc.xml","statistique_abc.csv"]
 */

function runParser($parameters):array{

    $instance = $parameters["instance"];//nom de l'instance à traiter
    $nameFileTT = substr($instance,0,-4);//nom du fichier 

    $solver = $parameters["solver"];//type de solver utilisé (minizinc, CHR)
    $representation = $parameters["representation"];//type de représentation (intent, extent)

    $format = $parameters["format"];//format du fichier (dzn,json)
    $fileParsing = $nameFileTT.".".$format;//format du fichier parser

    $timeOut = $parameters["temps_calcul"];//temps maximum de calcul

    if($solver == "minizinc"){//solveur minzinc
        //use minzinc solver
        //parsing instance with parser
        parser_execute($instance,$fileParsing,$representation);
        //execute solver
        //exemple :
        //minizinc -a --solver Gecode tt.mzn xml2dzn/ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.dzn// -a allsolution
        // time minizinc -s --solver Gecode --output-to-file resultat.txt  --verbose-solving --output-mode item tt.mzn 
        //xml2dzn/ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.dzn > test_bash.txt

        //Option and format of minizinc execution
        $allSolution = false;
        $dateTime = date('_jmY_h_i_s');
        $all = "";
        $stat = " --solver-statistics ";
        $solverOfMinizinc = " --solver Gecode ";
        $outputFileMzn = " --output-to-file ";
        $outputFileStat = " > ";
        $statFileOut = "statistique_".$nameFileTT.$dateTime.".txt";
        $solutionFileOutTxt = "solution_".$nameFileTT.$dateTime.".txt";
        $solutionFileOut = "solution_".$nameFileTT.$dateTime.".xml";
        $outputStatCsv = substr($statFileOut,0,-3)."csv";

        if($allSolution == true){
            $all = " -a ";
        }
        //execution of minizinc solver !!!! WINDOWS CAN BUG
         if(substr(php_uname(), 0, 7) != "Windows"){
        $output = shell_exec("minizinc ".$all.$solverOfMinizinc.$stat.$outputFileMzn.$solutionFileOutTxt." --output-mode item minizinc_solver/tt.mzn ".$fileParsing.$outputFileStat.$statFileOut);
         }
        else{
            $output = shell_exec("C:\\\"Program Files\"\MiniZinc\minizinc.exe  ".$all.$solverOfMinizinc.$stat.$outputFileMzn.$solutionFileOutTxt." --output-mode item minizinc_solver\\tt.mzn ".$fileParsing.$outputFileStat.$statFileOut);
        }
        //traitement des solutions générés par minizinc
        writeSolutionXml($instance,$solutionFileOutTxt,$statFileOut,$outputStatCsv);
        //renvoie des names
        return [$solutionFileOut,$outputStatCsv];

    }
    elseif($solver == "CHR" || $solver =="chr"){//Solveur CHR
        //use CHR solver
    }
    else{//Solver non valide
        exit ("FATAL ERROR SOLVER DOESN\'T EXIST");
    }//FinIfSolver
}//FinFunction

//============================

//exemple d'execution : 
 /*
//fichier par defaut
$st = "ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml";

//récupération de argv[1]
if(sizeof($argv)>1){
    $st = $argv["1"];
}

//Exemple de tableau associatif
$test = [
    "instance"=>$st,
    "solver"=> "minizinc",
    "format"=> "dzn",
    "representation"=>"intent",
    "temps_calcul"=>128
];
 
$solut = runParser($test);
print_r($solut);
 */
 

?>
