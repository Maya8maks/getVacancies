<?php
function htmlParseVacanciesLinks($siteLinks){
    $htmlLinks = file_get_html($siteLinks);

    foreach ($htmlLinks->find('nav a[title]') as $element) {
    }
    $lastPage = $element->plaintext;

    $listPages = [];
    for ($i = 1; $i <= $lastPage; $i++) {
        $listPages[] = $siteLinks . '/?page=' . $i;
    }

    $listVacancies = [];
    foreach ($listPages as $htmlPage) {
        foreach (file_get_html($htmlPage)->find('h2.add-bottom-sm a') as $element) {
            $listVacancies[] = 'https://www.work.ua' . str_replace('/ua', '', $element->href);
        }
    }
    return $listVacancies;
}

function cleanString($stringDescript){
    $stringDescript = trim($stringDescript);
    /*замінюю спецсимволи на пробел*/
    $stringDescript = preg_replace("~(\\\|\*|\.|\;|\:|\—|\«|\»|\"|\&|\/|\<|\>|\#|\@|\(|\)|\?|'\?|\!|\,|\[|\?|\]|\(|\\\$|\))~", " ", $stringDescript);

    /*замінюю &nbsp*/
    $stringDescript = htmlentities($stringDescript);
    $stringDescript= str_replace("&nbsp;",' ',$stringDescript);

    $stringDescript = str_replace("\r\n", ' ', $stringDescript);

    /*видаляю лишні пробели*/
    $stringDescript = preg_replace("/ +/", " ", $stringDescript);

    $stringDescriptLow = mb_strtolower($stringDescript);
    return $stringDescriptLow;
}
function pagination( $pagesCount, $section, $page ) {

    for( $p=0; $p < $pagesCount; $p++) {
        $curPage = $page;
        if (($p < $curPage + 3 && $p > $curPage - 3)
            || ($p == 0)
            || ($p == $pagesCount - 1)
        ) {
            echo '<a href="'.$section.'?page='.$p.'">';
            echo ($curPage == $p) ? '<strong>' : '';
            echo $p + 1;
            echo ($curPage == $p) ? '</strong>' : '';
            echo '</a> |';
        }
    }
}

function getDescript($vacancyDescriptLink)
{
    $site = $vacancyDescriptLink[0]['vacancy_url'];
    if (isset($site)) {
        $html = file_get_html($site);
        $vacDiscript = [];
        foreach (($html->find('div.wordwrap p, div.wordwrap li')) as $elem) {
            if ($elem->find('*[class]')) {
                continue;
            } else {
                if (empty($elem->children())) {
                    $vacDiscript[] = strip_tags($elem->outertext . PHP_EOL);
                } else {
                    foreach ($elem->children() as $child) {
                        if ($child->find('*[class]')) {
                            continue;
                        } else {
                            $vacDiscript[] = strip_tags($child->outertext . PHP_EOL);
                        }
                    }
                }
            }
        }

        $strDiscription = implode('', $vacDiscript);

    }
    return $strDiscription;
}

function getWords($stringDescript){
 $stringDescriptLow = cleanString($stringDescript);

            $arrWords = explode(" ", $stringDescriptLow);

            $descriptWord = [];
            $maxWordLength = 2;
            foreach ($arrWords as $word) {
                if (mb_strlen($word) > $maxWordLength) {
                    $descriptWord[] = trim($word);
                }
            }

            $result = array_unique($descriptWord);

            $descriptWordUniq = [];
            $n = 0;
            foreach ($result as $key => $item) {
                $descriptWordUniq[$item] = $n;
            }

            foreach ($descriptWordUniq as $word => $number) {
                foreach ($descriptWord as $elem) {
                    if ($word == $elem) {
                        $descriptWordUniq[$word] = ++$number;

                    }
                }
            }
            return $descriptWordUniq;
            }

function view($viewname, $data = []){
    include "views/main.view.php";

    if( file_exists( "views/$viewname.view.php" ) ) {
        include "views/$viewname.view.php";
    }
}

function viewVacancies($db){
    $id = 1;
    $listVacancies = getSelectAll($db, 'vacancy', 'explorer_id', $id);
    $listDescript = sql($db, "SELECT * FROM `vacancy_description`", [], 'rows');
    $count = count($listVacancies);
    $num = 20;
    $countPage = ceil($count / $num);
    $page = $_GET['page'] ?? 0;
    $viewname = 'listVacancies';
    view($viewname, $data = ['countPage' => $countPage, 'count' => $count, 'num' => $num, 'page' => $page, 'listVacancies' => $listVacancies, 'listDescript'=>$listDescript]);
}
