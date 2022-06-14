<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 5/31/2022
 * Time: 12:33 AM
 */

namespace app\modules\apiV1\resources;


use app\models\User;

class UserResource extends User
{
 public function fields()
 {
     return [
         'id','username','email','access_token','phone_number','otp','full_names'
     ];
 }

 public function extraFields()
 {
     return ['station','poll'];
 }


}