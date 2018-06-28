<?php
function getSelect($db, $tableName, $query )
{
    $res = sql($db, "SELECT {$query['id']} ,{$query['query']} FROM `$tableName` WHERE {$query['status']} = '0' LIMIT 1", [], 'rows');
    return $res;
}

function saveStatus($db, $tableName, $query, $columnStatus)
{
    $resrUpdate = sql($db,
        "UPDATE `$tableName` set 
        `$columnStatus` = 2  
        WHERE `id` =  $query"
    );
    return $resrUpdate;
}
 function getSelectAll($db, $tableName, $data, $id){
     $res = sql($db, "SELECT * FROM `$tableName` WHERE `$data`=".$id, [], 'rows');
     return $res;
 }

 function getLink($db, $idRout){
     $link = sql($db, "SELECT `vacancy_url` FROM `vacancy` WHERE `id` = $idRout", [], 'rows');
     return $link;
 }
function insertVacancy($db, $id, $vacancy){
    $insertVacancy = $db->prepare("INSERT INTO vacancy(`explorer_id`, `vacancy_url`,`vacancy_status`) VALUES (?, ?, ?)");
    $insertVacancy->execute(array($id, $vacancy, 0));
}
function insertVacancyDescript($db, $id, $strDiscription){
    $insertVacancyDescript = $db->prepare("INSERT INTO vacancy_description(`vacancy_id`, `description`,`status`) VALUES (?, ?, ?)");
    $insertVacancyDescript->execute(array($id, $strDiscription, 0));
}
function insertWord($db, $id, $word, $number){
$insertWords = $db->prepare("INSERT INTO vacancy_words(`vacancy_description_id`, `word`,`qty`, `skill_id`, `type`) VALUES (?, ?, ?, ?, ?)");
$insertWords->execute(array($id, $word, $number, 0, 0));
}



function deleteLink($db, $id){
    $link = sql( $db, 'DELETE  FROM `vacancy` 
    WHERE `id`='.$id,
        []
    );
    return $link;
}