<?php

namespace Sale\Handlers\PaySystem;

\CModule::includeModule('sotbit.bill');
if(!class_exists('BillHandler')) return false;
class BillSotbitV2Handler extends \BillHandler
{

    /**
     * @return array
     */
    public function getCurrencyList()
    {
        return array('RUB');
    }

    /**
     * @return bool
     */
    public function isAffordPdf()
    {
        return true;
    }


}