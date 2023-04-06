<?php

    add_action( 'wp_enqueue_scripts', 'plugin_admin_init' );
    function plugin_admin_init(){
        wp_enqueue_style( 'bootstrap-plugin', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
        wp_enqueue_style( 'customstyle-plugin', plugins_url( '../assets/css/style.css', __FILE__ ));
        wp_enqueue_script( 'customstyle-plugin-js', plugins_url( '../assets/js/custom.js', __FILE__ ), array('jquery'), '1.0' );
    }
    

    add_shortcode('mortgage-calculator', 'mortgage_calculator');

	function mortgage_calculator($attr, $content){
		ob_start();
            if( isset( $_POST['calculate'] ) ){

                ////Get automatically
                // $ShowDebugInfo          = isset( $_POST['ShowDebugInfo'] ) ? $_POST['ShowDebugInfo'] : 'false';
                $ShowDebugInfo          = 'true';

                /////get from customer
                ///1st person information
                $NumberOfInsuredPersons = isset( $_POST['NumberOfInsuredPersons'] ) ? $_POST['NumberOfInsuredPersons'] : '1';
                $Ip1Name                = isset( $_POST['Ip1Name'] ) ? $_POST['Ip1Name'] : '';
                $Ip1Surname             = isset( $_POST['Ip1Surname'] ) ? $_POST['Ip1Surname'] : '';
                $Ip1BirthDate           = isset( $_POST['Ip1BirthDate'] ) ? $_POST['Ip1BirthDate'] : '';
                $Ip1BirthDate           = date("Y-m-d", strtotime($Ip1BirthDate));
                $Ip1IsSmoker            = isset( $_POST['Ip1IsSmoker'] ) ? $_POST['Ip1IsSmoker'] : '';
                // $Ip1IsSmoker            = 'NONSMOKER';
                $Ip1Gender              = isset( $_POST['Ip1Gender'] ) ? $_POST['Ip1Gender'] : '';

                ///2nd person information
                $Ip2Name                = isset( $_POST['Ip2Name'] ) ? $_POST['Ip2Name'] : '';
                //echo $Ip2Name;
                $Ip2Surname             = isset( $_POST['Ip2Surname'] ) ? $_POST['Ip2Surname'] : '';
                //echo $Ip2Surname;
                $Ip2BirthDate           = isset( $_POST['Ip2BirthDate'] ) ? $_POST['Ip2BirthDate'] : '';
                $Ip2BirthDate           = date("Y-m-d", strtotime($Ip2BirthDate));
                //echo $Ip2BirthDate;
                $Ip2IsSmoker            = isset( $_POST['Ip2IsSmoker'] ) ? $_POST['Ip2IsSmoker'] : '';
                //echo $Ip2IsSmoker;
                // $Ip2IsSmoker            = 'NONSMOKER';
                $Ip2Gender              = isset( $_POST['Ip2Gender'] ) ? $_POST['Ip2Gender'] : '';
                //echo $Ip2Gender;


                ////Get automatically
                //$Fiscality              = isset( $_POST['Fiscality'] ) ? $_POST['Fiscality'] : '';
                $Fiscality              = 'NP_NOT_FISCAL';
                //$PurposeType            = isset( $_POST['PurposeType'] ) ? $_POST['PurposeType'] : '';
                $PurposeType            = 'MORTGAGE_LOAN';
                //$FreeCoverageStartDate  = isset( $_POST['FreeCoverageStartDate'] ) ? $_POST['FreeCoverageStartDate'] : '';
                $FreeCoverageStartDate  = '2022-10-10';
                // $FreeCoverageStartDate  = date("Y-m-d", strtotime($FreeCoverageStartDate));
                //$FreeCoverageStartDate  = date("Y-m-d", strtotime($FreeCoverageStartDate));

                /////get from customer
                $StartDate              = isset( $_POST['StartDate'] ) ? $_POST['StartDate'] : '';
                $StartDate              = date("Y-m-d", strtotime($StartDate));


                ////Get automatically
                //$Formula = isset( $_POST['Formula'] ) ? $_POST['Formula'] : '';
                $Formula = 'ANNUITY';
                //$AmortizationFrequency = isset( $_POST['AmortizationFrequency'] ) ? $_POST['AmortizationFrequency'] : '';
                $AmortizationFrequency = 'MONTHLY';


                /////get from customer
                $InsuredAmount = isset( $_POST['InsuredAmount'] ) ? $_POST['InsuredAmount'] : 'false';
                $YearlyInterestPercentage = isset( $_POST['YearlyInterestPercentage'] ) ? $_POST['YearlyInterestPercentage'] : '';
                $CoverageDurationInMonths = isset( $_POST['CoverageDurationInMonths'] ) ? $_POST['CoverageDurationInMonths'] : '';
                // $MonthsWithoutAmortization = isset( $_POST['MonthsWithoutAmortization'] ) ? $_POST['MonthsWithoutAmortization'] : '';
                $MonthsWithoutAmortization = 0;

                ////Get automatically
                //$DurationType = isset( $_POST['DurationType'] ) ? $_POST['DurationType'] : '';
                $DurationType = 'TWO_THIRDS_DURATION';
                // $CommissionPercentage = isset( $_POST['CommissionPercentage'] ) ? $_POST['CommissionPercentage'] : '';
                $GetCommissionPercentage = get_option('commissionPercentage');
                $CommissionPercentage = isset($GetCommissionPercentage) ? $GetCommissionPercentage : 5;
                // $CommissionFixedAmount = isset( $_POST['CommissionFixedAmount'] ) ? $_POST['CommissionFixedAmount'] : '';
                $CommissionFixedAmount = 0;
                //$PremiumType = isset( $_POST['PremiumType'] ) ? $_POST['PremiumType'] : '';
                $PremiumType = 'CONSTANT_PREMIUMS';
                //$PaymentFormula = isset( $_POST['PaymentFormula'] ) ? $_POST['PaymentFormula'] : '';
                $PaymentFormula = 'HS_12_13_INSURANCE_DURATION';
                //$PaymentFrequencyFirstYear = isset( $_POST['PaymentFrequencyFirstYear'] ) ? $_POST['PaymentFrequencyFirstYear'] : '';
                $PaymentFrequencyFirstYear = 'MONTHLY';
                //$PaymentFrequency = isset( $_POST['PaymentFrequency'] ) ? $_POST['PaymentFrequency'] : '';
                $PaymentFrequency = 'MONTHLY';

                // $TariffCode = isset( $_POST['TariffCode'] ) ? $_POST['TariffCode'] : '';
                $GetTariffCode = get_option('tariffCode');
                $TariffCode = isset( $GetTariffCode) ?  $GetTariffCode : "FHP";
        
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://my.aviza.be/auth/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'username=niessen.erwin@dhsgroup.be&password=C6eX*wre7WeJa3ep&grant_type=password&client_id=xxx',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/plain'
                ),
                ));
        
                $response = curl_exec($curl);
        
                curl_close($curl);
        
                $token = json_decode( $response, true )['access_token'];
                
                if($NumberOfInsuredPersons == 2){
                    $CURLOPT_POSTFIELDS = '{"ShowDebugInfo":'.$ShowDebugInfo.',"NumberOfInsuredPersons" : '.$NumberOfInsuredPersons.',"Ip1Name":"'.$Ip1Name.'","Ip1Surname" :"'.$Ip1Surname.'","Ip1BirthDate":"'.$Ip1BirthDate.'T00:00:00","Ip1IsSmoker":"'.$Ip1IsSmoker.'","Ip1Gender":"'.$Ip1Gender.'","Ip2Name":"'.$Ip2Name.'","Ip2Surname" :"'.$Ip2Surname.'","Ip2BirthDate":"'.$Ip2BirthDate.'T00:00:00","Ip2IsSmoker":"'.$Ip2IsSmoker.'","Ip2Gender":"'.$Ip2Gender.'","Fiscality":"NP_NOT_FISCAL","PurposeType":"'.$PurposeType.'","FreeCoverageStartDate":"'.$FreeCoverageStartDate.'T00:00:00","StartDate":"'.$StartDate.'T00:00:00","Formula":"'.$Formula.'","AmortizationFrequency":"'.$AmortizationFrequency.'","InsuredAmount":'.$InsuredAmount.',"YearlyInterestPercentage":'.$YearlyInterestPercentage.',"CoverageDurationInMonths":'.$CoverageDurationInMonths.',"MonthsWithoutAmortization":'.$MonthsWithoutAmortization.',"DurationType":"'.$DurationType.'","CommissionPercentage":'.$CommissionPercentage.',"CommissionFixedAmount":'.$CommissionFixedAmount.',"PremiumType":"'.$PremiumType.'","PaymentFormula":"'.$PaymentFormula.'","PaymentFrequencyFirstYear":"'.$PaymentFrequencyFirstYear.'","PaymentFrequency":"'.$PaymentFrequency.'","TariffCode":"'.$TariffCode.'"}';
                }else{
                    $CURLOPT_POSTFIELDS = '{"ShowDebugInfo":'.$ShowDebugInfo.',"NumberOfInsuredPersons":'.$NumberOfInsuredPersons.',"Ip1Name":"'.$Ip1Name.'","Ip1Surname" :"'.$Ip1Surname.'","Ip1BirthDate":"'.$Ip1BirthDate.'T00:00:00","Ip1IsSmoker":"'.$Ip1IsSmoker.'","Ip1Gender":"'.$Ip1Gender.'","Fiscality":"'.$Fiscality.'","PurposeType":"'.$PurposeType.'","FreeCoverageStartDate":"'.$FreeCoverageStartDate.'T00:00:00","StartDate":"'.$StartDate.'T00:00:00","Formula":"'.$Formula.'","AmortizationFrequency":"'.$AmortizationFrequency.'","InsuredAmount":'.$InsuredAmount.',"YearlyInterestPercentage":'.$YearlyInterestPercentage.',"CoverageDurationInMonths":'.$CoverageDurationInMonths.',"MonthsWithoutAmortization":'.$MonthsWithoutAmortization.',"DurationType":"'.$DurationType.'","CommissionPercentage":'.$CommissionPercentage.',"CommissionFixedAmount":'.$CommissionFixedAmount.',"PremiumType":"'.$PremiumType.'","PaymentFormula":"'.$PaymentFormula.'","PaymentFrequencyFirstYear":"'.$PaymentFrequencyFirstYear.'","PaymentFrequency":"'.$PaymentFrequency.'","TariffCode":"'.$TariffCode.'"}';
                }
               
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://my.aviza.be/api/I/External/PremiumCalculation',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$CURLOPT_POSTFIELDS,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
                ));
        
                $response = curl_exec($curl);
        
                curl_close($curl);
        
                // echo "<pre>";
                // echo print_r( json_decode( $response, true )['messages'] );
                // echo "</pre>";
        
                $premiums = isset(json_decode( $response, true )['premiums']) ? json_decode( $response, true )['premiums'] : array();
                $messages = isset(json_decode( $response, true )['messages']) ? json_decode( $response, true )['messages'] : array();
        
            }

            if( isset( $_POST['calculate'] ) ) : ?>

            <div class="container mt-5 ">
                <h2 class="text-center mb-2">Calculation Result</h2>
                <div class="row my-5">
                <?php if(count($premiums) > 0) : ?>
                    <div class="col">
                        <ul class="list-group">

                            <?php foreach( $premiums as $premium ) : ?>

                                <?php if(isset($premium)) : foreach( $premium as $key => $single ) : ?>

                                    <?php if(isset($single) && $key != '$type' && $key != 'id' && $key != 'persistenceVersion') : 
                                        
                                        if( $key == 'startDate' || $key == 'endDate'){
                                            $tempDate = date("Y-m-d", strtotime($single));
                                        ?>
                                            <li class="list-group-item"><?php echo '<span class="key-title">'.strtoupper($key) .' </span>: '.$tempDate; ?></li>

                                    <?php 
                                        }else{ ?>
                                            <li class="list-group-item"><?php echo '<span class="key-title">'.strtoupper($key) .' </span>: '.$single; ?></li>
                                        <?php } 
                                    endif;  ?>

                                <?php endforeach; endif; ?>

                            <?php endforeach; ?>
                            

                        </ul>
                    </div>
                    <div class="col">
                        <?php foreach( $messages as $message ) : ?>
                        <div class="alert alert-<?php echo strtolower($message['messageLevel']); ?>">
                            <?php echo $message['messageContent']; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php else : ?>
                        <h6 class="text-center">Sorry, No Result Matched!</h6>
                    <?php endif; ?>

                </div>
            </div>

            <?php endif; ?>
            
            <div class="container my-3">
                <h2 class="text-center mb-4">Mortgage Calculator</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" role="form" class="form-horizontal sabbir">

                            <div class="form-group my-3">
                                <label for="NumberOfInsuredPersons" class="my-1 col-sm-2 control-label">Number Of Insured Persons<span class="required">*</span></label>
                                <select name="NumberOfInsuredPersons" class="form-control" id="NumberOfInsuredPersons" required>
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                            <div class="section">
                                <h5>First Person Information<span class="required">*</span></h5>
                                <div class="form-group my-3">
                                    <label for="Ip1Name" class="my-1 col-sm-2 control-label">First Name<span class="required">*</span></label>
                                    <input required type="text" id="Ip1Name" name="Ip1Name" class="form-control" required>
                                </div>

                                <div class="form-group my-3">
                                    <label for="Ip1Surname" class="my-1 col-sm-2 control-label">Last Name<span class="required">*</span></label>
                                    <input required type="text" id="Ip1Surname" name="Ip1Surname" class="form-control" required>
                                </div>

                                <div class="form-group my-3">
                                    <label for="Ip1BirthDate" class="my-1 col-sm-2 control-label">Birth Date<span class="required">*</span></label>
                                    <input required type="date" id="Ip1BirthDate" name="Ip1BirthDate" class="form-control" max="1984-10-30" min="1964-04-01" value="1984-10-02" required>
                                </div>
                                <div class="form-group my-3">
                                    <label for="Ip1IsSmoker" class="my-1 col-sm-2 control-label">Is Smoker<span class="required">*</span></label>
                                    <select name="Ip1IsSmoker" class="form-control" required>
                                        <option value="" selected>--select--</option>
                                        <option value="SMOKER">Smoker</option>
                                        <option value="NONSMOKER">Non Smoker</option>
                                    </select>
                                </div>

                                <div class="form-group my-3">
                                    <label for="Ip1Gender" class="my-1 col-sm-2 control-label">Gender<span class="required">*</span></label>
                                    <select name="Ip1Gender" id="Ip1Gender" class="form-control" required>
                                        <option value="" selected>--select--</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                </div>
                            </div>


                            <div class="section person-2 box-style">
                                <h5>Second Person Information<span class="required">*</span></h5>
                                <div class="form-group my-3">
                                    <label for="Ip2Name" class="my-1 col-sm-2 control-label">First Name<span class="required">*</span></label>
                                    <input type="text" id="Ip2Name" name="Ip2Name" class="form-control">
                                </div>

                                <div class="form-group my-3">
                                    <label for="Ip2Surname" class="my-1 col-sm-2 control-label">Last Name<span class="required">*</span></label>
                                    <input type="text" id="Ip2Surname" name="Ip2Surname" class="form-control">
                                </div>

                                <div class="form-group my-3">
                                    <label for="Ip2BirthDate" class="my-1 col-sm-2 control-label">Birth Date<span class="required">*</span></label>
                                    <input required type="date" id="Ip2BirthDate" name="Ip2BirthDate" class="form-control" max="1984-10-30" min="1964-04-01" value="1984-10-02">
                                </div>
                                <div class="form-group my-3">
                                    <label for="Ip2IsSmoker" class="my-1 col-sm-2 control-label">Is Smoker<span class="required">*</span></label>
                                    <select name="Ip2IsSmoker" class="form-control">
                                        <option value="" selected>--select--</option>
                                        <option value="SMOKER">Smoker</option>
                                        <option value="NONSMOKER">Non Smoker</option>
                                    </select>
                                </div>

                                <div class="form-group my-3">
                                    <label for="Ip2Gender" class="my-1 col-sm-2 control-label">Gender<span class="required">*</span></label>
                                    <select name="Ip2Gender" id="Ip2Gender" class="form-control">
                                        <option value="" selected>--select--</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="section box-style">
                                <h5>Mortgage Information<span class="required">*</span></h5>
                                <div class="form-group my-3">
                                    <label for="StartDate" class="my-1 col-sm-2 control-label">Start Date<span class="required">*</span></label>
                                    <input type="date" value="2022-10-10" id="StartDate" name="StartDate" class="form-control" required>
                                </div>

                                <div class="form-group my-3">
                                    <label for="InsuredAmount" class="my-1 col-sm-2 control-label">Insured Amount<span class="required">*</span></label>
                                    <input min="88850" max="20000000" type="number" id="InsuredAmount" name="InsuredAmount" class="form-control" value="150000.0" required>
                                </div>

                                <div class="form-group my-3">
                                    <label for="YearlyInterestPercentage" class="my-1 col-sm-2 control-label">Yearly Interest Percentage<span class="required">*</span></label>
                                    <input type="number" min="2" max="20"  value="2" id="YearlyInterestPercentage" name="YearlyInterestPercentage" class="form-control" required>
                                </div>

                                <div class="form-group my-3">
                                    <label for="CoverageDurationInMonths" class="my-1 col-sm-2 control-label">Coverage Duration In Months<span class="required">*</span></label>
                                    <input type="number" min="152" max="440"  value="240" id="CoverageDurationInMonths" name="CoverageDurationInMonths" class="form-control" required>
                                </div>
                                

                                <div class="form-group my-3">
                                    <label for="MonthsWithoutAmortization" class="my-1 col-sm-2 control-label">Months Without Amortization<span class="required">*</span></label>
                                    <input type="number" min="0" max="24" value="0" id="MonthsWithoutAmortization" name="MonthsWithoutAmortization" class="form-control" disabled>
                                </div>
                                
                                <div class="form-group my-3">
                                    <label for="CommissionPercentage" class="my-1 col-sm-2 control-label">Commission Percentage<span class="required">*</span></label>
                                    <input type="number" value="5" id="CommissionPercentage" name="CommissionPercentage" class="form-control" disabled>
                                </div>
                                
                                <div class="form-group my-3">
                                    <label for="CommissionFixedAmount" class="my-1 col-sm-2 control-label">Commission Fixed Amount<span class="required">*</span></label>
                                    <input type="number" value="0.0" id="CommissionFixedAmount" name="CommissionFixedAmount" class="form-control" disabled>
                                </div>
                                
                                <div class="form-group my-3">
                                    <input type="submit" name="calculate" class="btn btn-primary btn-lg" value="Calculate">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <?php return ob_get_clean();
	}

/* Client Updates 14-12-2022

You have to use one of these tarifs : FHP (family home protection), UFHP (ultimate family home protection), FLP (family loan protection).
it would be better to hide the id and persistence version and format the start and end date.
Please note: This message contains attachments that cannot be scanned. If the files seems suspicious or you weren't expecting to receive anything, we suggest you don't open or download them.Learn more
number of persons insred. cannot be higher then 2
we can only select "smoker" and not "non smoker" (can non smoker be the standard?)
fiscality can be removed
purpose type also
free coverage start date can be removed. and leave only the start date
formula can be left out
formula and frequency
months without amortization should be maximum 24
duration type can be removed
commission and commission fixed should not be able to be changed.
oh, and apparntly premium type, payment formula, payment frequency, payment and tariff code should also be removed
so basically customer only has to fill in: number of person, name, birth date, smoker/non-smoker, gender, start date, insured amount, percentage, coverage duration in months, months without (max 24


it’s already mentioned in results : MonthsWithoutAmortization limited to 0 CommissionPercentage limited to 10

oh and can you make the standard for smoker and gender 'select' in stead of 'smoker' and 'man'

and can you make the months without amortization standard to 0. And that people cannot adjust it. just as the commission percentage and commission fixed
*/