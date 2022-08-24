<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:27 PM
 */

namespace app\helpers;

use yii;
use yii\base\Component;

use Office365\Runtime\Auth\NetworkCredentialContext;
use Office365\SharePoint\ClientContext;
use Office365\Runtime\Auth\UserCredentials;
use Office365\Runtime\Auth\AuthenticationContext;
use Office365\Runtime\Http\RequestOptions;
use Office365\Runtime\ClientRuntimeContext;
use Office365\SharePoint\ListCreationInformation;
use Office365\SharePoint\SPList;
use Office365\SharePoint\Web;
use Office365\SharePoint\ListTemplateType;
use Office365\SharePoint\FileCreationInformation;
use Office365\SharePoint\File;
use stdClass;

class Sharepoint extends Component
{
    public function absoluteUrl()
    {
        return \yii\helpers\Url::home(true);
    }




    //SHAREPOINT UPLOAD
    public function sharepoint_attach($filepath, $libraryParts = '')
    {  //read list

        if ($libraryParts) {
            $targetLibraryTitle = "/sites/DocumentManagementSystem/" . env('SP_LIBRARY') . '/' . $libraryParts . '/' . basename($filepath);
        } else {
            $targetLibraryTitle = env('RSP_LIBRARY');
        }


        try {
            $localFilePath = realpath($filepath);
            $credentials = new UserCredentials(Yii::$app->params['sharepointUsername'], Yii::$app->params['sharepointPassword']);
            $ctx = (new ClientContext(Yii::$app->params['sharepointUrl']))->withCredentials($credentials);

            $fileCreationInformation = new FileCreationInformation();
            $fileCreationInformation->Content = file_get_contents($localFilePath);
            $fileCreationInformation->Url = basename($localFilePath);
            $uploadFile = $ctx->getWeb()
                ->getFolderByServerRelativeUrl(dirname($targetLibraryTitle))
                ->getFiles()
                ->add($fileCreationInformation);
            $ctx->executeQuery();
        } catch (\Exception $e) {
            throw new \yii\web\HttpException(500, 'Sharepoint Error: ' . $e->getMessage() . ' Path Given: ' . $targetLibraryTitle);
            // 'Authentication failed: ' . $e->getMessage() . "\n";
        }
    }

    // Prepare Download

    public function download($file)
    {

        $credentials = new UserCredentials(Yii::$app->params['sharepointUsername'], Yii::$app->params['sharepointPassword']);
        $ctx = (new ClientContext(Yii::$app->params['sharepointUrl']))->withCredentials($credentials);

        $content = $this->downloadFile($ctx, $file);
        return $content;
    }

    //Upload Files function

    private static function uploadFiles($localFilePath, SPList $targetList)
    {



        $ctx = $targetList->getContext();

        $session = Yii::$app->session;

        $fileCreationInformation = new FileCreationInformation();
        $fileCreationInformation->Content = file_get_contents($localFilePath);
        $fileCreationInformation->Url = basename($localFilePath);

        //print_r($fileCreationInformation); exit;
        $uploadFile = $targetList->getRootFolder()->getFiles()->add($fileCreationInformation);
        $ctx->executeQuery();
        // print "File {$uploadFile->getProperty('Name')} has been uploaded\r\n";

        $listEntity = $uploadFile->getListItemAllFields();
        $metadata = Yii::$app->session->get('metadata');
        if ($metadata) {
            // Yii::$app->recruitment->printrr($uploadFile->getListItemAllFields());
            $listEntity->setProperty('application', $metadata['Application']);
            $listEntity->setProperty('employee', $metadata['Employee']);
            $listEntity->setProperty('leavetype', $metadata['Leavetype']);
            $listEntity->update();
        }


        $ctx->executeQuery();

        // unset metadata session

        Yii::$app->session->remove('metadata');
    }

    function downloadFile(ClientRuntimeContext $ctx, $fileUrl)
    {
        try {
            $fileContent = \Office365\sharePoint\File::openBinary($ctx, $fileUrl);
            $base64 = base64_encode($fileContent);
            $size = getImageSizeFromString($fileContent);
            $mime = $size['mime'];
            return "data:" . $mime . ";base64," . $base64;
        } catch (\Exception $e) {
            return false;
            echo $e->getMessage();
        }
    }

    public static function ensureList(Web $web, $listTitle, $type, $clearItems = true)
    {
        $ctx = $web->getContext();
        $lists = $web->getLists()->filter("Title eq '$listTitle'")->top(1);
        $ctx->load($lists);
        $ctx->executeQuery();
        if ($lists->getCount() == 1) {
            $existingList = $lists->getData()[0];
            if ($clearItems) {
                //self::deleteListItems($existingList);
            }
            return $existingList;
        }
        //return ListExtensions::createList($web, $listTitle, $type);
        return ListExtensions::createList($web, $listTitle, $type);
    }

    /**
     * @param Web $web
     * @param $listTitle
     * @param $type
     * @return SPList
     * @internal param ClientRuntimeContext $ctx
     */
    public static function createList(Web $web, $listTitle, $type)
    {
        $ctx = $web->getContext();
        $info = new ListCreationInformation($listTitle);
        $info->BaseTemplate = $type;
        $list = $web->getLists()->add($info);
        $ctx->executeQuery();
        return $list;
    }

    /**
     * @param \Office365\PHP\Client\SharePoint\SPList $list
     */
    public static function deleteList(SPList $list)
    {
        $ctx = $list->getContext();
        $list->deleteObject();
        $ctx->executeQuery();
    }



    /*Sharepoint Authentication Context methods */


    function connectWithUserCredentials($url, $username, $password)
    {
        $authCtx = new AuthenticationContext($url);
        $authCtx->acquireTokenForUser($username, $password);
        $ctx = new ClientContext($url, $authCtx);
        return $ctx;
    }

    function connectWithNTLMAuth($url, $username, $password)
    {
        $authCtx = new NetworkCredentialContext($username, $password);
        $authCtx->AuthType = CURLAUTH_NTLM;
        $ctx = new ClientContext($url, $authCtx);
        return $ctx;
    }

    function connectWithAppOnlyToken($url, $clientId, $clientSecret)
    {
        $authCtx = new AuthenticationContext($url);
        $authCtx->acquireAppOnlyAccessToken($clientId, $clientSecret);
        $ctx = new ClientContext($url, $authCtx);
        return $ctx;
    }


    function connectWithUserToken($url, $username, $password)
    {
        $authCtx = new AuthenticationContext($url);
        $authCtx->acquireTokenForUser($username, $password);
        $ctx = new ClientContext($url, $authCtx);
        return $ctx;
    }
}
