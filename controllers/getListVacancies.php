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
    viewVacancies($db);
}
