<?php

class Fourtek_SmsNotification_Model_Smsmodel extends Mage_Core_Model_Abstract
{
    protected function _construct(){

       $this->_init("smsnotification/smsmodel");

    }
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'msg91',
                'label' => 'MSG91',
            ),
            array(
                'value' => 'bhashsms',
                'label' => 'BHASHSMS',
            )
        );
    }

}