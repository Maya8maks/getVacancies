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
if( $action == 'getVacancyDescription'&& $idRout==null ) {
    $tableName = 'vacancy';
    $query = [];
    $query['id'] = 'id';
    $query['query'] = 'vacancy_url';
    $query['status'] = 'vacancy_status';
    $vacancyDescriptLink = getSelect($db, $tableName, $query);

        if (!empty($vacancyDescriptLink)) {

            $strDiscription = getDescript($vacancyDescriptLink);
            if (!empty($strDiscription)) {

                view('descriptOfVacancy', $data=['description'=>$strDiscription, 'id'=>$vacancyDescriptLink[0]['id']]);
                insertVacancyDescript($db, $vacancyDescriptLink[0]['id'], $strDiscription);
                $vacancyApdate = saveStatus($db, $tableName, $vacancyDescriptLink[0]['id'],'vacancy_status');

            }
            else {
                $id=$vacancyDescriptLink[0]['id'];
                deleteLink($db, $id);
                view('error');

            }
        }
    }
