<?php
if( $action == 'listVacancies'&& $idRout==null ) {
    $tableName = 'explorer';
    $query = [];
    $query['id'] = 'id';
    $query['query'] = 'explorer.query';
    $query['status'] = 'status';
    $vacancyLink = getSelect($db, $tableName, $query);

    if (isset($vacancyLink) && !empty($vacancyLink)) {
        $siteLinks = $vacancyLink[0]['query'];
        if (isset($siteLinks)) {
            $listVacancies = htmlParseVacanciesLinks($siteLinks);
            foreach ($listVacancies as $vacancy) {
                $insertVacancy = insertVacancy($db, $vacancyLink[0]['id'], $vacancy);
            }
            $explorerUpdate = saveStatus($db, $tableName, $vacancyLink[0]['id'], $query['status']);
        }
    }
        $tableName = 'vacancy';
        $id = 1;
        $data='explorer_id';
        $listVacancies = getSelectAll($db, $tableName, $data, $id);
        $listDescript = sql($db, "SELECT * FROM `vacancy_description`", [], 'rows');
        $count = count($listVacancies);
        $num = 10;
        $countPage = ceil($count / $num);
        $page = $_GET['page'] ?? 0;
        $viewname = 'listVacancies';

    view($viewname, $data = ['countPage' => $countPage, 'count' => $count, 'num' => $num, 'page' => $page, 'listVacancies' => $listVacancies, 'listDescript'=>$listDescript]);
}
