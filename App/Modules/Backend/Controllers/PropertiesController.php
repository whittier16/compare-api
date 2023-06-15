<?php
namespace App\Modules\Backend\Controllers;

use App\Common\Lib\Application\Controllers\RESTController,
    App\Common\Lib\Application\Exceptions\HTTPException;

class PropertiesController extends RESTController{

    protected $schemaDir;

    /**
     * Properties constructor
     */
    public function __construct(){
        $this->schemaDir = __DIR__ . $this->getDI()->getConfig()->application->jsonSchemaDir;
    }

 	/**
	 * @api {get} /properties GET /properties
	 * @apiExample Example usage:
	 * curl -H "X-COMPARE-REST-API-KEY: 1234567890" 
	 *      -i "http://apibeta.compargo.com/v1/properties/?countryCode=ph&language=en&
	 *          title=brands
	 *
	 * @apiDescription Read data of a Property
	 * @apiName        GetOne
	 * @apiGroup       Properties
	 *
	 * @apiHeader      {String} X-COMPARE-REST-API-KEY   Properties unique access-key.
	 *
	 * @apiParam       {String} language                 Mandatory Language.
	 * @apiParam       {String} countryCode              Mandatory Country Code.
	 * @apiParam       {String} title                    Mandatory Title.
	 * 
	 * @apiSuccess     {String} id                       ID of the Country. 
	 * 
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
     *       "$schema": "http://json-schema.org/draft-04/schema#",
     *       "title": "brands",
     *       "type": "object",
     *       "properties": {
     *       "name": {
     *          "label": "name",
     *          "type": "string",
     *          "validators": [
     *           {
     *               "rule": "minLength",
     *               "options": {
     *                   "min": 2
     *               },
     *              "message": "name must be greater than 2 characters long"
     *           },
     *           {
     *               "rule": "maxLength",
     *               "options": {
     *                   "max": 255
     *               },
     *               "message": "name must be less than 255 characters long"
     *           }
     *       ],
     *       "required": true
     *   },
     *   "alias": {
     *       "label": "alias",
     *       "type": "string",
     *       "validators": [
     *           {
     *               "rule": "minLength",
     *               "options": {
     *                   "min": 2
     *               },
     *               "message": "alias must be greater than 2 characters long"
     *           },
     *           {
     *               "rule": "maxLength",
     *               "options": {
     *                   "max": 255
     *               },
     *               "message": "alias must be less than 255 characters long"
     *           },
     *           {
     *               "rule": "slug",
     *               "options": {
     *                   "separator": "-"
     *               },
     *               "message": "alias must only have alpha-numeric and -"
     *           }
     *       ],
     *       "required": false
     *    }
     *}
	 *
	 * @apiError InvalidAccessToken The access token is invalid.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "InvalidAccessToken"
	 *     }
	 *
	 * @apiError MissingAuthenticationCredentials The authentication credentials are missing.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 401 Unauthorized
	 *     {
	 *       "error": "MissingAuthenticationCredentials"
	 *     }
	 *     
	 * @apiError PropertyNotFound The name of the Property was not found.
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "PropertyNotFound"
	 *     }
	 */
    public function getOne($title){
        $output = readJsonFromFile($this->schemaDir. $this->di->getConfig()->application->jsonSchema->$title);
        if (!empty($output)){
            $results = $output['properties'];
        } else{
            throw new HTTPException(
                "Not found",
                404,
                array(
                    'dev' => 'Property does not exist',
                    'internalCode' => 'P1000',
                    'more' => '' // Could have link to documentation here.
                )
            );
        }
        return $results;
    }
}