<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Cards;
use App\User;
use App\Role;
use App\Address;
use App\PaymentPayflow;
use App\Transactions;
use App\PayflowProfiles;
use App\Functions\Payflow;
use DB;

class TestController extends Controller {

    private $_api_context;

    public function __construct() {
        // $paypal_conf = Config::get('paypal');
        // $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['express']['client_id'], $paypal_conf['express']['secret']));
        // $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function index() {


        $id = 29;
        $currency = Config('params.currency_default');
        $amount = Config('params.athlete_fee');
        
        
        $transaction = Transactions::find($id);
        $user_id = $transaction->type_id;
        $transactionSubscription = Transactions::where('type_id', $user_id)->where('type', 'subscription')->first();


        $card = Cards::where('user_id', $user_id)->first();
        $expDate=$cards->expDate;
        $cvc=$cards->cvc;
        $cc=$cards->cc;
        $name=$cards->name;
        
        
        $user=User::find($user_id);
        $firstName=$user->firstName;
        $lastName=$user->lastName;
        
        

        $address = Address::where('user_id', '=', $user_id)->first();
d($address,1);
        $PayFlow = new PayFlow(env('PAYFLOW_VENDOR'), env('PAYFLOW_PARTNER'), env('PAYFLOW_USER'), env('PAYFLOW_PASSWORD'), 'single');


        $PayFlow->setEnvironment(env('PAYFLOW_ENV'));                           // test or live
        $PayFlow->setTransactionType('S');
        $PayFlow->setPaymentMethod('C');
        $PayFlow->setPaymentCurrency($currency);
        $PayFlow->setAmount($amount, FALSE);
        $PayFlow->setCCNumber($cc);
        $PayFlow->setCVV($cvc);
        $PayFlow->setExpiration($expDate);
        $PayFlow->setCreditCardName($name);
        $PayFlow->setCustomerFirstName($firstName);
        $PayFlow->setCustomerLastName($lastName);
        $PayFlow->setCustomerAddress($address->address . ' - ' . $address->address2);
        $PayFlow->setCustomerCity($address->city);
        $PayFlow->setCustomerState($address->state);
        $PayFlow->setCustomerZip($address->zip);
        $PayFlow->setCustomerCountry('US');
        $PayFlow->setCustomerPhone($address->phone);
        $PayFlow->setCustomerEmail(Auth::user()->email);
        $PayFlow->setPaymentComment('user ID # ' . Auth::user()->id);
        $PayFlow->setPaymentComment2('Email ' . Auth::user()->email);


        d($PayFlow, 1);

        /*
         * 
          if(count($transactionSubscription)==0)
          {
          $model = new Transactions();
          $model->referenceId = $response['RPREF'];
          $model->gateway = 'payflow';
          $model->type_id = Auth::user()->id;
          $model->type = 'subscription';
          $model->amount = $subscriptionRate;
          $model->created_at = date('Y-m-d H:i:s');
          $model->save();
          }
         * 
         */

        d($transactionSubscription, 1);




        // Single Transaction
        $PayFlow = new PayFlow(env('PAYFLOW_VENDOR'), env('PAYFLOW_PARTNER'), env('PAYFLOW_USER'), env('PAYFLOW_PASSWORD'), 'single');

        $PayFlow->setEnvironment(env('PAYFLOW_ENV'));                           // test or live
        $PayFlow->setTransactionType('S');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
        $PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
        $PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.

        $PayFlow->setAmount('15.00', FALSE);
        $PayFlow->setCCNumber('378282246310005');
        $PayFlow->setCVV('4685');
        $PayFlow->setExpiration('1112');
        $PayFlow->setCreditCardName('Richard Castera');

        $PayFlow->setCustomerFirstName('Richard');
        $PayFlow->setCustomerLastName('Castera');
        $PayFlow->setCustomerAddress('589 8th Ave Suite 10');
        $PayFlow->setCustomerCity('New York');
        $PayFlow->setCustomerState('NY');
        $PayFlow->setCustomerZip('10018');
        $PayFlow->setCustomerCountry('US');
        $PayFlow->setCustomerPhone('212-123-1234');
        $PayFlow->setCustomerEmail('richard.castera@gmail.com');
        $PayFlow->setPaymentComment('New Regular Transaction');
        $PayFlow->setPaymentComment2('Product 233');

        if ($PayFlow->processTransaction()):
            echo('Transaction Processed Successfully!');
        else:
            echo('Transaction could not be processed at this time.');
        endif;

        echo('<h2>Name Value Pair String:</h2>');
        d($PayFlow->debugNVP('array'));

        echo('<h2>Response From Paypal:</h2>');
        d($PayFlow->getResponse());
        unset($PayFlow);
    }

    public function indexE() {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') // item name
                ->setCurrency('USD')
                ->setQuantity(2)
                ->setPrice('15'); // unit price
        $item_2 = new Item();
        $item_2->setName('Item 2')
                ->setCurrency('USD')
                ->setQuantity(4)
                ->setPrice('7');
        $item_3 = new Item();
        $item_3->setName('Item 3')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice('20');
        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item_1, $item_2, $item_3));
        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal(78);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('athlete/cancel'))
                ->setCancelUrl(url('athlete/cancel'));
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            // redirect to paypal
            return Redirect::away($redirect_url);
        }
        return Redirect::route('original.route')
                        ->with('error', 'Unknown error occurred');
        die("asdasd");
    }

}
