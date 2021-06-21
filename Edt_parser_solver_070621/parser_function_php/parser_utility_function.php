<?php
/////////////////////////////////////////////////////////
function camel2Snake($input) : string {
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        //$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
  }
  
/////////////////////////////////////////////////////////
function array1d_($tab,$scalar,$prefix) : string {
    if($tab!==[]) {
        $s = array_reduce($tab,function($c,$t) use($scalar,$prefix) {
            if($scalar===1) {
                return $c .= $prefix.$t.",";
            } elseif($scalar===2) {
                return $c .= camel2Snake($prefix.$t).",";
            } else  {
                return $c .= '"'.$prefix.$t.'",';
            }
        },
        "");
        return substr($s,0,-1);
    } else {
        return "";
    }
}

function array1d($index_set_name,$s) : string {
    return
        "["
        . $s
        . "]";
}

function array1d2Set($tab) : string {
    $s = array_reduce($tab,function($c,$i){ return $c .= (string)($i) . ",";},"");
    if($tab==[])
        return "{}";
    else
        return "{" . substr($s,0,-1) . "}";
}

function array1dOfSets($index_set_name,$tab) : string {
    $s = array_reduce($tab,function($c,$t) {return $c .= array1d2Set($t).",";},"");
    return
        "["
        . substr($s,0,-1)
        . "]";
}

function array2d_($tab1,$tab2,$scalar,$prefix) : string {
    if($tab1!==[] && $tab2!==[]) {
        $tab = [];
        for($i=0;$i<count($tab1);++$i) $tab[] = [$tab1[$i],$tab2[$i]];
        $s = array_reduce($tab,function($c,$t) use($scalar,$prefix) {
            if($scalar===1) {
                return $c .= $prefix.$t[0].",".$prefix.$t[1].",";
            } elseif($scalar===2) {
                return $c .= camel2Snake($prefix.$t[0]).",".camel2Snake($prefix.$t[1]).",";
            } else  {
                return $c .= '"'.$prefix.$t[0].$prefix.$t[1].'",';
            }
        },
        "");
        return substr($s,0,-1);
    } else {
        return "";
    }
}

function array2d($index_set_name1,$index_set_name2,$tab) : string {
    return
        "array2d(1.." . camel2Snake($index_set_name1) . "," . $index_set_name2 .",["
        . $tab
        . "])";
}

function array2dTo1d($index_set_name1,$index_set_name2,$tab) : string {
    return
    "array2d(1.." . camel2Snake($index_set_name1) . ",1.."
    . camel2Snake($index_set_name2) . ",["
    . $tab
    . "])";
}


/////////////////////////////////////////////////////////
function numbering($query,$id=true) : array {
    global $xpath;
    $q = $xpath->query($query);
    if($id) {
        $t = array_map(function($e) {return $e->getAttribute("id");},iterator_to_array($q));
    } else {
        $n = 0;
        $t = array_map(function($e) use(&$n) {return ++$n;},iterator_to_array($q));
    }
    $v = [];
    foreach($t as $k=>$u) {$v[$k+1]=$u;}
    return $v;
}

function getElementRank($id,$ids) {
    if (in_array($id,$ids)){
        return array_search($id,$ids);
    }
    else{
        throw new Exception("ERROR : incorrect number of element");
    }
}

function getRank($type,$id) {
    global $typeMap;
    if(in_array($type,["equipment","room","teacher","group","course","part","class","label"])) {

        try {
            return getElementRank($id,$typeMap[$type]);
        } catch (Exception $e) {
            echo "WHO: $type, $id \n",  $e->getMessage(), "\n";
        }
    } else {
        exit("error: incorrect name $type for filter type \n");
    }
}


/////////////////////////////////////////////////////////
function comment($f,$m) : void {
   fwrite($f,"% " . $m);
}

function assign($f) : void {
    fwrite($f,"=");
}

function semicolon($f) : void {
    fwrite($f,";");
}

function linefeed($f) : void {
    fwrite($f,"\n");
}

function writeAttribute($x,$query,$scalar=1,$prefix="") { // : mixed (from php8.0++)
    global $dzn,$xpath;
    $q = $xpath->query($query);
    fwrite($dzn,camel2Snake($prefix.$x));
    assign($dzn);
    if($scalar===1) {
        $v = intval($q->item(0)->getAttribute($x));
        fwrite($dzn,$v);
    } else {
        $v = $q->item(0)->getAttribute($x);
        fwrite($dzn,'"'.$v.'"');
    }
    semicolon($dzn);
    linefeed($dzn);
    return $v;
}//FinFunction

function writeCount($x,$qry,$name="") : int {
    global $dzn,$xpath;
    $q = $xpath->query($qry);
    $name==="" ? fwrite($dzn,camel2Snake($x)) : fwrite($dzn,camel2Snake($name));
    assign($dzn);
    $v = $q->length;
    fwrite($dzn,$v);
    semicolon($dzn);
    linefeed($dzn);
    return $v;
}//FinFunction

function writeMaxBound($x,$qry,$a) : int {
    global $dzn,$xpath;
    $q = $xpath->query($qry);
    $t = array_map(function($e) use($a) {return (int)($e->getAttribute($a));},iterator_to_array($q));
    $v = $t!==[] ? max($t) : 0;
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$v);
    semicolon($dzn);
    linefeed($dzn);
    return $v;
}//FinFunction

function writeMaxElementBound($x,$qry,$a) : int {
    global $dzn,$xpath;
    $q = $xpath->query($qry);
    $t = array_map(function($e) use($a) {
         if($a != "textContent"){
             $p =sizeof(explode(",",($e->getAttribute($a))));
        }
        else{
            $p = sizeof(explode(",",($e->textContent)));
        }
        return $p;
},iterator_to_array($q));
    $v = $t!==[] ? max($t) : 0;
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$v);
    semicolon($dzn);
    linefeed($dzn);
    return $v;
}//FinFunction

function writeAttributes($x,$r,$query,$a,$scalar=1,$prefix="") : array {
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $t = array_map(function($e) use($a) {return $e->getAttribute($a);},iterator_to_array($q));
    $v = array1d_($t,$scalar,$prefix);
    $tab = array1d($r,$v);
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$tab);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}//FinFunction

function writeValue($x,$r,$query,$scalar=1,$prefix="") : array {
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $t = array_map(function($e) {return $e->textContent;},iterator_to_array($q));
    $v = array1d_($t,$scalar,$prefix);
    $tab = array1d($r,$v);
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$tab);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}//FinFunction

function writeSubElementsSets($x,$r,$query,$subtag,$ids,$att=1) : array {
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $m = 0;
    $v = [];
    $n = 0;
    foreach($q as $element) {
        $subs = $element->getElementsByTagName($subtag);
        /*print_r("sdfsdfsd");
        print_r($subs[0]);
        foreach($subs as $sub){
            $e = "";
            if($att===1) {
                $e = $sub->getAttribute("id");
            }elseif($att==2) {
                $e =  $sub->getAttribute("refId");
            } elseif($att==3) {
                $e = $sub->textContent;
            } 
            else {
                $e = (string)(++$n);
            }
        }*/
        
        $subIds= array_map(function($e) use($att,&$n) {
            if($att===1) {
                return $e->getAttribute("id");
            }elseif($att==2) {
                return $e->getAttribute("refId");
            } elseif($att==3) {
                return $e->textContent;
            } 
            elseif($att == 5){return $e->getAttribute("label");}
            else {
                return (string)(++$n);
            }
        },
            iterator_to_array($subs));
        /*$tab = [];
        foreach($subIds as $subId){
            $t = [];
            $explodeIdPossibility = explode(",",$subId);
            foreach($explodeIdPossibility as $explodeId){
                $t[] = getElementRank($explodeId,$ids);
            }
            $tab = array_merge($tab,$t);
        }*/
        $tab= array_map(function($e) use($ids) {return getElementRank($e,$ids);},$subIds);

        
        sort($tab);//  !! par collection de contraintes-UTT, l'ordre des numéros de collecteurs de portées doit être l'ordre de leur déclaration en XML
        $v[++$m]= $tab;
    }
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,array1dOfSets($r,$v));
    semicolon($dzn);
    linefeed($dzn);
    return $v;
}//FinFunction


function writeElementsSets($x,$r,$query,$a,$ids) : array {
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $m = 0;
    $v = [];
    $n = 0;
    foreach($q as $element) {
        $t1 =explode(",",$element->getAttribute($a));

        $t2 = array_map(function($e)use($ids){return getElementRank($e,$ids);},$t1);
        
        sort($t2);//  !! par collection de contraintes-UTT, l'ordre des numéros de collecteurs de portées doit être l'ordre de leur déclaration en XML
        $v[++$m]= $t2;
    }
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,array1dOfSets($r,$v));
    semicolon($dzn);
    linefeed($dzn);
    return $v;
}//FinFunction

function writeAttributePairs($x,$r1,$r2,$query,$a,$scalar=1,$prefix="") : array {
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $t1 = array_map(function($e) use($a) {return $e->getAttribute($a[0]);},iterator_to_array($q));
    $t2 = array_map(function($e) use($a) {return $e->getAttribute($a[1]);},iterator_to_array($q));
    $v = array2d_($t1,$t2,$scalar,$prefix);
    $tab = array2d($r1,$r2,$v);
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$tab);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}//FinFunction

function writeMasks($x,$r1,$r2,$query,$a,$s,$scalar=1,$prefix="") : array {
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $t1 = array_map(function($e) use($a) {return ($e->getAttribute($a)) ? ($e->getAttribute($a)) : "";},
        iterator_to_array($q));
    $t2 = 
    array_map(function($e) use($s) {
        if($e) {
            $t3 = preg_replace_callback("|(\d+)-(\d+)|",
                function($m) {
                    return implode(",",range($m[1],$m[2]));
                },$e);
            $t4 = explode(",",$t3);
            return $t4;
        } else {
            return [];
        }
    },
        $t1);
    $t3 = array_map(function($e) use($s) {return implode(",",array_pad($e,$s,"0"));},$t2);
    $v = array1d_($t3,$scalar,$prefix);
    $tab = array2dTo1d($r1,$r2,$v);
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$tab);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}//FinFunction

function writePropertiesParameterPadding($x,$r1,$r2,$query,$s,$scalar=1,$prefix="") : array {
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $t =[];

    $t1 = array_map(function($e) {return $e->textContent;},
    iterator_to_array($q));
    $tname = array_map(
        function($e){return $e->getAttribute("name");},iterator_to_array($q)
    );
    $t2 = [];
    for($i=0;$i<sizeof($t1);$i++){
        $t = [];
        $res = explode(",",$t1[$i]);
        foreach($res as $id){
            if($tname[$i] == "rooms"){
                $type = "label";
                $t[] = getRank($type,$id);
                
            }
            elseif ( $tname[$i] == "class1" || $tname[$i] == "class2" ||$tname[$i] == "class3"){
                $utt_form =  explode("-",$id);
                $utt_form =  implode("",$utt_form);
                $t[] = "utt_".$utt_form;
            }
            elseif ( $tname[$i] == "connectedRooms"){
                $type = "room";
                $t[] = getRank($type,$id);
            }
            else{
                $t[] = $id;
            }
        }
        $t2[] = $t;
    }

    $t3 = array_map(function($e) use($s) {return implode(",",array_pad($e,$s,"0"));},$t2);
    $v = array1d_($t3,$scalar,$prefix);
    $tab = array2dTo1d($r1,$r2,$v);
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$tab);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}//FinFunction

function writeParameterAttribute($x,$a,$query,$scalar=1,$prefix=""):array{
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $t =[];
    if($a == "type"){
        $t = array_map(function($e) use($a){
            $k= $e->getAttribute("name");
            //slots|slot|weeks|week|weekSlots|weekSlot|weekDays|weekDay|daySlots|daySlot|roomLabels|teacher|equipment
            if($k == "class1" || $k == "class2"|| $k == "class3"){return "teacher";}
            elseif($k == "minSlot" || $k == "maxSlot"){return "daySlot";}
            elseif($k == "rooms"){return "roomLabels";}
            elseif($k == "roomChain"){return "roomIds";}
            elseif($k == "first" || $k == "last"){return "dailySlot";}
            elseif($k == "count"){return "dailySlots";}
            elseif($k == "slot"){return "slot";}
            else{ return $e->getAttribute($a);}},iterator_to_array($q));
    }
    else{
        $t = array_map(function($e) use($a){return $e->getAttribute($a);},iterator_to_array($q));
    }
    $v = array1d_($t,$scalar,$prefix);
    $r ="";
    $tab = array1d($r,$v);
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$tab);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}//FinFunction


function typeLabelFind($resultLabel,$lbl):array{
    global $xpath;
    $v = [];
    foreach($resultLabel as $filter){
        $labels = explode(",",$filter->getAttribute("label"));
        if(in_array($lbl,$labels)){
            $v[] = $filter->getAttribute("id");
        }
    }
    return $v;

}//FinFunction

function writeFilters($x,$r,$query) : array {
    global $typeMap,$dzn,$xpath;
    $q = $xpath->query($query);
    $v = [];
    foreach($q as $filter) {
        $t = $filter->getAttribute("type");
        $n = $filter->getAttribute("attributeName");
        $in = $filter->getAttribute("in");
        $notIn = $filter->getAttribute("notIn");
        if($n==="id" && $in) {

            $e_ids = explode(",",$in);
            $e_ranks = array_map(function($id) use($t) {return getRank($t,$id);},$e_ids);
            sort($e_ranks);
            $v[] = $e_ranks;

        } elseif($n==="id" && $notIn) {

            $e_ids = explode(",",$notIn);
            $not_e_ranks = array_map(function($id) use($t) {return getRank($t,$id);},$e_ids);
            $e_ranks = array_diff(array_keys($typeMap[$t]),$not_e_ranks);
            sort($e_ranks);
            $v[] = $e_ranks;

        } elseif($n==="label" && $in) {
            $e_labels = explode(",",$in);
            $resultLabel = $xpath->query("//".$t."[@label]");
            $e_ranks = [];
            foreach($e_labels as $lbl){
                $e_ranks = array_merge($e_ranks,typeLabelFind($resultLabel,$lbl));
            }
            //print_r($e_ranks);
            $e_ranks = array_map(function($id) use($t) {return getRank($t,$id);},$e_ranks);
            sort($e_ranks);
            $v[] = $e_ranks;

        } else { // $n==="label" && $notIn
            $e_labels = explode(",",$notIn);
            $resultLabel = $xpath->query("//".$t."[@label]");
            $e_ranks = [];
            foreach($e_labels as $lbl){
                $not_e_ranks = array_merge($e_ranks,typeLabelFind($resultLabel,$lbl));
            }
            //print_r($not_e_ranks);
            $not_e_ranks = array_map(function($id) use($t) {return getRank($t,$id);},$not_e_ranks);
            $e_ranks = array_diff(array_keys($typeMap[$t]),$not_e_ranks);
            sort($e_ranks);
            $v[] = $e_ranks;
        }
        //print_r($v);
    }

    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,array1dOfSets($r,$v));
    semicolon($dzn);
    linefeed($dzn);
    return $v;
}

function writeAttributeParent($x,$r1,$r2,$query,$attribut,$parentHierarchy,$scalar=1,$prefix=""):array{
    global $typeMap,$dzn,$xpath;
    $q = $xpath->query($query);
    $parentTab = [];
    $t1 = [];
    $t2 = [];
    $typet1 = "";
    $typet2 = "";
    foreach($q as $filter) {
        $filterParent = $filter;
        for($i=0;$i<$parentHierarchy;$i++){
            $filterParent = $filterParent->parentNode;
        }
        $parentTab[] = $filterParent;
        $t1[] = $filterParent->getAttribute($attribut[0]);
        $t2[] = $filter->getAttribute($attribut[1]);
        $typet1 =  $filterParent->tagName;
        $typet2 =  $filter->tagName;
    }
    $t1 = array_map(function($id) use($typet1) {return getRank($typet1,$id);},$t1);
    $t2 = array_map(function($id) use($typet2) {return getRank($typet2,$id);},$t2);

    $v = array2d_($t1,$t2,$scalar,$prefix);
    $tab = array2d($r1,$r2,$v);
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$tab);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}

function  writeSimpleInt($x,$number):int{
    global $dzn,$xpath;
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$number);
    semicolon($dzn);
    linefeed($dzn);
    return $number;
}//FinFunction

function writeUttArray($x,$tab,$scalar=1,$prefix=""):array{ 
    global $typeMap,$dzn;

    $r = "";
    $v = array1d_($tab,$scalar,$prefix);
    $t = array1d($r,$v);

    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$t);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}//FinFunction

function writePropertiesParameter($x,$attribute,$query,$scalar=1,$prefix="") : array {
    global $dzn,$xpath;
    $q = $xpath->query($query);
    $t =[];
    if($attribute == "textContent"){
        //$t = array_map(function($e) {return $e->textContent;},iterator_to_array($q));
        //$t = [];
        foreach($q as $child){
            $tab = explode(",",$child->textContent);
            $type = "";
            $name = $child->getAttribute("name");
            if($name == "rooms"){
                $type = "label";
                $tab = array_map(function($e) use($type){return getRank($type,$e);},$tab);
            }
            elseif ( $name == "connectedRooms"){
                $type = "room";
                $tab = array_map(function($e) use($type){return getRank($type,$e);},$tab);

            }
            $t = array_merge($t,$tab);
        }
    }
    else{
        foreach($q as $child){
            $tab = explode(",",$child->textContent);
            $tab = array_map(function($e) use($child,$attribute){return $child->getAttribute($attribute);},$tab);
            $t = array_merge($t,$tab);

        }
    }
    print_r($t);
   
    $v = array1d_($t,$scalar,$prefix);
    $r ="";
    $tab = array1d($r,$v);
    fwrite($dzn,camel2Snake($x));
    assign($dzn);
    fwrite($dzn,$tab);
    semicolon($dzn);
    linefeed($dzn);
    return explode(",",$v);
}//FinFunction
/////////////////////////////////////////////////////////
// Label verification

function constructDicoOfLabel():array {
    global $xpath;
    $dictio = [];
    $qLabel = $xpath->query("//*[@label]");
    foreach($qLabel as $filter){
        $localLabel = $filter->getAttribute("label");
        $localTabLabel = explode(",",$localLabel);
        foreach($localTabLabel as $t){
            if(!in_array($t,$dictio)){
                $dictio[] = $t;
            }
        }
    }
    $v = [];
    foreach($dictio as $k=>$u) {$v[$k+1]=$u;}
    return $v;
}//FinFunction

function validationLabel($query):bool{
    global $xpath,$dico;
    //."[@attributeName=label]"
    //$dico = constructDicoOfLabel();
    $qLabelConstraint = $xpath->query($query."[@attributeName='label']"); 
    foreach($qLabelConstraint as $filter){
        $labelResult1 = $filter->getAttribute("in");
        $labelResult2 = $filter->getAttribute("notIn");
        if($labelResult1 && $labelResult2){
            exit("WARNING IN AND NOTIN IS COMPLEMENTARY");
        }
        $labelResult1.=$labelResult2;
        $tabLabelResult = explode(",",$labelResult1);
        foreach($tabLabelResult as $t){
            if(!in_array($t,$dico)){
                exit("WARNING LABEL IN FILTER DOESNT EXIST : $t \n ");
            }
        }
    }
    return true;

}//FinFunction

function verificationLabelAttribute($x):bool{
    global $xpath,$dico;
    //$dico = constructDicoOfLabel();
    $qLabelAttribute = $xpath->query("//*[@".$x."]");
    foreach($qLabelAttribute as $child){
        $res = $child->getAttribute($x);
        $resLabel = explode($x,",");
        foreach($resLabel as $labelResChild){
            if(!in_array($labelResChild,$dico)){
                exit("WARNING LABEL DOESNT EXIST : $labelResChild \n ");
            }
        }
    }
    return true;
}//FinFunction

function verificationLabelContent($x,$value=""):bool{
    //rooms
    global $xpath,$dico;
    $qAttributeChoose= "";
    if($value = ""){
        $qAttributeChoose = $xpath->query("//*[".$x."]");
    }
    else{
        $qAttributeChoose = $xpath->query("//*[@".$x."='".$value."']");
    }
    foreach($qAttributeChoose as $child){
        $res = $child->textContent;
        $resLabel = explode($x,",");
        foreach($resLabel as $labelResChild){
            if(!in_array($labelResChild,$dico)){
                exit("WARNING LABEL DOESNT EXIST : $labelResChild IN : $child->nodeName, $x $value \n ");
            }
        }
    }
    return true;
}//FinFunction

/////////////////////////////////////////////////////////
//

function verification_attribute($attribute_verif){
    global $xpath;
    $res = $xpath->query("//*[@".$attribute_verif."]");
    foreach($res as $child){
    $ref = $child->getAttribute($attribute_verif);
    $test = $xpath->query("//*[@".$attribute_verif."=\"".$ref."\"]");
    if($test->length > 1 ){
        $rem = $xpath->query("//".$test[0]->nodeName)->item(0)->parentNode;
        try{
            for($i=1;$i<$test->length;$i++){
                if($test[0]->nodeName != $test[$i]->nodeName){
                    throw new Exception('ERROR : incorrect type with same '.$attribute_verif);
                }
               /* else{
                    throw new Exception('ERROR : same '.$attribute_verif);
                }*/
            }
        }
            catch (Exception $e) {
                echo "WHO: ".$test[0]->nodeName.",".$test[$i]->nodeName.",".$ref."\n",  $e->getMessage(), "\n";
            }
        
    }
}
}

/////////////////////////////////////////////////////////
//

function parser_execute($nameXML,$nameOut,$ff):bool{
global $typeMap,$dzn,$xpath,$dico;

//$xmlfile =  $argv["1"];
$xmlfile =  $nameXML;
$xmlfilename = basename($xmlfile);
//$xmlfilename = "ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml";
//$xmlfile = __DIR__ . "/" . $xmlfilename;
$dznfilename =  substr($xmlfilename,0,-3)  . "dzn";
$dznfile = $dznfilename;
$dzn = fopen($dznfile,"w+");
//
$xml = new DOMDocument();
$xml->load($xmlfile);

/*TODO regler le bug
if ($xml->validate()) {
    echo "Le document est syntaxiquement valide dtd\n";
}
else{
    exit("DOCUMENT NOT CORRECT \n");
}
*/
/*if ($xml->schemaValidate("usp_timetabling_v0_1.xsd")) {
    echo "Le document est syntaxiquement valide xsd\n";
}
else{
    exit("DOCUMENT NOT CORRECT \n");
}*/


$xpath = new DOMXpath($xml);
$dico = constructDicoOfLabel();
validationLabel("//*");
verification_attribute("id");
verificationLabelContent("name","rooms");
//constructDicoOfLabel();

//
$qTimetabling = "/timetabling";
$qEquipments = "/timetabling/equipments/equipment";
$qRooms = "/timetabling/rooms/room";
$qTeachers = "/timetabling/teachers/teacher";
$qGroups = "/timetabling/groups/group";
$qCourses = "/timetabling/courses/course";
$qParts = "/timetabling/courses/course/part";
$qClasses = "/timetabling/courses/course/part/classes/class";
$qConstraintCollections = "/timetabling/constraints/constraintCollection";
$qSessions = "/timetabling/constraints/constraintCollection/sessions";
$qFilters = "/timetabling/constraints/constraintCollection/sessions/filter";
$qConstraints = "/timetabling/constraints/constraintCollection/constraint";
$qParameters = "/timetabling/constraints/constraintCollection/constraint/parameters/parameter";

$qPartEquipmentsSet = "//allowedEquipments";
$qPartEquipments = "//allowedEquipments/equipmentId";
$qPartRoomsSet = "//allowedRooms";
$qPartRooms = "//allowedRooms/room";
$qPartTeachersSet = "//allowedTeachers";
$qPartTeachers = "//allowedTeachers/teacher";
$qPartRoomMandatory = "//allowedRooms/room[@mandatory]";
$qPartSessionsTeacher = "//allowedTeachers[@sessionTeachers]";
$qLabel = "//*[@label]";

//
$timetabling = numbering($qTimetabling,FALSE);
$equipments = numbering($qEquipments);
$rooms = numbering($qRooms);
$teachers = numbering($qTeachers);
$groups = numbering($qGroups);
$courses = numbering($qCourses);
$parts = numbering($qParts);
$classes = numbering($qClasses);
$constraintCollections = numbering($qConstraintCollections,FALSE);
$sessions = numbering($qSessions,FALSE);
$filters = numbering($qFilters,FALSE);
$constraints = numbering($qConstraints,FALSE);
$parameters = numbering($qParameters,FALSE);
$labels = $dico;


//$filter = $xpath->query("//allowedRooms/room[@mandatory]/../..");
//$filter = $xpath->query("//room[not(./@mandatory = preceding::room/@mandatory)]");

//
$typeMap = [
    "timetabling" => $timetabling,
    "equipment" => $equipments,
    "room" => $rooms,
    "teacher" => $teachers,
    "group" => $groups,
    "course" => $courses,
    "part" => $parts,
    "class" => $classes,
    "constraintCollection" => $constraintCollections,
    "session" => $sessions,
    "filter" => $filters,
    "constraint" => $constraints,
    "parameter" => $parameters,
    "label" => $labels
];

//exit("exit");
//
comment($dzn,"HORIZON TEMPOREL");
linefeed($dzn);
$qry = $qTimetabling;
$x = "nrWeeks";
writeAttribute($x,$qry,1);
$x = "nrDaysPerWeek";
writeAttribute($x,$qry,1);
$x = "nrSlotsPerDay";
writeAttribute($x,$qry,1);

// 
linefeed($dzn);
comment($dzn,"DECOMPTE DES ELEMENTS PRINCIPAUX");
linefeed($dzn);
$x = "nrEquipments";
$qry = $qEquipments;
writeCount($x,$qry);
$x = "nrRooms";
$qry = $qRooms;
writeCount($x,$qry);
$x = "nrTeachers";
$qry = $qTeachers;
writeCount($x,$qry);
$x = "nrGroups";
$qry = $qGroups;
writeCount($x,$qry);
$x = "nrCourses";
$qry = $qCourses;
writeCount($x,$qry);
$x = "nrParts";
$qry = $qParts;
writeCount($x,$qry);
$x = "nrClasses";
$qry = $qClasses;
writeCount($x,$qry);
$x = "nrConstraints";
$qry = $qConstraintCollections;//!! mismatch names
writeCount($x,$qry);
$x = "nrLabels";
$qry = $qLabel;
writeSimpleInt($x,sizeof($dico));

//
linefeed($dzn);
comment($dzn,"DECOMPTE DES SOUS-ELEMENTS");
linefeed($dzn);
$x = "nrPartEquipments";
$qry = $qPartEquipments;
writeCount($x,$qry);
$x = "nrPartRooms";
$qry = $qPartRooms;
writeCount($x,$qry);
$x = "nrPartTeachers";
$qry = $qPartTeachers;
writeCount($x,$qry);
$x = "nrSessions";
$qry = $qSessions;
writeCount($x,$qry,"nrScopes");
$x = "nrFilters";
$qry = $qFilters;
$q = $xpath->query($qry);
writeCount($x,$qry);
$x = "nrParameters";
$qry = $qParameters;
writeCount($x,$qry);
//writeSimpleInt($x, array_reduce( iterator_to_array($xpath->query($qParameters)), function($carry, $item){$a = sizeof(explode(",",$item->textContent));return $carry+$a; } ));


$x = "nrPartRoomMandatory";
$qry = $qPartRoomMandatory;
writeCount($x,$qry);
$x = "nrPartSessionsTeacher";
$qry = $qPartSessionsTeacher;
writeCount($x,$qry);

//
linefeed($dzn);
comment($dzn,"DIMENSIONS");
linefeed($dzn);
$x = "maxSessionRank";
$qry = $qParts;
$a = "nrSessions";
$maxSessionRank=writeMaxBound($x,$qry,$a);
$x = "maxEquipmentCount";
$qry = $qEquipments;
$a = "count";
writeMaxBound($x,$qry,$a);
$x = "maxRoomCapacity";
$qry = $qRooms;
$a = "capacity";
writeMaxBound($x,$qry,$a);
/*$x = "maxTeacherCapacity";
$qry = $qPartTeachersSet;
$a = "studentsPerTeacher";
writeMaxBound($x,$qry,$a);*/
$x = "maxGroupSize";
$qry = $qGroups;
$a = "size";
writeMaxBound($x,$qry,$a);
$x = "maxPartEquipmentCount";
$qry = $qPartEquipments;
$a = "count";
writeMaxBound($x,$qry,$a);
$x = "maxPartRoomClassBound";
$qry = $qPartRooms;
$a = "max";
writeMaxBound($x,$qry,$a);
$x = "maxPartTeacherClassBound";
$qry = $qPartTeachers;
$a = "max";
writeMaxBound($x,$qry,$a);

$x = "maxElementParameter";
$qry = $qParameters;
$a = "textContent";
$maxElementParameter = writeMaxElementBound($x,$qry,$a);

//
/*
writeSubElementsSets(nameVariable,taille,Query,sous-element,numbering element,option)1=id 2=refId 3=txt 4=autre 
*/
linefeed($dzn);
comment($dzn,"RELATIONS ENTRE CLASSES D'ELEMENTS (STRUCTURELLES/ASSOCIATIVES)");
linefeed($dzn);
$x = "courseParts";
$r = "nrCourses";
$qry = $qCourses;
$subtag = "part";
writeSubElementsSets($x,$r,$qry,$subtag,$parts,1);
$x = "partClasses";
$r = "nrParts";
$qry = $qParts;
$subtag = "class";
writeSubElementsSets($x,$r,$qry,$subtag,$classes,1);
$x = "partEquipments";
$r = "nrParts";
$qry = $qParts;
$subtag = "equipment";
writeSubElementsSets($x,$r,$qry,$subtag,$equipments,2);
$x = "partRooms";
$r = "nrParts";
$qry = $qParts;
$subtag = "room";
writeSubElementsSets($x,$r,$qry,$subtag,$rooms,2);
$x = "partTeachers";
$r = "nrParts";
$qry = $qParts;
$subtag = "teacher";
writeSubElementsSets($x,$r,$qry,$subtag,$teachers,2);
$x = "classGroups";
$r = "nrClasses";
$qry = $qClasses;
$subtag = "group";
writeSubElementsSets($x,$r,$qry,$subtag,$groups,2);
$x = "constraintScopes";
$r = "nrConstraints";
$qry = $qConstraintCollections;
$subtag = "sessions";
writeSubElementsSets($x,$r,$qry,$subtag,$sessions,4);
$x = "scopeFilters";
$r = "nrScopes";
$qry = $qSessions;
$subtag = "filter";
writeSubElementsSets($x,$r,$qry,$subtag,$filters,4);
$x = "constraintFunction";
$r = "nrConstraints";
$qry = $qConstraints;
$a = "name";
writeAttributes($x,$r,$qry,$a,2);
$x = "functionParameters";
$r = "nrConstraints";
$qry = $qConstraints;
$subtag = "parameter";
writeSubElementsSets($x,$r,$qry,$subtag,$parameters,4);

$x = "roomLabel";
$r = "nrRoom";
$qry = $qRooms;
$a = "label";
//writeSubElementsSets($x,$r,$qry,$subtag,$labels,5);
writeElementsSets($x,$r,$qry,$a,$labels);

$x = "teacherLabel";
$r = "nrTeacher";
$qry = $qTeachers;
$a = "label";
//writeSubElementsSets($x,$r,$qry,$subtag,$labels,5);
writeElementsSets($x,$r,$qry,$a,$labels);

$x = "groupLabel";
$r = "nrGroup";
$qry = $qGroups;
$a = "label";
//writeSubElementsSets($x,$r,$qry,$subtag,$labels,5);
writeElementsSets($x,$r,$qry,$a,$labels);

$x = "courseLabel";
$r = "nrcourse";
$qry = $qCourses;
$a = "label";
//writeSubElementsSets($x,$r,$qry,$subtag,$labels,5);
writeElementsSets($x,$r,$qry,$a,$labels);

$x = "partLabel";
$r = "nrPart";
$qry = $qParts;
$a = "label";
//writeSubElementsSets($x,$r,$qry,$subtag,$labels,5);
writeElementsSets($x,$r,$qry,$a,$labels);

//
/*
* writeAttributes(nomVariable,taille,query,element,type)1=nombre,2=type def,3=string
 */
linefeed($dzn);
comment($dzn,"ATTRIBUTS DES CLASSES D'ELEMENTS");
linefeed($dzn);
$x = "equipmentName";
$r = "nrEquipments";
$qry = $qEquipments;
$a = "id";
writeAttributes($x,$r,$qry,$a,3);
$x = "equipmentCount";
$r = "nrEquipments";
$qry = $qEquipments;
$a = "count";
writeAttributes($x,$r,$qry,$a,1);
$x = "roomName";
$r = "nrRooms";
$qry = $qRooms;
$a = "id";
writeAttributes($x,$r,$qry,$a,3);
$x = "roomCapacity";
$r = "nrRooms";
$qry = $qRooms;
$a = "capacity";
writeAttributes($x,$r,$qry,$a,1);
$x = "teacherName";
$r = "nrTeachers";
$qry = $qTeachers;
$a = "id";
writeAttributes($x,$r,$qry,$a,3);
$x = "groupName";
$r = "nrGroups";
$qry = $qGroups;
$a = "id";
writeAttributes($x,$r,$qry,$a,3);
$x = "groupSize";
$r = "nrGroups";
$qry = $qGroups;
$a = "size";
writeAttributes($x,$r,$qry,$a,1);
$x = "courseName";
$r = "nrCourses";
$qry = $qCourses;
$a = "id";
writeAttributes($x,$r,$qry,$a,3);
$x = "partName";
$r = "nrParts";
$qry = $qParts;
$a = "id";
writeAttributes($x,$r,$qry,$a,3);

$x = "className";
$r = "nrClass";
$qry = $qClasses;
$a = "id";
writeAttributes($x,$r,$qry,$a,3);

$x = "labelName";
writeUttArray($x,$dico,3);

$x = "partNrSessions";
$r = "nrParts";
$qry = $qParts;
$a = "nrSessions";
writeAttributes($x,$r,$qry,$a,1);
$x = "partLength";
$r = "nrParts";
$qry = $qParts;
$a = "sessionLength";
writeAttributes($x,$r,$qry,$a,1);

$x = "partEquipmentCount";
$r = "nrPartEquipments";
$qry = $qPartEquipments;
$a = "count";
writeAttributes($x,$r,$qry,$a,1);
$x = "partRoomUse";
$r = "nrParts";
$qry = $qPartRoomsSet;
$a = "sessionRooms";
writeAttributes($x,$r,$qry,$a,2);

/*
$x = "partRoomClassBound";
$r1 = "nrPartRooms";
$r2="UTT_RESOURCE_BOUND";
$qry = $qPartRooms;
$a = ["min","max"];
writeAttributePairs($x,$r1,$r2,$qry,$a,1);
*/


$x = "partRoomMandatory";
$r1 = "nrPartRoomMandatory";
$r2 = "1..2";
$query = $qPartRoomMandatory;
$a = ["id","refId"];
writeAttributeParent($x,$r1,$r2,$query,$a,2);

/*$x = "parameterValue";
$qry = $qParameters;
$attribute = "textContent";
writePropertiesParameter($x,$attribute,$qry);*/

$x = "parameterName";
$r ="";
$qry = $qParameters;
$a = "name";
//writePropertiesParameter($x,$attribute,$qry,3);
writeParameterAttribute($x,$a,$qry,3);

$x = "parameterType";//TODO FAIRE GAFFE CEST PAS OBLIGATOIRE
$qry = $qParameters;
$a = "type";
//writePropertiesParameter($x,$attribute,$qry,3);
writeParameterAttribute($x,$a,$qry,3);


$x = "parameterValue";
$r1 = "nrParameters";
$r2 = "maxElementParameter";
$qry = $qParameters;
writePropertiesParameterPadding($x,$r1,$r2,$qry,$maxElementParameter,1);

//TODO STRUCT DONNEE

$x = "partSessionsTeacher";
$r = "nrParts";
$qry = $qPartTeachersSet;
$a = "sessionTeachers";
writeAttributes($x,$r,$qry,$a,1);
/* useless
$x = "partTeacherCapacity";
$r = "nrParts";
$qry = $qPartTeachersSet;
$a = "studentsPerTeacher";
writeAttributes($x,$r,$qry,$a,1);
*/
$x = "partTeacherSessionsCount";
$r = "nrPartTeachers";
$qry = $qPartTeachers;
$a = "nrSessions";
writeAttributes($x,$r,$qry,$a,1);

$x = "scopeClustering";
$r = "nrScopes";
$qry = $qSessions;
$a = "groupBy";
writeAttributes($x,$r,$qry,$a,2,"utt_");
$x = "scopeMask";
$r1 = "nrScopes";
$r2 = "maxSessionRank";
$qry = $qSessions;
$a = "sessionsMask";
writeMasks($x,$r1,$r2,$qry,$a,$maxSessionRank,1);
$x = "filterType";
$r = "nrFilters";
$qry = $qFilters;
$a = "type";
writeAttributes($x,$r,$qry,$a,2,"utt_");
$x = "filterElements";
$r = "nrFilters";
$qry = $qFilters;
writeFilters($x,$r,$qry);
$x = "functionType";
$r = "nrConstraints";
$qry = $qConstraints;
$a = "type";
writeAttributes($x,$r,$qry,$a,2,"utt_");
/*$x = "parameterValue";
$r = "nrParameters";
$qry = $qParameters;
writeValue($x,$r,$qry,1);*/

//
fclose($dzn);
return true;
}//FinFunction

$typeMap =0;
$dzn =0;
$xpath =0;
$dico =0;

?>
