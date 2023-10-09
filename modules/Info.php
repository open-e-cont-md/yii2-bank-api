<?php

namespace openecontmd\bank_api\modules;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\SecurityScheme(
 *   securityScheme="basicAuth",
 *   type="http",
 *   scheme="basic"
 * )
 *
 * @OA\Info(
 *   version="1.2.02",
 *   title="Open.e-Cont.md API",
 *   description="API of project Open.e-Cont.md",
 *   @OA\Contact(name="Diginet Pro API Team",url="https://open.e-cont.md",email="open.econt.md@gmail.com")
 * )
 *
 * @OA\OpenApi(
 *   security={{"basicAuth": {}}},
 *   x={
 *       "tagGroups"=
 *           {{"name"="Exaample Grouping", "tags"={"Alert API", "Bank API"}}
 *       }
 *   }
 * )
 *
 * @OA\Tag(
 *     name="internal",
 *     description="1. API for Module for Invoice Repository internal operations"
 * )
 * @OA\Tag(
 *     name="external",
 *     description="2. API for Inter-connector to external Invoice Repository"
 * )
 * @OA\Tag(
 *     name="client",
 *     description="3. API for Connector to Client Application"
 * )
 * @OA\Tag(
 *     name="bank",
 *     description="4. API for Connector to Bank Systems (regular bank transfer)"
 * )
 * @OA\Tag(
 *     name="payment",
 *     description="5. API Connector to External Online payment gateway"
 * )
 * @OA\Tag(
 *     name="doc",
 *     description="6. API for client.docs.open.e-cont.md"
 * )
 * @OA\Tag(
 *     name="alert",
 *     description="7. API for Alert and Notification Module"
 * )
 * @OA\Server(
 *     url="https://api.open.e-cont.md",
 *     description="Open.e-Cont.md API Stage Server"
 * )
 * @OA\Server(
 *     url="http://api-docs.open.e-cont.tst",
 *     description="Open.e-Cont.md API Debug Server"
 * )
 * @OA\ExternalDocumentation(
 *     description="More detailed documentation on the Open.e-Cont.md API",
 *     url="https://github.com/open-e-cont-md/open-e-cont-md.github.io"
 * )
 * @OA\Schema(
 *   schema="result",
 *   type="object",
 *   format="json",
 *   description="Result Object"
 * )
 * @OA\Schema(
 *   schema="result_invoice",
 *   type="object",
 *   format="json",
 *   description="Invoice Result Object"
 * )
 * @OA\Schema(
 *   schema="error",
 *   type="object",
 *   format="json",
 *   description="Error Object"
 * )
 * @OA\Property(
 *   property="value",
 *   type="integer",
 *   format="int32"
 * )
 * @OA\Property(
 *   property="available_actions",
 *   type="array",
 *   example={"check", "info", "spend"},
 *   @OA\Items(
 *       type="string"
 *   )
 * )
 * @OA\Property(
 *   property="available_invoice_actions",
 *   type="array",
 *   example={"set-invoice-number", "set-contact-name", "set-contact-email", "set-identifier"},
 *   @OA\Items(
 *       type="string"
 *   )
 * )
 * @OA\Schema(
 *   schema="invoice_object",
 *   type="object",
 *   format="json",
 *   description="Invoice Object",
 *   default="",
 *   example="{
  ""cius"": ""peppol"",
  ""id"": ""DIG-00005"",
  ""issue_date"": ""2023-08-21"",
  ""due_date"": ""2023-08-28"",
  ""currency"": ""EUR"",
  ""parties"": {
    ""seller"": {
      ""electronic_address"": {
        ""value"": ""51370471"",
        ""scheme"": ""0000"",
        ""description"": ""CUIIO""
      },
      ""company_id"": {
        ""value"": ""1029600052345"",
        ""scheme"": ""0001"",
        ""description"": ""IDNO""
      },
      ""name"": ""Societatea cu Răspundere Limitată Network Solutions"",
      ""trading_name"": ""Network Solutions"",
      ""vat_number"": """",
      ""address"": ""sec. Ciocana, str. Mircea cel Bătrân bd., 17"",
      ""city"": ""mun. Chişinău"",
      ""country"": ""MD"",
      ""contact"": {
        ""name"": ""John Smith"",
        ""email"": ""office@ns.md"",
        ""phone"": ""+37369123456"",
        ""website"": ""https://ns.md""
      }
    },
    ""buyer"": {
      ""electronic_address"": {
        ""value"": ""27545081"",
        ""scheme"": ""0000"",
        ""description"": ""CUIIO""
      },
      ""company_id"": {
        ""value"": ""1022600037675"",
        ""scheme"": ""0001"",
        ""description"": ""IDNO""
      },
      ""name"": ""SOCIETATEA PE ACŢIUNI TRANSPORT SERVICE"",
      ""trading_name"": ""TRANSPORT SERVICE"",
      ""vat_number"": ""7654321"",
      ""address"": ""sec. Rîşcani, str. Florilor, 21"",
      ""city"": ""mun. Chişinău"",
      ""country"": ""MD"",
      ""contact"": {
        ""name"": ""Anna Johnson"",
        ""email"": ""office@ts.com"",
        ""phone"": ""+37369234567"",
        ""website"": ""https://ts.com""
      }
    }
  },
  ""item_lines"": [
    {
      ""name"": ""Product Name"",
      ""description"": null,
      ""price"": {
        ""price"": 40,
        ""base_quantity"": null
      },
      ""vat_rate"": 16,
      ""quantity"": 4
    },
    {
      ""name"": ""Line #2"",
      ""description"": ""The description for the second line"",
      ""price"": {
        ""price"": 10,
        ""base_quantity"": 5
      },
      ""vat_rate"": 4,
      ""quantity"": 27
    }
  ]
}"
 * )
 * @OA\Schema(
 *   schema="party_object",
 *   type="object",
 *   format="json",
 *   description="Party Object",
 *   default="",
 *   example="{
  ""electronic_address"": {
    ""value"": ""51370471"",
    ""scheme"": ""0000"",
    ""description"": ""CUIIO""
  },
  ""company_id"": {
    ""value"": ""1029600052345"",
    ""scheme"": ""0001"",
    ""description"": ""IDNO""
  },
  ""name"": ""Societatea cu Răspundere Limitată Network Solutions"",
  ""trading_name"": ""Network Solutions"",
  ""vat_number"": """",
  ""address"": ""sec. Ciocana, str. Mircea cel Bătrân bd., 17"",
  ""city"": ""mun. Chişinău"",
  ""country"": ""MD"",
  ""contact"": {
    ""name"": ""John Smith"",
    ""email"": ""office@ns.md"",
    ""phone"": ""+37369123456"",
    ""website"": ""https://ns.md""
  }
}"
 * )
 *
 */

class Info
{
}


/*

ReqBin HTTP Client

http://api-docs.open.e-cont.tst/alert/v1/sys

token=123123123
request_id=8976655
session_id=jg45jhg54354

??? composer dump-autoload --optimize

/var/www/DIGINET/api.tst/vendor/zircote/swagger-php/bin/openapi /var/www/DIGINET/api.tst/modules/ -o /var/www/DIGINET/api.tst/web/api-doc/api-open-econt-md.json

http://api-docs.open.e-cont.tst/api-doc/api-open-econt-md.json


 * @OA\Tag(
 *     name="Alert API",
 *     description="Alert and notification operations"
 * )
 * @OA\Tag(
 *     name="Internal API",
 *     description="Internal repository operations"
 * )
 * @OA\Tag(
 *     name="External API",
 *     description="External repository operations"
 * )
 * @OA\Tag(
 *     name="Bank API",
 *     description="Bank payment operations"
 * )
 *
 *
 *
 * * @OA\SecurityScheme(
 *     type="apiKey",
 *     name="api_key",
 *     in="header",
 *     securitySapi_key="basic"
 * )
 *
 * @OA\SecurityScheme(
 *   type="oauth2",
 *   securityScheme="petstore_auth",
 *   @OA\Flow(
 *      authorizationUrl="http://petstore.swagger.io/oauth/dialog",
 *      flow="implicit",
 *      scopes={
 *         "read:pets": "read your pets",
 *         "write:pets": "modify pets in your account"
 *      }
 *   )
 * )
 *
 *
 * @OA\SecurityScheme(
 *   securityScheme="token",
 *   type="apiKey",
 *   name="Authorization: Bearer",
 *   in="header"
 * )
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer"
 * )
 *
 *     @OA\Parameter(name="token",in="query",required=true,@OA\Schema(default="123123123",type="string"),description="Security Token"),
 *     @OA\Parameter(name="request_id",in="query",required=true,@OA\Schema(type="string"),description="Random Request ID (hash)"),
 *     @OA\Parameter(name="session_id",in="query",required=true,@OA\Schema(type="string"),description="Unique Session ID (for Reference)")
 *
 *
 *
 *      * @OpenAPIDefinition(
 *     info=@OA\Info(
 *     version="1.1.25",
 *     title="Open.e-Cont.md API",
 *     description="API of project Open.e-Cont.md",
 *     @OA\Contact(name="Diginet Pro API Team",url="https://open.e-cont.md",email="open.econt.md@gmail.com")
 *   )
 * )
 *
 *
 *
 *
*/
