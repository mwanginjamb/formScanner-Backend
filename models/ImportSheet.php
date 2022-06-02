<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 11/16/2021
 * Time: 12:04 PM
 */

namespace app\models;

use Yii;
use yii\base\Model;

class ImportSheet extends  Model
{
    public $excel_doc;
    public $workplanID;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['workplanID', 'integer'],
            ['excel_doc', 'required'],
            [['excel_doc'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
            [['excel_doc'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx', 'mimeTypes' => 'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'message' => 'Only Spreadsheet documents are allowed.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'excel_doc' => 'Excel Template',

        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            Yii::$app->session->set('tempName', Yii::$app->security->generateRandomString(6));
            $placeholderName = Yii::$app->session->get('tempName');
            // Upload file here
            $this->excel_doc->saveAs('templates\\' . $placeholderName . '.' . $this->excel_doc->extension);

            return 'templates\\' . $placeholderName . '.' . $this->excel_doc->extension;
        } else {
            $this->addError('excel_doc', $this->errors['excel_doc'][0]);
            Yii::$app->session->setFlash('error', $this->errors['excel_doc'][0]);
        }
    }
}
