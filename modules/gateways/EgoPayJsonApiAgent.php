<?php
require_once 'EgoPayApiAgentInterface.php';

class EgoPayJsonApiAgent implements EgoPayApiAgentInterface
{
    const VERSION = '1.2';
    
    const EGOPAY_API_PAYMENT_URL = "https://www.egopay.com/api/json/";
    
    private $_oAuth;
    
    public function __construct(EgoPayAuth $a)
    {
        $this->_oAuth = $a;    
    }
    
    public function getBalance($sCurrency = null)
    {
        $sResponse = $this->_getResponse('balance');
        $oBalance = $this->_parseResponse($sResponse);
        if ($sCurrency !== null)
            if (isset($oBalance->{$sCurrency}))
                return $oBalance->{$sCurrency};
            else
                return null;
        return $oBalance;
    }
    
    public function getFindTransaction($iTransactionId)
    {
        $sResponse = $this->_getResponse('findTransaction',array(
            'transactionId' => $iTransactionId
        ));        
        $oTransactionDetails = $this->_parseResponse($sResponse);        
        return $oTransactionDetails;
    }
    
    public function getTransfer($sPayeeEmail, $fAmount, $sCurrency, $sDetails)
    {
        $sResponse = $this->_getResponse('transfer',array(
            'payeeEmail'    => $sPayeeEmail,
            'amount'        => $fAmount,
            'currency'      => $sCurrency,
            'details'       => $sDetails            
        ));        
        $oTransactionDetails = $this->_parseResponse($sResponse);        
        return $oTransactionDetails;
    }
    
    public function getHistory($aParams = array())
    {
        $sResponse = $this->_getResponse('history', $aParams);
        $oTransactionsDetails = $this->_parseResponse($sResponse);        
        return $oTransactionsDetails;
    }
   
    private static function _generateId()
    {
        return uniqid();
    }
    
    private function _buildQuery($aData)
    {
        $aData = array_merge(array(
            'id'            => self::_generateId(),
            'version'       => self::VERSION,
            'account_name'  => $this->_oAuth->getAccountName(),
            'api_id'        => $this->_oAuth->getApiId(),
            'ts'            => time(),
        ), array_filter($aData));
        
        ksort($aData);		
        $aData['h'] = hash('sha256',$this->_oAuth->getApiPass() . '|' . implode('|', $aData));
        return $aData;
    }
    
    private function _getResponse($sAction, $aData = array())
    {
        if (!function_exists('curl_init')) {
            die("Curl library not installed.");
            return false;
        }
        
        $sRequestUrl = self::EGOPAY_API_PAYMENT_URL . $sAction;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sRequestUrl);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_6; en-us) AppleWebKit/525.27.1 (KHTML, like Gecko) Version/3.2.1 Safari/525.27.1");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->_buildQuery($aData)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $sResponse = curl_exec($ch);
        
        if (!curl_errno($ch)) {
            $response_info = curl_getinfo($ch);
            if ($response_info['http_code'] != 200) {
                throw new EgoPayApiException('Invalid response from EgoPay. Response code: '. $response_info['http_code']);
            }
        }

    	curl_close($ch);

        return $sResponse;
    }
    
    private function _parseResponse($sResponse)
    {      
        $oResponse = json_decode($sResponse);
        $this->_checkError($oResponse);
        return $oResponse;
    }
       
    private function _checkError($oResponse)
    {
        if ($oResponse === null)
            throw new EgoPayApiException('Invalid Response Format', (int) 0);
        if (isset($oResponse->status) && $oResponse->status == 'ERROR')
            throw new EgoPayApiException($oResponse->error_message, (int) $oResponse->error_code);
    }        
}