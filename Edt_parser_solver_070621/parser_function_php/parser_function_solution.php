<?php
//=====================
/**
 * Fonction de nettoyage d'une string pour éviter des caractères interdit
 */
function cleanString($input):string{
    return  utf8_encode(str_replace("\n","",$input));
}//FinFunction

//=====================
/**
 * Convertit un tableau de sortis mzn dans un format php
 * Nettoie aussi de certain caractère
 */
function transformDznToArray($dznArray):array{
    $explodeDznArray = explode(",",$dznArray);
    $atb = array_map(function($e){return str_replace(["[","]","\""],"",$e);},$explodeDznArray);
    $atb = array_map(function($e){return preg_replace('/^\s*/',"",$e);},$atb);
    return $atb;
}//FinFunction

//=====================
/**
 * Pour un element d'une ligne fournis transforme l'element de output mzn au format xml
 * Cette fonction transforme un element sous forme de tableau en liste de node xml
 */
function ElementTabToXML($nameLineElement,$lineElement,$xmlSolution,$solutionElementXML):bool{
    //TODO LABEL IN OUTPUT union label part ect
    //print_r($nameLineElement);
    if($lineElement == "[]"){
        return false;
    }
    if($nameLineElement == "group"){
        $elementSub = $xmlSolution->createElement("class");
        foreach(transformDznToArray($lineElement) as $element){
            $subSubElement = $xmlSolution->createElement("group");
            ElementStringToXML("refId",$element,$xmlSolution,$subSubElement);
            $elementSub->appendChild($subSubElement);
        }
        $solutionElementXML->appendChild($elementSub);
    }
    elseif(in_array($nameLineElement,["rooms","teachers"])){

        $elementSub = $xmlSolution->createElement("choose".ucfirst($nameLineElement));
        foreach(transformDznToArray($lineElement) as $element){
            $subSubElement = $xmlSolution->createElement(substr($nameLineElement,0,-1));
            ElementStringToXML("refId",$element,$xmlSolution,$subSubElement);
            $elementSub->appendChild($subSubElement);
        }
        $solutionElementXML->appendChild($elementSub);

    }
    elseif($nameLineElement=="equipements"){

    }
    elseif($nameLineElement=="slot"){
        $elementSub = $xmlSolution->createElement("schedule");

        $tabResult = transformDznToArray($lineElement);
        $subSubElement1 = $xmlSolution->createAttribute("slot");
        $subSubElement1->value = cleanString($tabResult[0]);
        $subSubElement2 = $xmlSolution->createAttribute("sessionLength");
        $subSubElement2->value = cleanString($tabResult[1]);

        $elementSub->appendChild($subSubElement1);
        $elementSub->appendChild($subSubElement2);
        
        $solutionElementXML->appendChild($elementSub);

    }
    else{exit ("ERROR FIELD DON'T EXIST");}
    return true;

}//FinFunction

//=====================

function ElementStringToXML($nameLineElement,$lineElement,$xmlSolution,$solutionElementXML):bool{
    //TODO NAME OF CLASSES DZN
    $attri = $xmlSolution->createAttribute($nameLineElement);
    $proper = cleanString($lineElement);
    $attri->value = ($proper);
    $solutionElementXML->appendChild($attri);
    return true;
}//FinFunction

//=====================

function  writeSolutionXml($instance,$noPathName,$dateTime,$outputSolution,$outputStat = "",$outputStatCsv=""):array {
    $j = dirname( dirname(dirname(__FILE__)));
    $j2 = dirname(dirname(__FILE__));
    //$j ="";
    //echo "hh1:   $j"; 
    $elementNameNotTab = ["class","part","course","session"];
    $fileName = substr($noPathName,0,-4);

    $fileNameSol ="";
    $outputStatCsv ="";

        if(substr(php_uname(), 0, 7) != "Windows"){
    $fileNameSol = $j."/solution_instance_xml/solution_".$fileName."_".$dateTime.".xml";}
      else{
 $fileNameSol = $j."\\solution_instance_xml\\solution_".$fileName."_".$dateTime.".xml";
      }

        if(substr(php_uname(), 0, 7) != "Windows"){
      $outputStatCsv = $j."/statistique_instance_xml/statistique_".$fileName."_".$dateTime.".csv";}
      else{
   $outputStatCsv = $j."\\statistique_instance_xml\\statistique_".$fileName."_".$dateTime.".csv";
      }

    /*if($outputStat == ""){
        $outputStat = "statistique_".$fileName.".txt";
        file_put_contents($outputStat,"");
    }*/
   /* if($outputStatCsv == ""){
        substr($outputStat,0,-3)."csv";
    }*/
//echo "hh2:  ". $fileNameSol." \n"; 
//echo "hh3:  ". $outputStatCsv." \n"; 


    /*$insert = "<?xml version=\"1.0\"?>\n<timetabling>\n   <solutions>\n   </solutions>\n</timetabling>\n";*/
    /*$insert = '<?xml version="1.0"?>';*/
    //file_put_contents($fileNameSol,$insert);

    $xmlInstance = new DOMDocument();
    $xmlInstance->load($instance);

    $xmlSolution = new DOMDocument();

    $xpathInstance = new DOMXpath($xmlInstance);
    //$xpathSolution = new DOMXpath($fileNameSol);


    $qTimetabling = "/timetabling";
    $TimetablingAttributes = $xpathInstance->query($qTimetabling)[0]->attributes;
    $timetablingElementSolution = $xmlSolution->createElement('timetabling');

    foreach($TimetablingAttributes as $attribute){
        //print_r($attribute->value);
        $xmlSolutionTTAttribute = $xmlSolution->createAttribute($attribute->name);
        $xmlSolutionTTAttribute->value = $attribute->value;
        $timetablingElementSolution->appendChild($xmlSolutionTTAttribute);
    }

    $qCalendar = "/timetabling/calendar";
    $nodeCalendar = $xpathInstance->query($qCalendar)->item(0);
    $timetablingElementSolution->appendChild($xmlSolution->importNode($nodeCalendar,true));


    $solutionsElementSolution = $xmlSolution->createElement('solutions');
    //echo "SALUUUUUUUT : $outputSolution";
    $fileResult = file($outputSolution);
    //print_r($fileResult);
    foreach($fileResult as $line){
        if ( !strncmp($line,"session",6)&& strncmp($line,"%%%mzn",4) ){ 
            $lineTab = explode(";",$line);

            $solutionElementXML = $xmlSolution->createElement('solution',"\n");

            foreach($lineTab as $lineElement){
                $explodeLineElement = explode(":",$lineElement);
                $nameElement = strtolower($explodeLineElement[0]);

                if(in_array($nameElement,$elementNameNotTab)){
                    ElementStringToXML($nameElement,$explodeLineElement[1],$xmlSolution,$solutionElementXML);
                }
                else{
                    ElementTabToXML($nameElement,$explodeLineElement[1],$xmlSolution,$solutionElementXML);
                }
            
            }
           $solutionsElementSolution->appendChild($solutionElementXML);
        }//FinIf
        else{
            file_put_contents($outputStat,$line,FILE_APPEND);
        }//FinElse
    }//FinFor
    $fileResult = file($outputStat);

    foreach($fileResult as $line){
        if(!strncmp($line,"%%%mzn-stat: ",13)){
            $lineCsv = preg_replace('/^%%%mzn-stat:*\s/',"",$line);
            $explodeLineCsv = explode("=",$lineCsv); 
            $lineCsv = $explodeLineCsv[0].";".$explodeLineCsv[1];
            file_put_contents($outputStatCsv,$lineCsv,FILE_APPEND);
        }
    }//FinFor


    $timetablingElementSolution->appendChild($solutionsElementSolution);

    $xmlSolution->appendChild($timetablingElementSolution);
    $xmlSolution->save($fileNameSol);
      if(substr(php_uname(), 0, 7) == "Windows"){
    shell_exec("del ".$j2."\\solution_*.txt");
    shell_exec("del ".$j2."\\statistique_*.txt");
      }
      else{
    shell_exec("rm ".$j2."/solution_*.txt");
    shell_exec("rm ".$j2."/statistique_*.txt");
}

return [$outputStatCsv, $fileNameSol];
}//FinFunction

//=====================

//exemple d'utilisation :
//writeSolutionXml("ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml","resultat.txt","test_bash.txt");

?>
