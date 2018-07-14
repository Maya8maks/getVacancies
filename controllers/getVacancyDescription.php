<?php
if( $action == 'getVacancyDescription' && $idRout ) {
    $tableName = 'vacancy_description';
    $id = $idRout;
    $col='vacancy_id';
    $description = getSelectAll($db, $tableName, $col, $id);

    if (!empty($description)) {
        $descr=$description[0]['description'];
         view('descriptOfVacancy', $data=['description'=>$descr, 'id'=>$idRout]);
    } else {
        $link = getLink($db, $idRout);
        $strDiscription = getDescript($link);

        if (isset($strDiscription)) {
            view('descriptOfVacancy',  $data=['description'=>$strDiscription, 'id'=>$idRout]);
            insertVacancyDescript($db, $idRout, $strDiscription);
            $vacancyApdate = saveStatus($db, 'vacancy', $idRout, 'vacancy_status');
        }

    }
}

