<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/31/2022
 * Time: 12:33 AM
 */

namespace app\modules\apiV1\resources;


use app\models\DocumentLine;

class DocumentLineResource extends DocumentLine
{
 public function fields()
 {
     return [
         'votes','created_at','polling_station_id','candidate'
     ];
 }
}