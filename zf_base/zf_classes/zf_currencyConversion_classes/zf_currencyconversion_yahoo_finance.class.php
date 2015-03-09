<?php

/*
*
* PHP Currency Conversion Class
* 
* The currency rates are fetched and cached for the whole day
*
* http://prash.me
* http://github.com/prashles
*
* Uses http://rate-exchange.appspot.com/currency currency API
* Returns JSON - based on Google's API
*
* @author Prash Somaiya
*
*/

Class Zf_CurrencyConversion_Yahoo_Finance {
	
   /*
    * Constructor sets to TRUE if $cacheFolder is writable
    *
    * FALSE by default
    */

    private $cachable = FALSE;

   /*
    * The folder where the cache files are stored
    * 
    * Set in the constructor. //convert by default
    */

    private $cacheFolder;

   /*
    * Length of cache in seconds
    *
    * Default is 5 hours
    */

    private $cacheTimeout;
    
    
   /**
    * Check if folder is writable for caching
    *
    * Set $cache to FALSE on call to disable caching
    * $folder is where the cache files will be stored
    *
    * Set $folder to 'dcf' for the default folder
    *
    * Set $cacheTimeout for length of caching in seconds
    */
    public function __construct($cache = TRUE, $folder = 'zf_currency_conversions', $cacheTimeout = 18000) {
        
        $this->cacheFolder = ($folder == 'zf_currency_conversions') ? ZF_DATASTORE.DS.'currency_conversions'.DS : $folder;
	
        if (is_writable($this->cacheFolder) && $cache == TRUE) { 
            
                $this->cachable     = TRUE;
                $this->cacheTimeout = $cacheTimeout;
                
        }
        
    }
    
    
   /**
    * Main function for Fetching the currencies from yahoo currency converter
    *
    */
    private function fetchRates($fromCurrency, $toCurrency){
        
        $rateValue = $this->getCacheFile($fromCurrency . $toCurrency);
        
        if (!$rateValue){
            
            $url = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='. $fromCurrency . $toCurrency .'=X';
            $handleRates = @fopen($url, 'r');

            if ($handleRates) {
                $result = fgets($handleRates, 4096);
                fclose($handleRates);
            }

            $allRatesData = explode(',',$result); /* Get all the contents to an array */
            $rateValue = $allRatesData[1];

            # Caches the rate for future
            $this->createCacheFile($fromCurrency.$toCurrency, $rateValue);
            
        }
        
        return $rateValue;

    }
        
    
   /**
    * Main function for converting
    *
    * Set $round to FALSE to return full amount
    */
   public function convert($AmountToConvert, $fromCurrency, $toCurrency, $round = TRUE){
        
        //Get the rates from a cached file if it exists
        $exchangeRate = $this->getCacheFile($fromCurrency.$toCurrency);
        
        if($exchangeRate !== FALSE){
            
            $finalAmount = $exchangeRate * $AmountToConvert;
            
        }else{
            
            //But we need to validate the currencies
            if (!$this->validateCurrency($toCurrency, $fromCurrency)) {

                throw new Exception('Invalid currency code - must be exactly 3 letters');

            }

            //Get the conversion rates from yahoo.
            $conversionRate = $this->fetchRates($fromCurrency, $toCurrency);

            //1 $fromCurrency is == $conversionRate $toCurrency

            //Convert the currency only if the inputs are valid.
            if($conversionRate == 0.00){

                throw new Exception('Invalid Currency Input');

            }else{

                $finalAmount = $AmountToConvert * $conversionRate;
                
                $this->createCacheFile($fromCurrency.$toCurrency, $conversionRate);

            }
            
        }
        
        return ($round) ? abs(round($finalAmount, 2)) : abs($finalAmount);

    }
    
  
   /**
    * Calculates amount needed in currency to achieve finish currency
    *
    * Set $round to FALSE to get full value
    */

   public function amountTo($finalAmount, $fromCurrency, $toCurrency, $round = TRUE) {
        
        $finalAmount = (float) $finalAmount;

        if ($finalAmount == 0) {
            return 0;
        }

        if (!$this->validateCurrency($fromCurrency, $toCurrency)) {
            throw new Exception('Invalid currency code - must be exactly 3 letters');
        }

        # Gets the rate
        $rateValues = $this->fetchRates($fromCurrency, $toCurrency);

        # Work it out
        $outAmounts = $finalAmount / $rateValues;

        return ($round) ? round($outAmounts, 2) : $outAmounts;
        
    }
    
    
   /**
    * Checks if file is cached then returns rate
    */ 
   protected function getCacheFile($file) {

            $fileName = $this->cacheFolder.strtoupper($file).'.convertcache';

            if ($this->cachable && file_exists($fileName)) {

                    $file = file($this->cacheFolder.$file.'.convertcache');

                    if ($file[0] < (time() - $this->cacheTimeout)) {

                        $this->clearCache($fileName);

                        return FALSE;

                    }else{

                        return $file[1];

                    }

            }else{

                $this->clearCache($fileName);
                return FALSE;

            }

    }
    
    
   /**
    * Validates the currency identifier
    */
   protected function validateCurrency(){
        
        foreach (func_get_args() as $val) {
            
            if (strlen($val) !== 3 || !ctype_alpha($val)) {
                
                if (strtoupper($val) != 'BEAC') {			
                        return FALSE;				
                }
                
            }
            
        }

        return TRUE;	

    }
    
    
   /*
    * Deletes all .convertcache files in cache folder
    */

    public function clearCache($fileName)
    {
            //$files = glob($this->cacheFolder.'*.convertcache');
            //if (!empty($files)) { array_map("unlink", $files); }
            @unlink($fileName);

    }
    
    
   /**
    * Checks if file is cacheable then creates new file
    */
   protected function createCacheFile($fileName, $exchangeRate) {

        if ($this->cachable) {
            $fileName = strtoupper($fileName) . '.convertcache';

            $data = time() . PHP_EOL . $exchangeRate;
            file_put_contents($this->cacheFolder . $fileName, $data);
            
        }
        
   }
	
}