<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/31/2022
 * Time: 12:33 AM
 */

namespace app\modules\apiV1\resources;


use app\models\DocumentLine;
use app\models\Documents;

class DocumentResource extends Documents
{
 public function fields()
 {
     return [
         'id','description','local_file_path','polling_station','created_at','lines'
     ];
 }
}