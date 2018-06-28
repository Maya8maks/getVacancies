<?php

if( $action == 'convertVacancy') {

  $tableName = 'vacancy_description';
    $id = $idRout ?? $data['id'];
    $data = 'vacancy_id';

    $descriptionConvert = getSelectAll($db, $tableName, $data, $id);

    $stringDescript=($descriptionConvert[0]['description']);

    if (!empty($stringDescript)) {

            if (isset($stringDescript)) {

                $descriptWordUniq = getWords($stringDescript);
                    if ($descriptionConvert[0]['status'] != 2) {
                        foreach ($descriptWordUniq as $word => $number) {
                            $insertWords = insertWord($db, $descriptionConvert[0]['id'], $word, $number);
                        }
                    $vacancyUpdate = saveStatus($db, $tableName, $descriptionConvert[0]['id'], 'status');
                }
            }

       view('convert', $descriptWordUniq);

          }

 }


