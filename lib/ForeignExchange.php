<?php

// fx.php - PHP Code to convert currencies using Yahoo's currency conversion service.
// by Adam Pierce <adam@doctort.org> 22-Oct-2008
// This code is public domain.

class ForeignExchange
{
    private $fxRate;
    
    public function __construct($currencyBase, $currencyForeign)
    {
        $url = 'http://download.finance.yahoo.com/d/quotes.csv?s='
            .$currencyBase .$currencyForeign .'=X&f=l1';

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $this->fxRate = doubleval(curl_exec($c));
        curl_close($c);
    }

    public function toBase($amount)
    {
        if($this->fxRate == 0)
            return 0;
            
        return  $amount / $this->fxRate;
    }
    
    public function toForeign($amount)
    {
        if($this->fxRate == 0)
            return 0;
            
        return $amount * $this->fxRate;
    }
};

?>