<?php
class Fourtek_SmsNotification_Model_Observer
{

			public function salesOrderInvoicePay($observer) {
				$event = $observer->getEvent();
				$invoice=$observer->getInvoice();
				$order =$observer->getOrder();   
				$incre_id=$order->getIncrementId();
				$custname = $order->getBillingAddress()->getName(); 
				$mobileNumber = $order->getBillingAddress()->getTelephone();
				$orderId =$order->getIncrementId();
				$orderAmt=number_format($order->getGrandTotal(),2);
				$smsservices = Mage::getStoreConfig('smanotification/msg91sms/smsservices');
				$invoicesms=Mage::getStoreConfig('smanotification/smstextarea/invoicesms');
					$invoicesms = str_replace('{{customer_name}}', $custname, $invoicesms);
					$invoicesms = str_replace('{{order_id}}', $orderId, $invoicesms);
					$invoicesms = str_replace('{{order_amt}}', $orderAmt, $invoicesms);
				if($smsservices == 'bhashsms'){
				//bhashsms
					$bhashurl=$this->_bhashurl();
					$bhashuser=$this->_bhashuser();
					$bhashpasword=$this->_bhashpasword();
					$bhashsender=$this->_bhashsender();
					$bhashspriority=$this->_bhashspriority();
					$bhashsstype=$this->_bhashsstype();

					$message = urlencode($invoicesms);

                    $url = ''.$bhashurl.'?user='.$bhashuser.'&pass='.$bhashpasword.'&sender='.$bhashsender.'&phone='.$mobileNumber.'&text='.$message.'&priority='.$bhashspriority.'&stype='.$bhashsstype.'';
                    
                       
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                            //,CURLOPT_FOLLOWLOCATION => true
                        ));
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    
                        
                        //get response
                        $output = curl_exec($ch);
                        
                        //Print error if any
                        if(curl_errno($ch))
                        {
                            echo 'error:' . curl_error($ch);
                        }
                        
                        curl_close($ch);
					
				}else{
					
				//Msg91 
				$authKey = Mage::getStoreConfig('smanotification/msg91sms/authkey');
				$senderId = Mage::getStoreConfig('smanotification/msg91sms/sender');
				$route = Mage::getStoreConfig('smanotification/msg91sms/route');
				$message = urlencode($invoicesms);
				$postData = array(
			       'authkey' => $authKey,
			       'mobiles' => $mobileNumber,
			       'message' => $message,
			       'sender' => $senderId,
			       'route' => $route
			   );

			   $url=Mage::getStoreConfig('smanotification/msg91sms/smsurl');
			   $ch = curl_init();
			   curl_setopt_array($ch, array(
			       CURLOPT_URL => $url,
			       CURLOPT_RETURNTRANSFER => true,
			       CURLOPT_POST => true,
			       CURLOPT_POSTFIELDS => $postData
			       //,CURLOPT_FOLLOWLOCATION => true
			   ));
			   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			   $output = curl_exec($ch);
			   if(curl_errno($ch))
			   {
			       echo 'error:' . curl_error($ch);
			   }
			   curl_close($ch);
			}

			}
			public function salesOrderShipmentSaveAfter($observer)
			{
				$shipment = $observer->getEvent()->getShipment();
	            $order = $shipment->getOrder();
	            $order->getIncrementId(); 
				$incre_id=$order->getIncrementId(); 
				$custname = $order->getBillingAddress()->getName(); 
				$mobileNumber = $order->getBillingAddress()->getTelephone();
				$orderId =$order->getIncrementId();
 				$orderAmt=number_format($order->getGrandTotal(),2);
 				$title = Mage::getModel('sales/order')->loadByIncrementId($orderId)->getTracksCollection()->getFirstItem()->getTitle();
				$num =  Mage::getModel('sales/order')->loadByIncrementId($orderId)->getTracksCollection()->getFirstItem()->getNumber();
				$smsservices = Mage::getStoreConfig('smanotification/msg91sms/smsservices');
				$shipmentsms=Mage::getStoreConfig('smanotification/smstextarea/shipmentsms');
					$shipmentsms = str_replace('{{customer_name}}', $custname, $shipmentsms);
					$shipmentsms = str_replace('{{order_id}}', $orderId, $shipmentsms);
					$shipmentsms = str_replace('{{order_amt}}', $orderAmt, $shipmentsms);
				if($smsservices == 'bhashsms'){
					$bhashurl=$this->_bhashurl();
					$bhashuser=$this->_bhashuser();
					$bhashpasword=$this->_bhashpasword();
					$bhashsender=$this->_bhashsender();
					$bhashspriority=$this->_bhashspriority();
					$bhashsstype=$this->_bhashsstype();
					
					$message = urlencode($shipmentsms);

                    $url = ''.$bhashurl.'?user='.$bhashuser.'&pass='.$bhashpasword.'&sender='.$bhashsender.'&phone='.$mobileNumber.'&text='.$message.'&priority='.$bhashspriority.'&stype='.$bhashsstype.'';
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                            //,CURLOPT_FOLLOWLOCATION => true
                        ));
                        //Ignore SSL certificate verification
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        //get response
                        $output = curl_exec($ch);
                        //Print error if any
                        if(curl_errno($ch))
                        {
                            echo 'error:' . curl_error($ch);
                        }
                        
                        curl_close($ch);
				}else{

				$authKey = Mage::getStoreConfig('smanotification/msg91sms/authkey');
				$senderId = Mage::getStoreConfig('smanotification/msg91sms/sender');
				$route = Mage::getStoreConfig('smanotification/msg91sms/route');
				if($num > 0){
				$message = urlencode($shipmentsms);
				}else{
				$message = urlencode($shipmentsms);
				}
				    $postData = array(
				        'authkey' => $authKey,
				        'mobiles' => $mobileNumber,
				        'message' => $message,
				        'sender' => $senderId,
				        'route' => $route
				    );
				    $url=Mage::getStoreConfig('smanotification/msg91sms/smsurl');
				    $ch = curl_init();
				    curl_setopt_array($ch, array(
				        CURLOPT_URL => $url,
				        CURLOPT_RETURNTRANSFER => true,
				        CURLOPT_POST => true,
				        CURLOPT_POSTFIELDS => $postData
				        //,CURLOPT_FOLLOWLOCATION => true
				    ));
				    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				    $output = curl_exec($ch);
				    if(curl_errno($ch))
				    {
				        echo 'error:' . curl_error($ch);
				    }
				    curl_close($ch);
				}
				
			}
			public function creditmemoSaveAfter($observer) {

			$creditmemo = $observer->getEvent()->getCreditmemo();
			            $order = $creditmemo->getOrder();
			            
			$incre_id=$order->getIncrementId(); 
			$custname = $order->getBillingAddress()->getName(); 
			$mobileNumber = $order->getBillingAddress()->getTelephone();
			$orderId =$order->getIncrementId();
			$orderAmt=number_format($order->getGrandTotal(),2);
			$smsservices = Mage::getStoreConfig('smanotification/msg91sms/smsservices');
			$shipmentsms=Mage::getStoreConfig('smanotification/smstextarea/shipmentsms');
			$shipmentsms = str_replace('{{customer_name}}', $custname, $shipmentsms);
			$shipmentsms = str_replace('{{order_id}}', $orderId, $shipmentsms);
			$shipmentsms = str_replace('{{order_amt}}', $orderAmt, $shipmentsms);
				
			/*****************sms*******************/
			if($smsservices == 'bhashsms'){
				$bhashurl=$this->_bhashurl();
				$bhashuser=$this->_bhashuser();
				$bhashpasword=$this->_bhashpasword();
				$bhashsender=$this->_bhashsender();
				$bhashspriority=$this->_bhashspriority();
				$bhashsstype=$this->_bhashsstype();
				$message = urlencode($shipmentsms);
                $url = ''.$bhashurl.'?user='.$bhashuser.'&pass='.$bhashpasword.'&sender='.$bhashsender.'&phone='.$mobileNumber.'&text='.$message.'&priority='.$bhashspriority.'&stype='.$bhashsstype.'';
                    $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                            //,CURLOPT_FOLLOWLOCATION => true
                        ));
                        //Ignore SSL certificate verification
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        //get response
                        $output = curl_exec($ch);
                        //Print error if any
                        if(curl_errno($ch))
                        {
                            echo 'error:' . curl_error($ch);
                        }
                        
                        curl_close($ch);
			}else{
			    $authKey = Mage::getStoreConfig('smanotification/msg91sms/authkey');
				$senderId = Mage::getStoreConfig('smanotification/msg91sms/sender');
				$route = Mage::getStoreConfig('smanotification/msg91sms/route');
			    $message = urlencode("Dear ".$custname." Order No ".$orderId." worth Rs. ".$orderAmt." Credit Memo Created successfully. Check your mail for more details.Thank you.");
			    
			    $postData = array(
			        'authkey' => $authKey,
			        'mobiles' => $mobileNumber,
			        'message' => $message,
			        'sender' => $senderId,
			        'route' => $route
			    );
			    $url=Mage::getStoreConfig('smanotification/msg91sms/smsurl');
			    $ch = curl_init();
			    curl_setopt_array($ch, array(
			        CURLOPT_URL => $url,
			        CURLOPT_RETURNTRANSFER => true,
			        CURLOPT_POST => true,
			        CURLOPT_POSTFIELDS => $postData
			        //,CURLOPT_FOLLOWLOCATION => true
			    ));
			    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			    $output = curl_exec($ch);
			    if(curl_errno($ch))
			    {
			        echo 'error:' . curl_error($ch);
			    }
			    curl_close($ch);
			}
			/***************sms end*********************/ 
			}
			public function paymentCancel($observer) {

                $id=$observer->getPayment()->getId();
				$model=Mage::getModel('sales/order')->load($id);
				$incre_id=$model->getIncrementId();
		                $order = Mage::getModel('sales/order')->loadByIncrementId($incre_id);
		                $custname = $order->getBillingAddress()->getName();
		                $mobileNumber = $order->getBillingAddress()->getTelephone();
		                $orderId =$order->getIncrementId();
		                $orderAmt=number_format($order->getGrandTotal(),2);

		/*****************sms*******************/

		    $authKey = Mage::getStoreConfig('smanotification/msg91sms/authkey');
				$senderId = Mage::getStoreConfig('smanotification/msg91sms/sender');
				$route = Mage::getStoreConfig('smanotification/msg91sms/route');
		    $message = urlencode("Dear ".$custname." Order No ".$orderId." worth Rs. ".$orderAmt." cancelled successfully. Thank you.");
		    
		    $postData = array(
		        'authkey' => $authKey,
		        'mobiles' => $mobileNumber,
		        'message' => $message,
		        'sender' => $senderId,
		        'route' => $route
		    );
		    $url=Mage::getStoreConfig('smanotification/msg91sms/smsurl');
		    $ch = curl_init();
		    curl_setopt_array($ch, array(
		        CURLOPT_URL => $url,
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_POST => true,
		        CURLOPT_POSTFIELDS => $postData
		        //,CURLOPT_FOLLOWLOCATION => true
		    ));
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		    $output = curl_exec($ch);
		    if(curl_errno($ch))
		    {
		        echo 'error:' . curl_error($ch);
		    }
		    curl_close($ch);

		/***************sms end*********************/       



		    }
		    public function saveorder(Varien_Event_Observer $observer)
			{
				$orderIds = $observer->getData('order_ids');
				$order     = Mage::getModel('sales/order')->load($orderIds);
				$incre_id=$order->getIncrementId(); 
				$custname = $order->getBillingAddress()->getName(); 
				$mobileNumber = $order->getBillingAddress()->getTelephone();
				$orderId =$order->getIncrementId();
				$orderAmt=number_format($order->getGrandTotal(),2);
				$smsservices = Mage::getStoreConfig('smanotification/msg91sms/smsservices');
				$placeorder=Mage::getStoreConfig('smanotification/smstextarea/placeorder');
				$placeorder = str_replace('{{customer_name}}', $custname, $placeorder);
				$placeorder = str_replace('{{order_id}}', $orderId, $placeorder);
				$placeorder = str_replace('{{order_amt}}', $orderAmt, $placeorder);
					
				/*****************sms*******************/
				if($smsservices == 'bhashsms'){
					$bhashurl=$this->_bhashurl();
					$bhashuser=$this->_bhashuser();
					$bhashpasword=$this->_bhashpasword();
					$bhashsender=$this->_bhashsender();
					$bhashspriority=$this->_bhashspriority();
					$bhashsstype=$this->_bhashsstype();
					$message = urlencode($placeorder);
	                $url = ''.$bhashurl.'?user='.$bhashuser.'&pass='.$bhashpasword.'&sender='.$bhashsender.'&phone='.$mobileNumber.'&text='.$message.'&priority='.$bhashspriority.'&stype='.$bhashsstype.'';
	                    $ch = curl_init();
	                        curl_setopt_array($ch, array(
	                            CURLOPT_URL => $url,
	                            CURLOPT_RETURNTRANSFER => true,
	                            CURLOPT_POST => true,
	                            CURLOPT_POSTFIELDS => $postData
	                            //,CURLOPT_FOLLOWLOCATION => true
	                        ));
	                        //Ignore SSL certificate verification
	                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	                        //get response
	                        $output = curl_exec($ch);
	                        //Print error if any
	                        if(curl_errno($ch))
	                        {
	                            echo 'error:' . curl_error($ch);
	                        }
	                        
	                        curl_close($ch);
				}else{
				    $authKey = Mage::getStoreConfig('smanotification/msg91sms/authkey');
					$senderId = Mage::getStoreConfig('smanotification/msg91sms/sender');
					$route = Mage::getStoreConfig('smanotification/msg91sms/route');
				    $message = urlencode("Dear ".$custname." Order No ".$orderId." worth Rs. ".$orderAmt." Credit Memo Created successfully. Check your mail for more details.Thank you.");
				    
				    $postData = array(
				        'authkey' => $authKey,
				        'mobiles' => $mobileNumber,
				        'message' => $message,
				        'sender' => $senderId,
				        'route' => $route
				    );
				    $url=Mage::getStoreConfig('smanotification/msg91sms/smsurl');
				    $ch = curl_init();
				    curl_setopt_array($ch, array(
				        CURLOPT_URL => $url,
				        CURLOPT_RETURNTRANSFER => true,
				        CURLOPT_POST => true,
				        CURLOPT_POSTFIELDS => $postData
				        //,CURLOPT_FOLLOWLOCATION => true
				    ));
				    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				    $output = curl_exec($ch);
				    if(curl_errno($ch))
				    {
				        echo 'error:' . curl_error($ch);
				    }
				    curl_close($ch);
				}


				
			}
			/*public function customerRegisterSuccess(Varien_Event_Observer $observer)
			{

				$customer = $observer->getEvent()->getCustomer();
		        $fname=$customer->getFirstname();
		        $lname=$customer->getLastname();
		        $name=$customer->getName();

		        $email= $customer->getEmail();
		        $smsservices = Mage::getStoreConfig('smanotification/msg91sms/smsservices');
				$customerregister=Mage::getStoreConfig('smanotification/smstextarea/customerregister');
				$customerregister = str_replace('{{customer_name}}', $name, $customerregister);
				
				
				if($smsservices == 'bhashsms'){
					$bhashurl=$this->_bhashurl();
					$bhashuser=$this->_bhashuser();
					$bhashpasword=$this->_bhashpasword();
					$bhashsender=$this->_bhashsender();
					$bhashspriority=$this->_bhashspriority();
					$bhashsstype=$this->_bhashsstype();
					$message = urlencode($customerregister);
	                $url = ''.$bhashurl.'?user='.$bhashuser.'&pass='.$bhashpasword.'&sender='.$bhashsender.'&phone='.$mobileNumber.'&text='.$message.'&priority='.$bhashspriority.'&stype='.$bhashsstype.'';
	                    $ch = curl_init();
	                        curl_setopt_array($ch, array(
	                            CURLOPT_URL => $url,
	                            CURLOPT_RETURNTRANSFER => true,
	                            CURLOPT_POST => true,
	                            CURLOPT_POSTFIELDS => $postData
	                            //,CURLOPT_FOLLOWLOCATION => true
	                        ));
	                        //Ignore SSL certificate verification
	                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	                        //get response
	                        $output = curl_exec($ch);
	                        //Print error if any
	                        if(curl_errno($ch))
	                        {
	                            echo 'error:' . curl_error($ch);
	                        }
	                        
	                        curl_close($ch);


				}else{
				$authKey = Mage::getStoreConfig('smanotification/msg91sms/authkey');
				$senderId = Mage::getStoreConfig('smanotification/msg91sms/sender');
				$route = Mage::getStoreConfig('smanotification/msg91sms/route');
				$message = urlencode($customerregister);
				    $postData = array(
				        'authkey' => $authKey,
				        'mobiles' => $mobileNumber,
				        'message' => $message,
				        'sender' => $senderId,
				        'route' => $route
				    );
				    $url=Mage::getStoreConfig('smanotification/msg91sms/smsurl');
				    $ch = curl_init();
				    curl_setopt_array($ch, array(
				        CURLOPT_URL => $url,
				        CURLOPT_RETURNTRANSFER => true,
				        CURLOPT_POST => true,
				        CURLOPT_POSTFIELDS => $postData
				        //,CURLOPT_FOLLOWLOCATION => true
				    ));
				    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				    $output = curl_exec($ch);
				    if(curl_errno($ch))
				    {
				        echo 'error:' . curl_error($ch);
				    }
				    curl_close($ch);
				}


				}
		        


			}*/
			public function orderplace(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function cancleafter(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function orderpayment(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function paymentplace(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function cancelinvoice(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function paymentrefound(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function cancelcreditmemo(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function paymentcancels(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function invoiceregister(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		
			public function itemcancel(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}
		

		public function _bhashurl()
		{
			$bhashurl=Mage::getStoreConfig('smanotification/msg91sms/bhashurl');
			
			return $bhashurl;
		}
		public function _bhashuser()
		{
			$bhashuser=Mage::getStoreConfig('smanotification/msg91sms/bhashuser');
			
			return $bhashuser;
		}
		public function _bhashpasword()
		{
			$bhashpasword=Mage::getStoreConfig('smanotification/msg91sms/bhashpasword');
			
			return $bhashpasword;
		}
		public function _bhashsender()
		{
			$bhashsender=Mage::getStoreConfig('smanotification/msg91sms/bhashsender');
			
			return $bhashsender;
		}
		public function _bhashspriority()
		{
			$bhashspriority = Mage::getStoreConfig('smanotification/msg91sms/bhashspriority');
			
			return $bhashspriority;
		}
		public function _bhashsstype()
		{
			$bhashsstype=Mage::getStoreConfig('smanotification/msg91sms/bhashsstype');
			
			return $bhashsstype;
		}			
					
			
					
}
