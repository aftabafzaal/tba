<?php

namespace App\Functions;

class PayFlow {
    /*
      'live' => 'https://payflowpro.paypal.com',
      'test' => 'https://pilot-payflowpro.paypal.com',
     * 'live' => 'https://pilot-payflowpro.paypal.com:443',
      'test' => 'https://pilot-payflowpro.paypal.com:443',
     *      */

    private $vendor = '';
    private $partner = '';
    private $user = '';
    private $password = '';
    private $environment = 'live';
    private $billingType = '';
    private $gatewayURL = array(
        'live' => 'https://payflowpro.paypal.com',
        'test' => 'https://pilot-payflowpro.paypal.com:443',
    );
    private $NVP = array();
    private $response = '';

    public function __construct($vendor = '', $partner = '', $user = '', $password = '', $billingType = 'single') {


        $this->vendor = $this->truncateChars($vendor, 64);
        $this->partner = $this->truncateChars($partner, 64);
        $this->user = $this->truncateChars($user, 64);
        $this->password = $this->truncateChars($password, 32);
        $this->billingType = $billingType;

        $this->setupDefaults();
    }

    public function __destruct() {
        unset($this);
    }

    private function setupDefaults() {
        $defaults = array(
            'VENDOR' => $this->vendor,
            'PARTNER' => $this->partner,
            'USER' => $this->user,
            'PWD' => $this->password,
            'CUSTIP' => $_SERVER['REMOTE_ADDR'],
            'VERBOSITY' => 'MEDIUM',
        );

        $this->NVP = array_merge($this->NVP, $defaults);
    }

    public function setEnvironment($environment = 'test') {
        if (strtolower($environment) == 'test') {
            $this->environment = $this->gatewayURL['test'];
        } else {
            $this->environment = $this->gatewayURL['live'];
        }
        // echo $this->environment;
        // die;
    }

    public function getEnvironment() {
        return $this->environment;
    }

    public function setTransactionType($transactionType = 'S') {
        $type = array(
            'TRXTYPE' => strtoupper($transactionType),
        );

        $this->NVP = array_merge($this->NVP, $type);
    }

    public function setOptionalTransactionType($optionalTransactionType = 'S') {
        $type = array(
            'OPTIONALTRX' => strtoupper($optionalTransactionType),
        );

        $this->NVP = array_merge($this->NVP, $type);
    }

    public function setPaymentMethod($paymentMethod = 'C') {
        $method = array(
            'TENDER' => strtoupper($paymentMethod),
        );

        $this->NVP = array_merge($this->NVP, $method);
    }

    public function setPaymentCurrency($paymentCurrency = 'USD') {
        $currency = array(
            'CURRENCY' => strtoupper($paymentCurrency),
        );

        $this->NVP = array_merge($this->NVP, $currency);
    }

    public function setProfileAction($profileAction = 'A') {
        $action = array(
            'ACTION' => strtoupper($profileAction),
        );

        $this->NVP = array_merge($this->NVP, $action);
    }

    public function setProfileName($profileName = 'RecurringTransaction') {
        $name = array(
            'PROFILENAME' => strtoupper($profileName),
        );

        $this->NVP = array_merge($this->NVP, $name);
    }

    public function setProfileStartDate($profileStartDate = '') {
        if ($profileStartDate == '') {
            $profileStartDate = date('mdY', strtotime("+1 day"));
            ;
        }
        $date = array(
            'START' => strtoupper($profileStartDate),
        );

        $this->NVP = array_merge($this->NVP, $date);
    }

    public function setProfilePayPeriod($profilePayPeriod = 'MONT') {
        $period = array(
            'PAYPERIOD' => strtoupper($profilePayPeriod),
        );

        $this->NVP = array_merge($this->NVP, $period);
    }

    public function setProfileTerm($profileTerm = 0) {
        $term = array(
            'TERM' => strtoupper($profileTerm),
        );

        $this->NVP = array_merge($this->NVP, $term);
    }

    public function setAmount($amount = 0, $wholeAmt) {
        $amt = array(
            'AMT' => $this->cleanAmt($amount, $wholeAmt),
        );

        $this->NVP = array_merge($this->NVP, $amt);
    }

    public function setOptionalTransactionAmount($amount = 0, $wholeAmt) {
        $optAmt = array(
            'OPTIONALTRXAMT' => $this->cleanAmt($amount, $wholeAmt),
        );

        $this->NVP = array_merge($this->NVP, $optAmt);
    }

    public function setCCNumber($number = '') {
        $cc = array(
            'ACCT' => $this->cleanCCNumber($number),
        );

        $this->NVP = array_merge($this->NVP, $cc);
    }

    public function setFrequency($number = 30) {

        $frequency = array(
            'FREQUENCY' => $number,
        );
        //d($frequency,1);
        $this->NVP = array_merge($this->NVP, $frequency);
    }

    public function setInvoice($number = 123) {

        $invoice = array(
            'INVNUM' => $number,
        );
        $this->NVP = array_merge($this->NVP, $invoice);
    }

    public function setExpiration($expiration = '0000') {
        $exp = array(
            'EXPDATE' => $this->cleanExpDate($expiration),
        );

        $this->NVP = array_merge($this->NVP, $exp);
    }

    public function setCVV($cvv = '') {
        $security = array(
            'CVV2' => $cvv,
        );

        $this->NVP = array_merge($this->NVP, $security);
    }

    public function setProfileId($profileID = '') {
        $pId = array(
            'ORIGPROFILEID' => $profileID,
        );

        $this->NVP = array_merge($this->NVP, $pId);
    }

    public function setCreditCardName($cardName = '') {
        $name = array(
            'NAME' => $this->truncateChars($cardName, 50),
        );

        $this->NVP = array_merge($this->NVP, $name);
    }

    public function setCustomerFirstName($firstName = '') {
        $first = array(
            'FIRSTNAME' => $this->truncateChars($firstName, 30),
        );

        $this->NVP = array_merge($this->NVP, $first);
    }

    public function setCustomerLastName($lastName = '') {
        $last = array(
            'LASTNAME' => $this->truncateChars($lastName, 30),
        );

        $this->NVP = array_merge($this->NVP, $last);
    }

    public function setCustomerAddress($customerAddress = '') {
        $address = array(
            'STREET' => $this->truncateChars($customerAddress, 30),
        );

        $this->NVP = array_merge($this->NVP, $address);
    }

    public function setCustomerCity($customerCity = '') {
        $city = array(
            'CITY' => $this->truncateChars($customerCity, 20),
        );

        $this->NVP = array_merge($this->NVP, $city);
    }

    public function setCustomerState($customerState = '') {
        $state = array(
            'STATE' => $this->truncateChars($customerState, 2),
        );

        $this->NVP = array_merge($this->NVP, $state);
    }

    public function setCustomerZip($customerZip = '') {
        $zip = array(
            'ZIP' => $this->truncateChars($customerZip, 9),
        );

        $this->NVP = array_merge($this->NVP, $zip);
    }

    public function setCustomerCountry($customerCountry = '') {
        $country = array(
            'COUNTRY' => $this->truncateChars($customerCountry, 4),
        );

        $this->NVP = array_merge($this->NVP, $country);
    }

    public function setCustomerPhone($customerPhone = '000-000-0000') {
        $phone = array(
            'PHONENUM' => $this->truncateChars($this->cleanPhoneNumber($customerPhone), 20),
        );

        $this->NVP = array_merge($this->NVP, $phone);
    }

    public function setCustomerEmail($customerEmail = '') {
        $email = array(
            'EMAIl' => $this->truncateChars($customerEmail, 60),
        );

        $this->NVP = array_merge($this->NVP, $email);
    }

    public function setPaymentComment($description = '') {
        $desc = array(
            'COMMENT1' => $this->truncateChars($description, 128),
        );

        $this->NVP = array_merge($this->NVP, $desc);
    }

    public function setPaymentComment2($description = '') {
        $desc = array(
            'COMMENT2' => $this->truncateChars($description, 128),
        );

        $this->NVP = array_merge($this->NVP, $desc);
    }

    public function setCustomField($name = '', $value = '') {
        $custom = array(
            $name => (string) $value,
        );

        $this->NVP = array_merge($this->NVP, $custom);
    }

    private function getNVP() {
        $post = '';
        foreach ($this->NVP as $key => $value) {
            $post .= "$key=" . $value . "&";
        }
        return (string) rtrim($post, "& ");
    }

    public function processTransaction() {
        if (function_exists('curl_init') && extension_loaded('curl')) {
            $request = curl_init($this->getEnvironment()); // Initiate curl object
            curl_setopt($request, CURLOPT_HTTPHEADER, $this->getHeaders($this->NVP));
            curl_setopt($request, CURLOPT_HEADER, 1); // Set to 0 to eliminate header info from response
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
            curl_setopt($request, CURLOPT_TIMEOUT, 45); // times out after 45 secs      
            curl_setopt($request, CURLOPT_FORBID_REUSE, TRUE); //forces closure of connection when done 
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // Uncomment this line if you get no gateway response.
            curl_setopt($request, CURLOPT_POST, 1); //data sent as POST
            curl_setopt($request, CURLOPT_POSTFIELDS, $this->getNVP()); // Use HTTP POST to send the data
            $postResponse = curl_exec($request); // Execute curl post and store results in $post_response
            // Additional options may be required depending upon your server configuration
            // you can find documentation on curl options at http://www.php.net/curl_setopt
            curl_close($request); // close curl object
            // Get the response.
            $this->response = $postResponse;

            $this->response = $this->parseResults($this->response);
            //d($this->response,1);

            if (isset($this->response['RESULT']) && $this->response['RESULT'] == 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    private function getHeaders($params) {
        $headers[] = "Content-Type: text/namevalue";
        $headers[] = "X-VPS-Timeout: 30";
        $headers[] = "X-VPS-VIT-Client-Certification-Id: 33baf5893fc2123d8b191d2d011b7fdc"; // This header requirement will be removed
        $headers[] = "X-VPS-Request-ID: " . $this->getRequestId($params);
        return $headers;
    }

    private function getRequestId($params) {
        if (isset($params['ACCT'])) {
            $requestId = md5($params['ACCT'] . $params['AMT'] . date('YmdGis') . "1");
            return $requestId;
        } else {
            return md5(time());
        }
    }

    public function getResponse() {
        if ($this->response) {
            return $this->response;
        } else {
            return '';
        }
    }

    private function parseResults($result) {
        if (empty($result)) {
            return '';
        }

        $response = array();
        $result = strstr($result, 'RESULT');
        $value = explode('&', $result);
        foreach ($value as $token) {
            $key = explode('=', $token);
            $response[$key[0]] = $key[1];
        }
        return $response;
    }

    private function cleanAmt($amount = 0, $wholeAmt = FALSE) {
        if ($wholeAmt) {
            $amount = preg_replace('/[^0-9.]/', '', trim($amount));
            return (int) $amount;
        } else {
            $amount = preg_replace('/[^0-9.]/', '', trim($amount));
            return (float) $amount;
        }
    }

    private function cleanCCNumber($cc = '') {
        $cc = preg_replace('/[^0-9]/', '', trim($cc));
        return (string) $cc;
    }

    private function cleanPhoneNumber($phone = '') {
        $phone = preg_replace('/[^0-9]/', '', trim($phone));
        return (string) $phone;
    }

    private function cleanExpDate($exp = '') {
        $exp = preg_replace('/[^0-9]/', '', trim($exp));
        return (string) $exp;
    }

    private function truncateChars($string = '', $limit = 0) {
        return (string) trim($string);

        for ($i = 0; $i <= $limit AND $i < strlen($string); $i++) {
            $output .= $string[$i];
        }
        return (string) trim($output);
    }

    public function debugNVP($type = 'array') {
        if ($type == 'array') {
            return $this->NVP;
        } else {
            return $this->getNVP();
        }
    }

}

?>
