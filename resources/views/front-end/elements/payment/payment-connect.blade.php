<script src="https://dohabank.gateway.mastercard.com/checkout/version/57/checkout.js" data-error="errorCallback" data-complete="completeCallback" data-cancel="cancelCallback"></script>

<script type="text/javascript">
            function errorCallback(error) {
                  console.log(JSON.stringify(error));
            }
            //function cancelCallback() {
              // confirm('Are you sure you want to cancel?');

            //}
            
            cancelCallback = "{{url('payment/order_cancel/'.Crypt::encryptString($orderid))}}";
            completeCallback = "{{url('payment/order_success/'.Crypt::encryptString($orderid))}}";
            Checkout.configure({

               merchant: '<?php echo $response->merchant; ?>',
               order: {
                  amount: function(){
                     return <?php echo $amount; ?>;      
                  },
                  currency: '<?php echo $currency; ?>',
                  description:'Ordered Items',
                  id: '<?php echo $orderid; ?>' 

               },  
               billing    : {
                     address: {
                        street       : '',
                        city         : '',
                        postcodeZip  : '',
                        stateProvince: '',
                        country      : ''
                        }
                     },
               interaction: {
                     merchant: {
                        name   : 'Rentsolutions',
                        address: {
                          line1: '',
                          line2: ''            
                        },
                        email  : 'info@rentsolutions.org',
                        phone  : '009740000000000',
                        logo   : 'https://rentsolutions.hexeam.org/assets/front/themes/rental/images/logo.png'
                     },
                     locale   : 'en_US',
                     theme    : 'default',
                     displayControl: {
                        billingAddress  : 'OPTIONAL',
                        customerEmail : 'OPTIONAL',
                        orderSummary    : 'SHOW',
                        shipping        : 'READ_ONLY'
                     }
               },
               session: { 
            	id: '<?php echo $sessionid; ?>'
       			}
            });
            Checkout.showPaymentPage();
        </script>