<?php
if($action=='getNewVacancies'&& $idRout==null){
    $explorerChange= changeStatus($db);
    $vacancyLink = getSelect($db, 'explorer', $query=['id'=>'id', 'query'=>'query', 'status'=>'status']);

    if (isset($vacancyLink) && !empty($vacancyLink)) {
        $siteLinks = $vacancyLink[0]['query'];
        if (isset($siteLinks)) {
            $listVacancies = htmlParseVacanciesLinks($siteLinks);
        }
        $id = 1;
        $listVacExist = getSelectVacancyUrl($db, 'vacancy', 'explorer_id', $id);
        $listUrl = [];
        if(isset($listVacExist)){
            foreach ($listVacExist as $item) {
                $listUrl[]=$item['vacancy_url'];
            }
            $newVacancies=(array_diff($listVacancies, $listUrl));
            foreach ($newVacancies as $newVacancy) {
                $insertVacancy = insertVacancy($db, $vacancyLink[0]['id'], $newVacancy);
            }
            $explorerUpdate = saveStatus($db, 'explorer', $vacancyLink[0]['id'], 'status');
        }
    }

    viewVacancies($db);

}