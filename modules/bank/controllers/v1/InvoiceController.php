<?php

namespace openecontmd\bank_api\modules\bank\controllers\v1;

use Yii;
use yii\rest\Controller;
use OpenApi\Annotations as OA;

use DateTime;
use Einvoicing\Invoice;
use Einvoicing\Presets;
use Einvoicing\Presets\Peppol;
use Einvoicing\Presets\CiusAtGov;
use Einvoicing\Presets\CiusRo;
use Einvoicing\Identifier;
use Einvoicing\Party;
use Einvoicing\InvoiceLine;
use Einvoicing\Writers\UblWriter;

use openecontmd\bank_api\models\BankInvoiceAPI;
use yii\web\HttpException;

class InvoiceController extends Controller
{
	public function __construct($id, $module, $config = [])
	{
		parent::__construct($id, $module, $config);
		return true;
	}

/** Get Available Actions
 * @OA\Post(
 *     path="/bank/v1/invoice",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Available Invoice Actions",
 *         @OA\JsonContent(
 *              @OA\Schema(ref="#/components/schemas/result_invoice"),
 *              @OA\Examples(example="result_invoice", value={
 "status": "OK",
 "data": {
 "available_invoice_actions": {"set-invoice-number", "set-issue-date", "set-due-date", "set-contact-name", "set-contact-email", "set-identifier"},
 "controller": "invoice",
 "entry_point": "https://api.open.e-cont.md/bank/v1/invoice/{action}"
 }
 }, summary="An result object."),
 *          )
 *     ),
 *
 *     @OA\Response(
 *         response="400",
 *         description="Bad Request",
 *         @OA\JsonContent(
 *              @OA\Schema(ref="#/components/schemas/result"),
 *              @OA\Examples(example="result_error", value={
 "status": "FAIL",
 "data": {
 "name": "Bad Request",
 "message": {"session_id":"ID сессии cannot be blank."},
 "code": 0,
 "status": 400,
 "type": "yii\web\BadRequestHttpException"
 }
 }, summary="An result error."),
 *          )
 *     ),
 * )
 */
	public function actionIndex()
	{
	    return [
	        'available_actions' => [
	            'set-invoice-number',
	            'set-issue-date',
	            'set-due-date',
	            'set-contact-name',
	            'set-contact-email',
	            'set-identifier'],
	        'controller' => 'invoice',
	        'entry_point' => 'https://api.open.e-cont.md/bank/v1/invoice/{action}',
	    ];
	}

/** Set Invoice Number
 * @OA\Post(
 *     path="/bank/v1/invoice/set-invoice-number",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Set invoice number",
 *     ),
 *     @OA\Parameter(
 *         name="invoice-number",
 *         in="query",
 *         description="Invoice number",
 *         required=true,
 *         @OA\Schema(
 *             default="ABC-123",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionSetInvoiceNumber()
	{
	    $response = [
	        'invoice-number' => 'ABC-123',
	        'action' => 'set',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Set Issue Date
 * @OA\Post(
 *     path="/bank/v1/invoice/set-issue-date",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Set issue date",
 *     ),
 *     @OA\Parameter(
 *         name="issue-date",
 *         in="query",
 *         description="Issue date",
 *         required=true,
 *         @OA\Schema(
 *             default="2023-08-08",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionSetIssueDate()
	{
	    $response = [
	        'issue-date' => '2023-08-08',
	        'action' => 'set',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Set Due Date
 * @OA\Post(
 *     path="/bank/v1/invoice/set-due-date",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Set due date",
 *     ),
 *     @OA\Parameter(
 *         name="due-date",
 *         in="query",
 *         description="Due date",
 *         required=true,
 *         @OA\Schema(
 *             default="2023-08-17",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionSetDueDate()
	{
	    $response = [
	        'due-date' => '2023-08-17',
	        'action' => 'set',
	        'status' => 'OK',
	    ];
	    return $response;
	}


/** Set Contact Name
 * @OA\Post(
 *     path="/bank/v1/invoice/set-contact-name",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Set contact name",
 *     ),
 *     @OA\Parameter(
 *         name="contact-name",
 *         in="query",
 *         description="Contact name",
 *         required=true,
 *         @OA\Schema(
 *             default="John Smith",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionSetContactName()
	{
	    $response = [
	        'contact-name' => 'John Smith',
	        'action' => 'set',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Set Contact E-Mail
 * @OA\Post(
 *     path="/bank/v1/invoice/set-contact-email",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Set contact email",
 *     ),
 *     @OA\Parameter(
 *         name="contact-email",
 *         in="query",
 *         description="Contact email",
 *         required=true,
 *         @OA\Schema(
 *             default="john.smith@email.test",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionSetcontacteEmail()
	{
	    $response = [
	        'contact-email' => 'john.smith@email.test',
	        'action' => 'set',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Set Identifier
 * @OA\Post(
 *     path="/bank/v1/invoice/set-identifier",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Set identifier",
 *     ),
 *     @OA\Parameter(
 *         name="identifier",
 *         in="query",
 *         description="Identifier",
 *         required=true,
 *         @OA\Schema(
 *             default="123456789012",
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="scheme",
 *         in="query",
 *         description="Scheme",
 *         required=true,
 *         @OA\Schema(
 *             default="0088",
 *             type="string",
 *         )
 *     )
 * )
 */
	public function actionSetIdentifier()
	{
	    $response = [
	        'identifier' => '123456789012',
	        'scheme' => '0088',
	        'action' => 'set',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Create Invoice
 * @OA\Post(
 *     path="/bank/v1/invoice/create-invoice",
 *     method="post",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Create invoice",
 *     ),
 *     @OA\Parameter(
 *         name="cius",
 *         in="query",
 *         description="CIUS Identifier",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             default="peppol",
 *         ),
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="ID (Invoice Number)",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             default="DIG-2023-00001",
 *         ),
 *     ),
 *     @OA\Parameter(
 *         name="issue_date",
 *         in="query",
 *         description="Issue Date",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             default="2023-08-15",
 *         ),
 *     ),
 *     @OA\Parameter(
 *         name="due_date",
 *         in="query",
 *         description="Due Date",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             default="2023-08-22",
 *         ),
 *     )
 * )
 */
	public function actionCreateInvoice()
	{
	    //$post = Yii::$app->request->post();
	    $get = Yii::$app->request->get();
	    $cius = Yii::$app->request->get('cius');
	    $id = Yii::$app->request->get('id');
	    $issue_date = Yii::$app->request->get('issue_date');
	    $sue_date = Yii::$app->request->get('due_date');

	    switch ($cius) {
	        default:
	        case 'peppol':
	            $inv = new Invoice(Presets\Peppol::class);
	            $cius_str = Peppol::getSpecification();
	            break;
	        case 'austria':
	            $inv = new Invoice(Presets\CiusAtGov::class);
	            $cius_str = CiusAtGov::getSpecification();
	            break;
	        case 'romania':
	            $inv = new Invoice(Presets\CiusRo::class);
	            $cius_str = CiusRo::getSpecification();
	            break;
	    }

	    //$inv->setNumber('F-202300012')
	    $inv->setNumber($id)
	    ->setIssueDate(new DateTime($issue_date))
	    ->setDueDate(new DateTime($sue_date));

	    $seller = new Party();
	    $seller->setContactName('Mr. Oleg Dynga');
	    $seller->setContactEmail('info@diginet.md');
	    $seller->setElectronicAddress(new Identifier('9482348239847239874', '0088'))
	    ->setCompanyId(new Identifier('AH88726', '0183'))
	    ->setName('Seller Name Ltd.')
	    ->setTradingName('Seller Name')
	    ->setVatNumber('ESA00000000')
	    ->setAddress(['Fake Street 123', 'Apartment Block 2B'])
	    ->setCity('Springfield')
	    ->setCountry('DE');
	    $inv->setSeller($seller);

	    $buyer = new Party();
	    $buyer->setElectronicAddress(new Identifier('ES12345', '0002'))
	    ->setName('Buyer Name Ltd.')
	    ->setCountry('FR');
	    $inv->setBuyer($buyer);

	    // 4 items priced at €40/unit + 16% VAT
	    $firstLine = new InvoiceLine();
	    $firstLine->setName('Product Name')
	    ->setPrice(40)
	    ->setVatRate(16)
	    ->setQuantity(4);
	    $inv->addLine($firstLine);

	    // 27 items price at €10 per 5 units + 4% VAT
	    $secondLine = new InvoiceLine();
	    $secondLine->setName('Line #2')
	    ->setDescription('The description for the second line')
	    ->setPrice(10, 5)
	    ->setQuantity(27)
	    ->setVatRate(4);
	    $inv->addLine($secondLine);

	    $ubl_writer = new UblWriter();
	    $ubl_document = $ubl_writer->export($inv);
	    //file_put_contents(__DIR__ . "/example.xml", $document);

	    $ubl_document = str_replace("\n", '', $ubl_document);
	    $ubl_document = str_replace('\"', '"', $ubl_document);


	    $r1 = BankInvoiceAPI::checkInvoiceByNumber($id);
	    if ($r1) {
	        throw new HttpException(401, 'Повторный номер инвойса');
	    }
	    else {
	        $uid = BankInvoiceAPI::createUid();
	        $r2 = BankInvoiceAPI::createInvoice($uid, $id, $ubl_document);
	    }

	    $response = [
	        'invoice_xml' => $ubl_document,
	        'cius' => $cius,
	        'id' => $id,
	        'uid' => $uid,
	        'ret1' => $r1, // == 1 ? 1 : 0,
	        'ret2' => $r2,
	        'action' => 'create',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Create Invoice By Object
 * @OA\Post(
 *     path="/bank/v1/invoice/create-invoice-by-object",
 *     tags={"bank"},
 *     summary="Create Invoice By Object",
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *         mediaType="application/json",
 *         @OA\Schema(
 *             ref="#/components/schemas/invoice_object"
 *         )
 *     )
 *   ),
 *     @OA\Response(
 *         response="200",
 *         description="Create invoice",
 *     )
 * )
 */
	public function actionCreateInvoiceByObject()
	{
	    $response = [
	        'action' => 'create',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Create Party By Object
 * @OA\Post(
 *     path="/bank/v1/invoice/create-party-by-object",
 *     tags={"bank"},
 *     summary="Create Party By Object",
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *         mediaType="application/json",
 *         @OA\Schema(
 *             ref="#/components/schemas/party_object"
 *         )
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Create invoice By Object",
 *     @OA\MediaType(
 *         mediaType="application/json",
 *         @OA\Schema(
 *             ref="#/components/schemas/result"
 *         )
 *       )
 *     )
 *   )
 * )
 */
	public function actionCreatePartyByObject()
	{
	    $response = [
	        'party_id' => 'b8d6adfbb1ece3937fb6318d8cc901c2',
	        'action' => 'create',
	        'status' => 'OK',
	    ];
	    return $response;
	}

/** Get Party By Id
 * @OA\Post(
 *     path="/bank/v1/invoice/get-party-by-id",
 *     method="post",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Get Party By Id",
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="ID (Party ID)",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             default="b8d6adfbb1ece3937fb6318d8cc901c2",
 *         )
 *     )
 * )
 */
	public function actionGetPartyById()
	{
	    $response = [
	        'party' => '{
  "electronic_address": {
    "value": "51370471",
    "scheme": "0000",
    "description": "CUIIO"
  },
  "company_id": {
    "value": "1029600052345",
    "scheme": "0001",
    "description": "IDNO"
  },
  "name": "Societatea cu Răspundere Limitată Network Solutions",
  "trading_name": "Network Solutions",
  "vat_number": "",
  "address": "sec. Ciocana, str. Mircea cel Bătrân bd., 17",
  "city": "mun. Chişinău",
  "country": "MD",
  "contact": {
    "name": "John Smith",
    "email": "office@ns.md",
    "phone": "+37369123456",
    "website": "https://ns.md"
  }
}',
	        'action' => 'create',
	        'status' => 'OK',
	    ];
	    return $response;
	}


/** Get Invoice by Number
 * @OA\Post(
 *     path="/bank/v1/invoice/get-invoice-by-number",
 *     method="post",
 *     tags={"bank"},
 *     @OA\Response(
 *         response="200",
 *         description="Get invoice",
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="ID (Invoice Number)",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             default="DIG-2023-00001",
 *         ),
 *     )
 * )
 */
	public function actionGetInvoiceByNumber()
	{
	    $id = Yii::$app->request->get('id');
	    $r1 = BankInvoiceAPI::getInvoiceByNumber($id);

	    if (!$r1) {
	        throw new HttpException(401, 'Такой инвойс отсутствует!', -1);
	    }

	    $response = [
	    //	        'invoice_xml' => $ubl_document,
//	        'cius' => $cius,
	        'id' => $id,
	        //	        'uid' => $uid,
	        'ret1' => $r1, // == 1 ? 1 : 0,
	        //	        'ret2' => $r2,
	        'action' => 'get',
	        'status' => 'OK',
	    ];
	    return $response;

	}

}

/*

=== Seller ===
{
  "electronic_address": {
    "value": "51370471",
    "scheme": "0000",
    "description": "CUIIO"
  },
  "company_id": {
    "value": "1029600052345",
    "scheme": "0001",
    "description": "IDNO"
  },
  "name": "Societatea cu Răspundere Limitată Network Solutions",
  "trading_name": "Network Solutions",
  "vat_number": "",
  "address": "sec. Ciocana, str. Mircea cel Bătrân bd., 17",
  "city": "mun. Chişinău",
  "country": "MD",
  "contact": {
    "name": "John Smith",
    "email": "office@ns.md",
    "phone": "+37369123456",
    "website": "https://ns.md"
  }
}

=== Buyer ===
{
  "electronic_address": {
    "value": "27545081",
    "scheme": "0000",
    "description": "CUIIO"
  },
  "company_id": {
    "value": "1022600037675",
    "scheme": "0001",
    "description": "IDNO"
  },
  "name": "SOCIETATEA PE ACŢIUNI TRANSPORT SERVICE",
  "trading_name": "TRANSPORT SERVICE",
  "vat_number": "7654321",
  "address": "sec. Rîşcani, str. Florilor, 21",
  "city": "mun. Chişinău",
  "country": "MD",
  "contact": {
    "name": "Anna Johnson",
    "email": "office@ts.com",
    "phone": "+37369234567",
    "website": "https://ts.com"
  }
}


=== Invoice ===
{
  "cius": "peppol",
  "id": "DIG-00005",
  "issue_date": "2023-08-21",
  "due_date": "2023-08-28",
  "currency": "EUR",
  "parties": {
    "seller": {
      "electronic_address": {
        "value": "51370471",
        "scheme": "0000",
        "description": "CUIIO"
      },
      "company_id": {
        "value": "1029600052345",
        "scheme": "0001",
        "description": "IDNO"
      },
      "name": "Societatea cu Răspundere Limitată Network Solutions",
      "trading_name": "Network Solutions",
      "vat_number": "",
      "address": "sec. Ciocana, str. Mircea cel Bătrân bd., 17",
      "city": "mun. Chişinău",
      "country": "MD",
      "contact": {
        "name": "John Smith",
        "email": "office@ns.md",
        "phone": "+37369123456",
        "website": "https://ns.md"
      }
    },
    "buyer": {
      "electronic_address": {
        "value": "27545081",
        "scheme": "0000",
        "description": "CUIIO"
      },
      "company_id": {
        "value": "1022600037675",
        "scheme": "0001",
        "description": "IDNO"
      },
      "name": "SOCIETATEA PE ACŢIUNI TRANSPORT SERVICE",
      "trading_name": "TRANSPORT SERVICE",
      "vat_number": "7654321",
      "address": "sec. Rîşcani, str. Florilor, 21",
      "city": "mun. Chişinău",
      "country": "MD",
      "contact": {
        "name": "Anna Johnson",
        "email": "office@ts.com",
        "phone": "+37369234567",
        "website": "https://ts.com"
      }
    }
  },
  "item_lines": [
    {
      "name": "Product Name",
      "description": null,
      "price": {
        "price": 40,
        "base_quantity": null
      },
      "vat_rate": 16,
      "quantity": 4
    },
    {
      "name": "Line #2",
      "description": "The description for the second line",
      "price": {
        "price": 10,
        "base_quantity": 5
      },
      "vat_rate": 4,
      "quantity": 27
    }
  ]
}



*/