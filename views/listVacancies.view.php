<div class="container">
    <p>List of vacancies</p>
<table>
    <tr>
        <td>№</td>
        <td>links</td>

        <td>descript</td>

    </tr>
    <?php

    $page=$data['page'];
    $num=$data['num'];
    $countPage=$data['countPage'];
    $listVacancies=$data['listVacancies'];
    $descript= $data['listDescript'];
    $count=$data['count'];
    $n=$page*$num;

     for($i=$page*$num; $i<$page*$num+$num; $i++){
        $n++;
       if($n <= $count){
        ?>
        <tr>
            <td><?=$n?></td>
            <td> <a href="<?=$listVacancies[$i]['vacancy_url']?>"><?=$listVacancies[$i]['vacancy_url']?>
                 </a>
             </td>
            <td>
                <a href="/getVacancyDescription/<?=$listVacancies[$i]['id']?>">Get descript of the vacancy</a>
            </td>


        </tr>
    <?php }
    }?>
</table>
<div class="pagination">

    <?php pagination($countPage, '/listVacancies',$page);

    ?>
</div>
</div>