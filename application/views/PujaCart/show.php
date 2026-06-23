<head>

<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>

</head>
<style>
#eventone > div > div.multiselect-dropdown{display:none;}
body > section > div > span:nth-child(1){display:none;}
body > section > div > span:nth-child(2){display:none;}
    </style>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

if (!function_exists('hdbsPujaYtdTierName')) {
    function hdbsPujaYtdTierName($amount, $tiers) {
        $amount = (float) $amount;
        if (!is_array($tiers)) {
            return '';
        }

        foreach ($tiers as $tier) {
            $minAmount = isset($tier['min_amount']) ? (float) $tier['min_amount'] : 0;
            $maxAmount = ($tier['max_amount'] === null || $tier['max_amount'] === '') ? null : (float) $tier['max_amount'];
            if ($amount >= $minAmount && ($maxAmount === null || $amount <= $maxAmount)) {
                return strtolower((string) $tier['tier_name']);
            }
        }

        return '';
    }
}

if (!function_exists('hdbsPujaYtdIsTier')) {
    function hdbsPujaYtdIsTier($amount, $tiers, $tierNames) {
        $currentTier = hdbsPujaYtdTierName($amount, $tiers);
        foreach ((array) $tierNames as $tierName) {
            if ($currentTier === strtolower((string) $tierName)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('hdbsPujaYtdIsEmeraldDiamondGap')) {
    function hdbsPujaYtdIsEmeraldDiamondGap($amount, $tiers) {
        $amount = (float) $amount;
        $emeraldMax = null;
        $diamondMin = null;

        if (!is_array($tiers)) {
            return false;
        }

        foreach ($tiers as $tier) {
            $tierName = strtolower((string) ($tier['tier_name'] ?? ''));
            if ($tierName === 'emerald' && isset($tier['max_amount']) && $tier['max_amount'] !== '') {
                $emeraldMax = (float) $tier['max_amount'];
            }
            if ($tierName === 'diamond' && isset($tier['min_amount'])) {
                $diamondMin = (float) $tier['min_amount'];
            }
        }

        return $emeraldMax !== null && $diamondMin !== null && $amount > $emeraldMax && $amount < $diamondMin;
    }
}

$pujaYtdTiers = $tpl['puja_ytd_tiers'] ?? array();
$pujaFreeSankalpaMin = 2200;
$pujaDiamondMin = 5000;
$pujaDoubleSponsorMin = 10001;
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100" style= "text-align: -webkit-center;">
        <?php
        if (!empty($_SESSION['myValue'])) {
            $_SESSION['myValue'] = array_merge([
                'oid' => '',
                'pay_date' => '',
                'id' => '',
                'membercategory' => '',
                'Member_id' => '',
                'donation' => 0,
                'extraparentregistration' => 0,
                'extrachildregistration' => 0,
                'extraadultregistration' => 0,
                'discountseniorprice' => 0,
                'magazineprice' => 0,
                'PaymentOption' => '',
                'First_name' => '',
                'Last_name' => '',
                'puja_type' => '',
                'amount' => 0,
                'totalamount' => 0,
                'member_optional_child' => 0,
                'adult_member_count' => 0,
            ], $_SESSION['myValue']);

            $_SESSION['ytdvalue'] = $_SESSION['ytdvalue'] ?? (float)$_SESSION['myValue']['donation'];
            $_SESSION['pujareg'] = $_SESSION['pujareg'] ?? '';
            $_SESSION['sponsoreventfirst'] = $_SESSION['sponsoreventfirst'] ?? '';
            $_SESSION['sponsoreventsecond'] = $_SESSION['sponsoreventsecond'] ?? '';
            $_SESSION['pujasankalpaattempt1arr'] = $_SESSION['pujasankalpaattempt1arr'] ?? '';
            $_SESSION['pujasankalpaattempt2arr'] = $_SESSION['pujasankalpaattempt2arr'] ?? '';
            $_SESSION['CategoryAarr'] = $_SESSION['CategoryAarr'] ?? [];
            $_SESSION['CategoryBarr'] = $_SESSION['CategoryBarr'] ?? [];
            $dataregister = $dataregister ?? '';

            $alldonationdata =  $_SESSION['myValue'];
            $orderid = $_SESSION['myValue']['oid'];
            $datefor = $_SESSION['myValue']['pay_date'];
            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
            $paymentid = $_SESSION['myValue']['id'];
            $membertype = $_SESSION['myValue']['membercategory'];
            $memberid = $_SESSION['myValue']['Member_id'];
            $newytd = $_SESSION['ytdvalue'];
            $pujaregistered = $_SESSION['pujareg'];
            $sponsoreventfirst = $_SESSION['sponsoreventfirst'];
            $sponsoreventsecond = $_SESSION['sponsoreventsecond'];
            $amountdonation = $_SESSION['myValue']['donation'];

            $pujaregisteredfirstattempt =  $_SESSION['pujasankalpaattempt1arr'];
            $pujaregisteredsecondattempt =   $_SESSION['pujasankalpaattempt2arr'];

            $signdollar = "<span style= 'color:red;'>$</span>";
            $finaldoationui = $signdollar . "" . $amountdonation;

            $uiytd = $_SESSION['ytdvalue'];
            $ytdamountui = $signdollar . "" . $uiytd;
            
            $parentregistration = $_SESSION['myValue']['extraparentregistration'];
            $finalparentprice = $signdollar ."".$parentregistration;

            $adultchildregistration = $_SESSION['myValue']['extraadultregistration'] ?? 0;
            $finaladultchildprice = $signdollar ."".$adultchildregistration;
            
            $seniordiscount =  $_SESSION['myValue']['discountseniorprice'];
            $finaldiscount = $signdollar ."".$seniordiscount;
            
            $extramagazine =  $_SESSION['myValue']['magazineprice'];
            $finalextramagazine = $signdollar ."".$extramagazine;
            
            $today = date("m/d/Y"); 
            $registrationDate = $today;
            
            if ($_SESSION['myValue']['PaymentOption'] == 'stripe') {
                ?>
                     <table border="4" width='585px'>
                                 <tr>
                                <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td style='width:50%;'>order Id</td> <td style='width:50%;'><?php echo $_SESSION['myValue']['oid']; ?></td></td></tr>
                                <tr><td>Member Id</td> <td><?php echo $_SESSION['myValue']['Member_id']; ?></td></td></tr>
                                <tr><td>Full Name</td> <td><?php echo $_SESSION['myValue']['First_name'] . ' ' . $_SESSION['myValue']['Last_name']; ?></td></tr>
                                <tr><td>Puja Type</td> <td><?php echo $_SESSION['myValue']['puja_type']; ?></td></tr>
                                <tr><td>Puja Price</td> <td><span style="color:red;">$</span><?php echo $_SESSION['myValue']['amount']; ?></td></tr>
                                 <?php if($_SESSION['myValue']['magazineprice']  != 0){ ?>
                                <tr><td>Magazine(Additional)</td><td><?php echo $finalextramagazine; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['extraparentregistration']  != 0){ ?>
                                <tr><td>Parent Registration</td><td><?php echo $finalparentprice; ?></td></tr>
                                <?php } ?>
                                <?php if(($_SESSION['myValue']['extraadultregistration'] ?? 0)  != 0){ ?>
                                <tr><td>22+ Unmarried Adult Registration</td><td><?php echo $finaladultchildprice; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['discountseniorprice']  != 0){ ?>
                                <tr><td>Senior Discount</td><td><?php echo $finaldiscount; ?></td></tr>
                                <?php } ?>
                                <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <tr><td>Donation Amount</td><td><?php echo $finaldoationui; ?></td></tr>
                                    <tr><td>New Ytd</td><td><?php echo $ytdamountui; ?></td></tr>
                                <?php } ?>
                                <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span><?php echo $_SESSION['myValue']['totalamount']; ?></td> </tr>
                                <tr><td>Payment Method</td> <td><?php echo "Credit Card"; ?></td></tr>
                                <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                <tr><td>Payment Status</td> <td>Succeeded</td></tr>
                                <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                                <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver')) {
                                        //echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You are eligible for parking at</span> Green Field at a discounted rate (KB Parking if Senior FP/PM)</td></tr>";
                                        
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option>
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                                  }
                                                  ?>


<!-- second time show puja option condition total work Start -->
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>

                                                 <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver') && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option> 
                                
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                        }
                                        ?>
<!-- second time show puja option condition total work Start -->
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                 <tr style="display:none" id="sankalpaselected"><td>Sankalpa Puja</td> <td id="selectpuja"></td></tr>
                                                <tr style="display:none" id="event1"><td>Sponsor Event Name Category A</td> <td id="sponsoreventame"></td></tr>
                                                <tr style="display:none" id="event2"><td>Sponsor Event Name Category B</td> <td id="sponsoreventcategorydatatr"></td></tr>
                                            <?php } ?>
                                            <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                                  
                            </tr> 
                        </table> 
                        <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                            <a href="<?php echo INSTALL_URL; ?>PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                        <?php } ?>
                        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <a href="<?php echo INSTALL_URL; ?>Pujaregistration/index">Go to home</a> 
                        
                        <?php } ?>
                    <?php
            }
            // for check 
            else if ($_SESSION['myValue']['PaymentOption'] == 'check') {
                ?>
                            <table border="4" width='585px'>
                                        <tr>
                                       <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                                   </tr>
                                       <tr>
                                       <tr><td style='width:50%;'>order Id</td> <td style='width:50%;'><?php echo $_SESSION['myValue']['oid']; ?></td></td></tr>
                                       <tr><td>Member Id</td> <td><?php echo $_SESSION['myValue']['Member_id']; ?></td></td></tr>
                                       <tr><td>Full Name</td> <td><?php echo $_SESSION['myValue']['First_name'] . ' ' . $_SESSION['myValue']['Last_name']; ?></td></tr>
                                       <tr><td>Puja Type</td> <td><?php echo $_SESSION['myValue']['puja_type'];
                                       ; ?></td></tr>
                                       <tr><td>Puja Price</td> <td><span style="color:red;">$</span><?php echo $_SESSION['myValue']['amount']; ?></td></tr>
                                    <?php if($_SESSION['myValue']['magazineprice']  != 0){ ?>
                                <tr><td>Magazine(Additional)</td><td><?php echo $finalextramagazine; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['extraparentregistration']  != 0){ ?>
                                <tr><td>Parent Registration</td><td><?php echo $finalparentprice; ?></td></tr>
                                <?php } ?>
                                <?php if(($_SESSION['myValue']['extraadultregistration'] ?? 0)  != 0){ ?>
                                <tr><td>22+ Unmarried Adult Registration</td><td><?php echo $finaladultchildprice; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['discountseniorprice']  != 0){ ?>
                                <tr><td>Senior Discount</td><td><?php echo $finaldiscount; ?></td></tr>
                                <?php } ?>
                                   <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                       <tr><td>Donation Amount</td><td><?php echo $finaldoationui; ?></td></tr>
                                       <tr><td>New Ytd</td><td><?php echo $ytdamountui; ?></td></tr>
                                   <?php } ?>
                                       <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span><?php echo $_SESSION['myValue']['totalamount']; ?></td> </tr>
                                       <tr><td>Payment Method</td> <td><?php echo "Check"; ?></td></tr>
                                       <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                       <tr><td>Payment Status</td> <td>Succeeded</td></tr>
                                       <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                                       <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver')) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You are eligible for parking at</span> Green Field at a discounted rate (KB Parking if Senior FP/PM)</td></tr>";
                                        //echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option>
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                                  }
                                                  ?>


<!-- second time show puja option condition total work Start -->
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>

                                                 <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver') && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option> 
                                
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                        }
                                        ?>
<!-- second time show puja option condition total work Start -->
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                 <tr style="display:none" id="sankalpaselected"><td>Sankalpa Puja</td> <td id="selectpuja"></td></tr>
                                                <tr style="display:none" id="event1"><td>Sponsor Event Name Category A</td> <td id="sponsoreventame"></td></tr>
                                                <tr style="display:none" id="event2"><td>Sponsor Event Name Category B</td> <td id="sponsoreventcategorydatatr"></td></tr>
                                            <?php } ?>
                                            <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                                  
                            </tr> 
                        </table>                            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                               <a href="<?php echo INSTALL_URL; ?>PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                           <?php } ?>
                           <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                               <a href="<?php echo INSTALL_URL; ?>Pujaregistration/index">Go to home</a> 
                        
                           <?php } ?>
                           <?php
            }

            // for cash
            else if ($_SESSION['myValue']['PaymentOption'] == 'cash') {
                ?>
                                   <table border="4" width='585px'>
                                               <tr>
                                              <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                                          </tr>
                                              <tr>
                                              <tr><td style='width:50%;'>order Id</td> <td style='width:50%;'><?php echo $_SESSION['myValue']['oid']; ?></td></td></tr>
                                              <tr><td>Member Id</td> <td><?php echo $_SESSION['myValue']['Member_id']; ?></td></td></tr>
                                              <tr><td>Full Name</td> <td><?php echo $_SESSION['myValue']['First_name'] . ' ' . $_SESSION['myValue']['Last_name']; ?></td></tr>
                                              <tr><td>Puja Type</td> <td><?php echo $_SESSION['myValue']['puja_type'];
                                              ; ?></td></tr>
                                              <tr><td>Puja Price</td> <td><span style="color:red;">$</span><?php echo $_SESSION['myValue']['amount']; ?></td></tr>
                                           <?php if($_SESSION['myValue']['magazineprice']  != 0){ ?>
                                <tr><td>Magazine(Additional)</td><td><?php echo $finalextramagazine; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['extraparentregistration']  != 0){ ?>
                                <tr><td>Parent Registration</td><td><?php echo $finalparentprice; ?></td></tr>
                                <?php } ?>
                                <?php if(($_SESSION['myValue']['extraadultregistration'] ?? 0)  != 0){ ?>
                                <tr><td>22+ Unmarried Adult Registration</td><td><?php echo $finaladultchildprice; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['discountseniorprice']  != 0){ ?>
                                <tr><td>Senior Discount</td><td><?php echo $finaldiscount; ?></td></tr>
                                <?php } ?>
                                          <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                              <tr><td>Donation Amount</td><td><?php echo $finaldoationui; ?></td></tr>
                                              <tr><td>New Ytd</td><td><?php echo $ytdamountui; ?></td></tr>
                                          <?php } ?>
                                              <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span><?php echo $_SESSION['myValue']['totalamount']; ?></td> </tr>
                                              <tr><td>Payment Method</td> <td><?php echo "Cash"; ?></td></tr>
                                              <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                              <tr><td>Payment Status</td> <td>Succeeded</td></tr>
                                              <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                                              <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver')) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You are eligible for parking at</span> Green Field at a discounted rate (KB Parking if Senior FP/PM)</td></tr>";
                                        //echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option>
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                                  }
                                                  ?>


<!-- second time show puja option condition total work Start -->
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>

                                                 <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver') && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option> 
                                
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                        }
                                        ?>
<!-- second time show puja option condition total work Start -->
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                 <tr style="display:none" id="sankalpaselected"><td>Sankalpa Puja</td> <td id="selectpuja"></td></tr>
                                                <tr style="display:none" id="event1"><td>Sponsor Event Name Category A</td> <td id="sponsoreventame"></td></tr>
                                                <tr style="display:none" id="event2"><td>Sponsor Event Name Category B</td> <td id="sponsoreventcategorydatatr"></td></tr>
                                            <?php } ?>
                                            <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                                  
                            </tr> 
                        </table> 
                                  <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                                      <a href="<?php echo INSTALL_URL; ?>PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                                  <?php } ?>
                                  <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                      <a href="<?php echo INSTALL_URL; ?>Pujaregistration/index">Go to home</a>  
                                    <!-- <a href="http://localhost/7june/Pujaregistration/index">Go to home</a>-->
                      
                                 <?php } ?>
                                  <?php
            }


            // for directdeposite 
            else if ($_SESSION['myValue']['PaymentOption'] == 'directdeposit') {
                ?>
                                         <table border="4" width='585px'>
                                                     <tr>
                                                    <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                                                </tr>
                                                    <tr>
                                                    <tr><td style='width:50%;'>order Id</td> <td style='width:50%;'><?php echo $_SESSION['myValue']['oid']; ?></td></td></tr>
                                                    <tr><td>Member Id</td> <td><?php echo $_SESSION['myValue']['Member_id']; ?></td></td></tr>
                                                    <tr><td>Full Name</td> <td><?php echo $_SESSION['myValue']['First_name'] . ' ' . $_SESSION['myValue']['Last_name']; ?></td></tr>
                                                    <tr><td>Puja Type</td> <td><?php echo $_SESSION['myValue']['puja_type']; ?></td></tr>
                                                    <tr><td>Puja Price</td> <td><span style="color:red;">$</span><?php echo $_SESSION['myValue']['amount']; ?></td></tr>
                                                 <?php if($_SESSION['myValue']['magazineprice']  != 0){ ?>
                                <tr><td>Magazine(Additional)</td><td><?php echo $finalextramagazine; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['extraparentregistration']  != 0){ ?>
                                <tr><td>Parent Registration</td><td><?php echo $finalparentprice; ?></td></tr>
                                <?php } ?>
                                <?php if(($_SESSION['myValue']['extraadultregistration'] ?? 0)  != 0){ ?>
                                <tr><td>22+ Unmarried Adult Registration</td><td><?php echo $finaladultchildprice; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['discountseniorprice']  != 0){ ?>
                                <tr><td>Senior Discount</td><td><?php echo $finaldiscount; ?></td></tr>
                                <?php } ?>
                                                <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                                    <tr><td>Donation Amount</td><td><?php echo $finaldoationui; ?></td></tr>
                                                    <tr><td>New Ytd</td><td><?php echo $ytdamountui; ?></td></tr>
                                                <?php } ?>
                                                    <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span><?php echo $_SESSION['myValue']['totalamount']; ?></td> </tr>
                                                    <tr><td>Payment Method</td> <td><?php echo "Direct Deposit"; ?></td></tr>
                                                    <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                                    <tr><td>Payment Status</td> <td>Succeeded</td></tr>
                                                    <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                                                    <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver')) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You are eligible for parking at</span> Green Field at a discounted rate (KB Parking if Senior FP/PM)</td></tr>";
                                        //echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option>
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                                  }
                                                  ?>


<!-- second time show puja option condition total work Start -->
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>

                                                 <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver') && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option> 
                                
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                        }
                                        ?>
<!-- second time show puja option condition total work Start -->
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                 <tr style="display:none" id="sankalpaselected"><td>Sankalpa Puja</td> <td id="selectpuja"></td></tr>
                                                <tr style="display:none" id="event1"><td>Sponsor Event Name Category A</td> <td id="sponsoreventame"></td></tr>
                                                <tr style="display:none" id="event2"><td>Sponsor Event Name Category B</td> <td id="sponsoreventcategorydatatr"></td></tr>
                                            <?php } ?>
                                            <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                                  
                            </tr> 
                        </table>  
                                        <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                                            <a href="<?php echo INSTALL_URL; ?>PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                                        <?php } ?>
                                        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                            <a href="<?php echo INSTALL_URL; ?>Pujaregistration/index">Go to home</a> 
                        
                                        <?php } ?>
                                        <?php
            }

            // for check 
            else if ($_SESSION['myValue']['PaymentOption'] == 'sumup') {
                ?>
                                             <table border="4" width='585px'>
                                                         <tr>
                                                        <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                                                    </tr>
                                                        <tr>
                                                        <tr><td style='width:50%;'>order Id</td> <td style='width:50%;'><?php echo $_SESSION['myValue']['oid']; ?></td></td></tr>
                                                        <tr><td>Member Id</td> <td><?php echo $_SESSION['myValue']['Member_id']; ?></td></td></tr>
                                                        <tr><td>Full Name</td> <td><?php echo $_SESSION['myValue']['First_name'] . ' ' . $_SESSION['myValue']['Last_name']; ?></td></tr>
                                                        <tr><td>Puja Type</td> <td><?php echo $_SESSION['myValue']['puja_type'];
                                                        ; ?></td></tr>
                                                        <tr><td>Puja Price</td> <td><span style="color:red;">$</span><?php echo $_SESSION['myValue']['amount']; ?></td></tr>
                                                    <?php if($_SESSION['myValue']['magazineprice']  != 0){ ?>
                                <tr><td>Magazine(Additional)</td><td><?php echo $finalextramagazine; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['extraparentregistration']  != 0){ ?>
                                <tr><td>Parent Registration</td><td><?php echo $finalparentprice; ?></td></tr>
                                <?php } ?>
                                <?php if(($_SESSION['myValue']['extraadultregistration'] ?? 0)  != 0){ ?>
                                <tr><td>22+ Unmarried Adult Registration</td><td><?php echo $finaladultchildprice; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['discountseniorprice']  != 0){ ?>
                                <tr><td>Senior Discount</td><td><?php echo $finaldiscount; ?></td></tr>
                                <?php } ?>
                                                    <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                                        <tr><td>Donation Amount</td><td><?php echo $finaldoationui; ?></td></tr>
                                                        <tr><td>New Ytd</td><td><?php echo $ytdamountui; ?></td></tr>
                                                    <?php } ?>
                                                        <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span><?php echo $_SESSION['myValue']['totalamount']; ?></td> </tr>
                                                        <tr><td>Payment Method</td> <td><?php echo "SumUp"; ?></td></tr>
                                                        <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                                        <tr><td>Payment Status</td> <td>Succeeded</td></tr>
                                                        <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                                                        <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver')) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You are eligible for parking at</span> Green Field at a discounted rate (KB Parking if Senior FP/PM)</td></tr>";
                                        //echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option>
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                                  }
                                                  ?>


<!-- second time show puja option condition total work Start -->
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>

                                                 <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver') && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option> 
                                
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                        }
                                        ?>
<!-- second time show puja option condition total work Start -->
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                 <tr style="display:none" id="sankalpaselected"><td>Sankalpa Puja</td> <td id="selectpuja"></td></tr>
                                                <tr style="display:none" id="event1"><td>Sponsor Event Name Category A</td> <td id="sponsoreventame"></td></tr>
                                                <tr style="display:none" id="event2"><td>Sponsor Event Name Category B</td> <td id="sponsoreventcategorydatatr"></td></tr>
                                            <?php } ?>
                                            <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                                  
                            </tr> 
                        </table> 
                                            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                                                <a href="<?php echo INSTALL_URL; ?>PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                                            <?php } ?>
                                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                                <a href="<?php echo INSTALL_URL; ?>Pujaregistration/index">Go to home</a> 
                        
                                            <?php } ?>
                                            <?php
            } else if ($_SESSION['myValue']['PaymentOption'] == 'others') {
                ?>
                                                 <table border="4" width='585px' style= "text-align: -webkit-center;" >
                                                             <tr>
                                                            <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                                                        </tr>
                                                            <tr>
                                                            <tr><td>order Id</td> <td><?php echo $_SESSION['myValue']['oid']; ?></td></td></tr>
                                                            <tr><td>Member Id</td> <td><?php echo $_SESSION['myValue']['Member_id']; ?></td></td></tr>
                                                            <tr><td>Full Name</td> <td><?php echo $_SESSION['myValue']['First_name'] . ' ' . $_SESSION['myValue']['Last_name']; ?></td></tr>
                                                            <tr><td>Puja Type</td> <td><?php echo $_SESSION['myValue']['puja_type'];
                                                            ; ?></td></tr>
                                                            <tr><td>Puja Price</td> <td><span style="color:red;">$</span><?php echo $_SESSION['myValue']['amount']; ?></td></tr>
                                                        <?php if($_SESSION['myValue']['magazineprice']  != 0){ ?>
                                <tr><td>Magazine(Additional)</td><td><?php echo $finalextramagazine; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['extraparentregistration']  != 0){ ?>
                                <tr><td>Parent Registration</td><td><?php echo $finalparentprice; ?></td></tr>
                                <?php } ?>
                                <?php if(($_SESSION['myValue']['extraadultregistration'] ?? 0)  != 0){ ?>
                                <tr><td>22+ Unmarried Adult Registration</td><td><?php echo $finaladultchildprice; ?></td></tr>
                                <?php } ?>
                                <?php if($_SESSION['myValue']['discountseniorprice']  != 0){ ?>
                                <tr><td>Senior Discount</td><td><?php echo $finaldiscount; ?></td></tr>
                                <?php } ?>
                                                        <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                                            <tr><td>Donation Amount</td><td><?php echo $finaldoationui; ?></td></tr>
                                                            <tr><td>New Ytd</td><td><?php echo $ytdamountui; ?></td></tr>
                                                        <?php } ?>
                                                            <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span><?php echo $_SESSION['myValue']['totalamount']; ?></td> </tr>
                                                            <tr><td>Payment Method</td> <td><?php echo "Zelle"; ?></td></tr>
                                                            <tr><td>Pay Date</td> <td><?php echo $payfinaldate; ?></td></tr>
                                                            <tr><td>Payment Status</td> <td>Succeeded</td></tr>
                                                            <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
                                                            <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver')) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You are eligible for parking at</span> Green Field at a discounted rate (KB Parking if Senior FP/PM)</td></tr>";
                                        //echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option>
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                                  }
                                                  ?>


<!-- second time show puja option condition total work Start -->
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>

                                                 <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Silver') && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Platinum')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && (hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, array('Emerald', 'Diamond')) || hdbsPujaYtdIsEmeraldDiamondGap($_SESSION['ytdvalue'], $pujaYtdTiers))) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && !hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Diamond')) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && hdbsPujaYtdIsTier($_SESSION['ytdvalue'], $pujaYtdTiers, 'Gold') && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaFreeSankalpaMin && $_SESSION['ytdvalue'] < $pujaDiamondMin && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
                                 <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                 <option value='Maha Saptami'>Maha Saptami</option>
						         <option value='Maha Astami'>Maha Astami</option>
						         <option value='Maha Nabami'>Maha Nabami</option>
						         <option value='Lakshmi Puja'>Lakshmi Puja</option>
						         <option value='Kali Puja'>Kali Puja</option>
						         <option value='Saraswati Puja'>Saraswati Puja</option> 
                                
                            </select>
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name='pujaparkingdata'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                    ";
                                        }
                                        ?>
<!-- second time show puja option condition total work Start -->
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>


                                           <!--  update condition new 20 july  -->
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
            <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                              }
                                              ?>
                                              <!-- new 20 july end -->
                                                <!--  update condition new 20 july  -->
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                    </select>
                </td>
            </tr> 
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'   type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                            }
                                            ?>
                                               <!-- new 20 july end -->
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                                                                      ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
<!-- 20 july  add new condition -->

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDiamondMin && $_SESSION['ytdvalue'] < $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
                   echo " <tr id='eligiblemsg' style='color:red;'><td colspan='2'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span> Select 1 from the option below.</td></tr>
                    <tr class=tr' id='optiondropdown'>
                    <td class='td'>Event Sponsorship</td>
                        <td class='td' colspan='2' id='eventone'>
                        "
                         ?>
                                            <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                            <?php
                                            foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                                ?>
                                              <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                          <?php
                                            }
                                            ?>
                                   </select>
                                   <?php

                                   echo "
   
                        </td>
                    </tr>
                    <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>";
                                                              }
                                                              ?>
                                                              <!-- 20july new condition end -->

                                                             <!-- second time show puja option condition total work end  -->

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                         ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                                        ?>
                                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                                <?php
                                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                                    ?>
                                                  <option value=''>Nothing Selected</option> 
                                                  <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                              <?php
                                                }
                                                ?>
                                       </select>
                                       <?php

                                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                 }
                                                 ?>
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                    ?>
                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                           <?php
                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                               ?>
                               <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                           <?php
                           }
                           ?>
                    </select>
                    <?php
                    echo "
                        </td>
                        </tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                        ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
            }
            ?>
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                      ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
              }
              ?>
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                             ?>
                                         <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                         <?php
                                         foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                         }
                                         ?>
                                  </select>
                                  <?php
                                  echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                     }
                                     ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Tithi Maha Sashti'>Tithi Maha Sashti</option>
                                 <option value='Tithi Maha Saptami'>Tithi Maha Saptami</option>
                                 <option value='Tithi Maha Astami'>Tithi Maha Astami</option>
                                 <option value='Tithi Maha Nabami'>Tithi Maha Nabami</option>
                                 <option value='Tithi Kali Puja'>Tithi Kali Puja</option>
                                 <option value='Tithi Saraswati Puja'>Tithi Saraswati Puja</option>
                                 <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
                                <option value='Tithi Sandhi Puja'>Tithi Sandhi Puja</option>
                                <option value='Sandhi Puja'>Sandhi Puja</option>
                                <option value='Maha Nabami'>Maha Nabami</option>
                                <option value='Lakshmi Puja'>Lakshmi Puja</option>
                                <option value='Kali Puja'>Kali Puja</option>
                                <option value='Saraswati Puja'>Saraswati Puja</option>
                       </select>
                       </td>
                       </tr> 
                         <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                                      echo "
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 2 from Category A or 1 from Category B).</td></tr>
                       <tr class=tr' id='optiondropdown'>
                       <td class='td'>Category A</td>
                       <td class='td'id='eventone'>
                       "
                                                          ?>
                                           <select  name='type[]'  id='sponsor' class='form-control input-sm selectpicker' aria-required='true' aria-invalid='false' onchange='myFunction()' multiple required>
                                           <?php
                                           foreach ($_SESSION['CategoryAarr'] as $key => $value) {
                                               ?>
                                             <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                         <?php
                                           }
                                           ?>
                                    </select>
                                    <?php
                                    echo "
                        </td>
                        </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                                                  }
                                                  ?>
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= $pujaDoubleSponsorMin && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                       echo "     
                       <tr id='eligiblemsg'><td colspan='2' style='color:red;'><span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for: Event Sponsorship</span>(Select 1 from Category B).</td></tr>
                        <tr class=tr' id='optiondropdown2'>
                         <td class='td'>Category B</td>
                            <td class='td' id='twoevent'>
                            "
                           ?>
                                  <select  name='type' id='sponsoreventcategory2'  class='form-control input-sm' aria-required='true'onchange='mysponsorcategory2()' aria-invalid='false' required>
                                <?php
                                foreach ($_SESSION['CategoryBarr'] as $key => $value) {
                                    ?>
                                    <option value=''>Nothing Selected</option> 
                                    <option value="<?php echo $value['itemname']; ?>"><?php echo $value['itemname']; ?></option> 
                                                                <?php
                                }
                                ?>
                       </select>
                       <?php

                       echo "
                            </td>
                                </tr>
                                <tr id='submitbuttontr'><td colspan='2'><button id='requestsubmit' class='btn btn-primary'  name=''  type='submit' onclick='nextscreen()'><i class='fa fa-fw fa-save'></i>&nbsp;&nbsp;Submit</button></td></tr>
                                ";
                   }
                   ?>
                                                 <tr style="display:none" id="sankalpaselected"><td>Sankalpa Puja</td> <td id="selectpuja"></td></tr>
                                                <tr style="display:none" id="event1"><td>Sponsor Event Name Category A</td> <td id="sponsoreventame"></td></tr>
                                                <tr style="display:none" id="event2"><td>Sponsor Event Name Category B</td> <td id="sponsoreventcategorydatatr"></td></tr>
                                            <?php } ?>
                                            <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                                  
                            </tr> 
                        </table>  
                                                <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                                                    <a href="<?php echo INSTALL_URL; ?>PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                                                <?php } ?>
                                                <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                                    <a href="<?php echo INSTALL_URL; ?>Pujaregistration/index">Go to home</a> 
                        
                                                <?php } ?>
                                                <?php

            }
            else if ($_SESSION['myValue']['PaymentOption'] == 'ComplimentaryRegistration') {
                ?>
            <table border="4" width='585px' style= "text-align: -webkit-center;" >
                <tr>
                <td colspan='2'> <img src='<?php echo INSTALL_URL; ?>thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                </tr>
                <tr>
                <tr><td>order Id</td> <td><?php echo $_SESSION['myValue']['oid']; ?></td></td></tr>
                <tr><td>Member Id</td> <td><?php echo $_SESSION['myValue']['Member_id']; ?></td></td></tr>
                <tr><td>Full Name</td> <td><?php echo $_SESSION['myValue']['First_name'] . ' ' . $_SESSION['myValue']['Last_name']; ?></td></tr>
                <tr><td>Puja Type</td> <td><?php echo $_SESSION['myValue']['puja_type'];?></td></tr>
                <tr><td>Payment Method</td> <td><?php echo "Complimentary Registration"; ?></td></tr>
                <tr><td>Pay Date</td> <td><?php echo $registrationDate; ?></td></tr>
                <tr><td>Payment Status</td> <td>Confirmed</td></tr>
                <tr><td colspan="2" style="font-weight: bold;color:red;">An email with your payment information has been sent to your registered email address. Please check your spam folder if you cannot find the email in your inbox</td></tr>
            </table>  
            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                <a href="<?php echo INSTALL_URL; ?>PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
            <?php } ?>
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                 <a href="<?php echo INSTALL_URL; ?>Pujaregistration/index">Go to home</a> 
               
            <?php } ?>
            <?php 
         }
        } else {
            ?>
                <div class="alert alert-success  in">
                    <i class="fa-fw fa fa-check"></i>
                    <strong><?php echo __('success'); ?></strong>
                </div>
                <?php
        }
        ?>
    </div>
</section>


<script>

var pujaFreeSankalpaMin = <?php echo json_encode($pujaFreeSankalpaMin); ?>;
var pujaDiamondMin = <?php echo json_encode($pujaDiamondMin); ?>;
var pujaDoubleSponsorMin = <?php echo json_encode($pujaDoubleSponsorMin); ?>;

function myFunction() {

       //alert('hello');
       var txtstarttime = $("#sponsor option:selected").text();
       var mynewytd = <?php echo (json_encode($newytd)); ?>;
       if(txtstarttime != ""){
            $('#sponsoreventcategory2').attr('disabled', true);
            $("#sponsoreventcategory2").val("");
            }else{ 
            $('#sponsoreventcategory2').attr('disabled', false);
            $("#sponsoreventcategory2").val("");
            }
     var selected = [];
        for (var option of document.getElementById('sponsor').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        selectpuja = selected;
        if (mynewytd >= pujaDiamondMin && mynewytd < pujaDoubleSponsorMin){
            if (selectpuja.length > 1) {
                selectpuja.splice(-1);
                $("#sponsor").val(selectpuja);
                    alert("Please Select only one");
                    $('.selectpicker').selectpicker('deselectAll');
                } else {
                    last_valid_selection = $(this).val();
                }
        }
        if (mynewytd >= pujaDoubleSponsorMin) {
                if (selectpuja.length > 2) {
                    selectpuja.splice(-1);
                    $("#sponsor").val(selectpuja);
                    alert("Please Select only Two");
                    $('.selectpicker').selectpicker('deselectAll');
                } else {
                    last_valid_selection = $(this).val();
                }

            }
       
    }
// end
    function nextscreen(){

    var donationArray = <?php echo json_encode($alldonationdata); ?>;
    var membercategory = <?php echo json_encode($membertype); ?>;
    var  registrationdata = "pujaregistrationdata";

    var member_idpay = <?php echo (json_encode($memberid)); ?>;
    var paydate = <?php echo (json_encode($datefor)); ?>;
    var finaldonationid = <?php echo (json_encode($paymentid)); ?>;
    var selectsankalpapuja = $("#pujasankalp").val();
    var categone = $("#sponsor option:selected").text();
    var categtwo = $("#sponsoreventcategory2").val();
    var totalnewytd = <?php echo json_encode($newytd); ?>;

    var url2 = $("#container-abc-url-id").text();
    
    if(totalnewytd >= pujaFreeSankalpaMin && totalnewytd < pujaDiamondMin && selectsankalpapuja !== "" && selectsankalpapuja != undefined){
        pujasankalpaattempt1 = '1';
        pujasankalpaattempt2 = '0';
    }
    else if(totalnewytd >= pujaDiamondMin && selectsankalpapuja !== "" && selectsankalpapuja != undefined){
        pujasankalpaattempt1 = '0';
        pujasankalpaattempt2 = '1';
     }
     else{
        pujasankalpaattempt1 = '';
        pujasankalpaattempt2 = ''; 
        }
    if((selectsankalpapuja != "" && selectsankalpapuja != undefined) ||
        (categone != "" && categone != undefined) ||
        (categtwo != "" && categtwo != undefined)){
    pujanamecategory = [selectsankalpapuja, membercategory, registrationdata];
    $.ajax({
            type: "POST",
            data: {
                finaldonationid: finaldonationid,
                sankalpapuja: selectsankalpapuja,
                categone: categone,
                categtwo: categtwo, 
                member_idpay: member_idpay,
                paydate: paydate, 
                pujasankalpaattempt1:  pujasankalpaattempt1,
                pujasankalpaattempt2:  pujasankalpaattempt2 ,

            },
            //url: "https://durgabari.org/HDBS_PaymentNew/load.php?controller=RentalBooking&action=locationprice",
           url: url2 + "load.php?controller=PujaDonations&action=pujaparkingdata",
        
        });
    
    }
    //var categtwo = $("#sponsorevent").val();
    if(selectsankalpapuja !="" && categone !="" && categtwo!==undefined && categtwo!=="" ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#submitbuttontr").hide();
    $("#sankalpaselected").show();
    $("#event1").show();
    $("#event2").show();
    document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
    document.getElementById('sponsoreventame').innerHTML = categone;
    document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;
  
   if(selectsankalpapuja !=""){
      sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
      sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
      window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");

   }
    

}
else if(selectsankalpapuja !="" && categone ==""  && categtwo !="" && categtwo==undefined){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#submitbuttontr").hide();
    $("#sankalpaselected").show();
    $("#event1").hide();
    $("#event2").hide();
    document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
    if(selectsankalpapuja !=""){
   sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
   sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
   window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");

    }

}
else if(selectsankalpapuja == undefined  && categone =="" && categtwo !="" ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#submitbuttontr").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#sankalpaselected").hide();
    $("#event1").hide();
    $("#event2").show();
    document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

}

else if(selectsankalpapuja !="" && categone ==""  && categtwo =="" ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#submitbuttontr").hide();
    $("#sankalpaselected").show();
    $("#event1").hide();
    $("#event2").hide();
    document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
    if(selectsankalpapuja !=""){
     sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
     sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
     window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");

    }
}
else if(selectsankalpapuja !="" && categone ==""  && categtwo !="" ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#submitbuttontr").hide();
    $("#sankalpaselected").show();
    $("#event1").hide();
    $("#event2").show();
    document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
    document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;
    if(selectsankalpapuja !=""){
     sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
     sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
     window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");

    }

}
// add new condition start
else if(selectsankalpapuja =="" && categone !=""  && categtwo !="" && categtwo !=undefined ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#submitbuttontr").hide();
    $("#sankalpaselected").hide();
    $("#event1").show();
    $("#event2").show();
    document.getElementById('sponsoreventame').innerHTML = categone;
    document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

}

else if(selectsankalpapuja =="" && categone !=""  && categtwo !="" && categtwo == undefined  ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#submitbuttontr").hide();
    $("#sankalpaselected").hide();
    $("#event1").show();
    //$("#event2").show();
    document.getElementById('sponsoreventame').innerHTML = categone;
    //document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

}
// add new condition end

else if(selectsankalpapuja !="" && categone !="" && categtwo =="" ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#submitbuttontr").hide();
    $("#sankalpaselected").show();
    $("#event1").show();
    $("#event2").hide();
    document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
    document.getElementById('sponsoreventame').innerHTML = categone;
    if(selectsankalpapuja !=""){
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");

    }

}
else if(selectsankalpapuja !="" && categone !="" && categtwo ==undefined ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#submitbuttontr").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#sankalpaselected").hide();
    $("#event1").show();
    $("#event2").hide();
    document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
    document.getElementById('sponsoreventame').innerHTML = categone;
    if(selectsankalpapuja !=""){
     sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
     sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
     window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");

    }
}

else if(selectsankalpapuja !="" && categone =="" && categtwo == undefined ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#submitbuttontr").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#sankalpaselected").show();
    document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
    if(selectsankalpapuja !=""){
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
    window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");

    }
}

else if(selectsankalpapuja =="" && categone !="" && categtwo == "" ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#submitbuttontr").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#sankalpaselected").hide();
    $("#event1").show();
    document.getElementById('sponsoreventame').innerHTML = categone;
}
// 20july update condition 
else if(selectsankalpapuja =="" && categone =="" && categtwo != "" && categtwo != undefined ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#submitbuttontr").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#sankalpaselected").hide();
    $("#event2").show();
    document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;
}
else if(selectsankalpapuja =="" && categone !="" && categtwo != "" ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#submitbuttontr").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#sankalpaselected").hide();
    $("#event1").show();
    $("#event2").show();
    document.getElementById('sponsoreventame').innerHTML = categone;
    document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;

 }
else if(selectsankalpapuja !="" && categone !="" && categtwo != "" ){
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#submitbuttontr").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#sankalpaselected").show();
    $("#event1").show();
    $("#event2").show();
    document.getElementById('selectpuja').innerHTML = selectsankalpapuja;
    document.getElementById('sponsoreventame').innerHTML = categone;
    document.getElementById('sponsoreventcategorydatatr').innerHTML = categtwo;
    if(selectsankalpapuja !=""){
     sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
     sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
     window.location.replace("<?php echo INSTALL_URL; ?>PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");

    }
    

}
else{
    $("#eligiblemsg").hide();
    $("#sankalpapujamsgprice").hide();
    $("#optiondropdown").hide();
    $("#optiondropdown2").hide();
    $("#submitbuttontr").hide();
    $("#sankalpaselected").hide();
    $("#event1").hide();
    $("#event2").hide();

}
}


function mysponsorcategory2(){
//
    var sponsorcat1 = $("#sponsoreventcategory2").val();
    var sponsorcat2 = $("#sponsor").val();
   if(sponsorcat1 != ""){
    //$('#eventone').attr('disabled', true);
    $('.selectpicker').attr("disabled","disabled");
    $("#sponsor").attr("disabled","disabled");
    $('.selectpicker').selectpicker('deselectAll');
    }else{
        $('.selectpicker').attr('disabled', false);
     $('#sponsor').attr('disabled', false);
    $('.selectpicker').selectpicker('deselectAll');
    
    }

}
</script>
