<?php

//      http://api-docs.open.e-cont.tst/test/peppol

namespace openecontmd\bank_api\controllers;

//use Yii;
//use yii\filters\AccessControl;
use yii\web\Controller;
//use yii\web\Response;
//use yii\filters\VerbFilter;
//use app\models\LoginForm;
//use app\models\ContactForm;

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

class InvoiceController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest($cius = 'peppol')
    {
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

        $inv->setNumber('F-202300012')
        ->setIssueDate(new DateTime('2023-08-03'))
        ->setDueDate(new DateTime('2023-08-17'));

        $identifier = new Identifier('9482348239847239874', '0088');

        $seller = new Party();
        $seller->setContactName('Mr. Oleg Dynga');
        $seller->setContactEmail('info@diginet.md');
        $seller->setElectronicAddress($identifier)
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

        return $this->render('index', [
            'identifier' => $identifier,
            'seller' => $seller,
            'invoice' => $inv,
            'ubl_document' => $ubl_document,
            'cius_str' => $cius_str
        ]);
    }

}
