<head>

<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<style>
#eventone > div > div.multiselect-dropdown{display:none;}
body > section > div > span:nth-child(1){display:none;}
body > section > div > span:nth-child(2){display:none;}
    </style>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100" style= "text-align: -webkit-center;">
        <?php
        if (!empty($_SESSION['myValue'])) {
            $alldonationdata =  $_SESSION['myValue'];
            $orderid = $_SESSION['myValue']['oid'];
            $datefor = $_SESSION['myValue']['pay_date'];
            $timestamp = strtotime($datefor);
            $payfinaldate = date("m/d/Y", $timestamp);
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
                                <td colspan='2'> <img src='https://durgabari.org/HDBS_Puja_Payments/thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
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
                                <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
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
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799 && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
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
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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
                            <a href="https://durgabari.org/HDBS_Puja_Payments/PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                        <?php } ?>
                        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                            <a href="https://durgabari.org/HDBS_Puja_Payments/Pujaregistration/index">Go to home</a> 
                        
                        <?php } ?>
                    <?php
            }
            // for check 
            else if ($_SESSION['myValue']['PaymentOption'] == 'check') {
                ?>
                            <table border="4" width='585px'>
                                        <tr>
                                       <td colspan='2'> <img src='https://durgabari.org/HDBS_Puja_Payments/thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
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
                                       <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
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
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799 && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
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
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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
                               <a href="https://durgabari.org/HDBS_Puja_Payments/PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                           <?php } ?>
                           <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                               <a href="https://durgabari.org/HDBS_Puja_Payments/Pujaregistration/index">Go to home</a> 
                        
                           <?php } ?>
                           <?php
            }

            // for cash
            else if ($_SESSION['myValue']['PaymentOption'] == 'cash') {
                ?>
                                   <table border="4" width='585px'>
                                               <tr>
                                              <td colspan='2'> <img src='https://durgabari.org/HDBS_Puja_Payments/thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
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
                                              <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
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
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799 && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
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
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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
                                      <a href="https://durgabari.org/HDBS_Puja_Payments/PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                                  <?php } ?>
                                  <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                      <a href="https://durgabari.org/HDBS_Puja_Payments/Pujaregistration/index">Go to home</a>  
                                    <!-- <a href="http://localhost/7june/Pujaregistration/index">Go to home</a>-->
                      
                                 <?php } ?>
                                  <?php
            }


            // for directdeposite 
            else if ($_SESSION['myValue']['PaymentOption'] == 'directdeposit') {
                ?>
                                         <table border="4" width='585px'>
                                                     <tr>
                                                    <td colspan='2'> <img src='https://durgabari.org/HDBS_Puja_Payments/thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
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
                                                    <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
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
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799 && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
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
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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
                                            <a href="https://durgabari.org/HDBS_Puja_Payments/PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                                        <?php } ?>
                                        <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                            <a href="https://durgabari.org/HDBS_Puja_Payments/Pujaregistration/index">Go to home</a> 
                        
                                        <?php } ?>
                                        <?php
            }

            // for check 
            else if ($_SESSION['myValue']['PaymentOption'] == 'sumup') {
                ?>
                                             <table border="4" width='585px'>
                                                         <tr>
                                                        <td colspan='2'> <img src='https://durgabari.org/HDBS_Puja_Payments/thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
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
                                                        <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
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
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799 && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
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
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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
                                                <a href="https://durgabari.org/HDBS_Puja_Payments/PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                                            <?php } ?>
                                            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                                <a href="https://durgabari.org/HDBS_Puja_Payments/Pujaregistration/index">Go to home</a> 
                        
                                            <?php } ?>
                                            <?php
            } else if ($_SESSION['myValue']['PaymentOption'] == 'others') {
                ?>
                                                 <table border="4" width='585px' style= "text-align: -webkit-center;" >
                                                             <tr>
                                                            <td colspan='2'> <img src='https://durgabari.org/HDBS_Puja_Payments/thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
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
                                                            <?php if ($_SESSION['myValue']['donation'] != 0) { ?>
                                    <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799) {
                                        echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                    }
                                    ?>
                                                <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                                      echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Please select</option> 
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
<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister == 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 400 && $_SESSION['ytdvalue'] <= 799 && $membertype != 'PM' && $membertype != 'FP') {
                                                     echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Green Field parking option at a discounted rate</td></tr>";
                                                 }
                                                 ?>
                                                <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && $membertype != 'PM' && $membertype != 'FP') {
                                                    echo "<tr><td>Parking Area</td> <td style='color:red;' ><span style='color:black;'>You will be assigned</span> Gold Sponsor Parking</td></tr>";
                                                }
                                                ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 1200 && $_SESSION['ytdvalue'] <= 1999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;' ><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 1999 && $_SESSION['ytdvalue'] <= 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main or Kala Bhavan(KB) Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] > 4999) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Main Parking.</td></tr>";
                                                  }
                                                  ?>
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 800 && $_SESSION['ytdvalue'] < 1199 && ($membertype == "PM" || $membertype == "FP")) {
                                                      echo "<tr><td>Parking Area</td><td style='color:red;'><span style='color:black;'>You will be assigned</span> Kala Bhavan Parking.</td></tr>";
                                                  }
                                                  ?>
                                        <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 2000 && $_SESSION['ytdvalue'] < 4599 && $pujaregistered != 'true') {
                                            echo "<tr class='tr' id='sankalpapujamsgprice'>
                       <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                        <td class='td'>
                            <select  name='' id='pujasankalp' 
                                class='form-control input-sm' aria-required='true' aria-invalid='false' >
                                 <option value=''>Nothing Selected</option> 
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
<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                   <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt != 'true' ) {
                                                echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                              <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered == 'true') && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                  echo "
                                                  <tr id='eligiblemsg' style='color:red; text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa </td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && ($pujaregistered != 'true' || $pujaregistered != 'true') && $sponsoreventfirst == 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt != 'true') {
                                                echo "
                                                <tr id='eligiblemsg' style='color:red;text-transform: uppercase; font-weight: bold;'><td colspan='2'> Any previous Puja Sankalpa selection will be overridden</td></tr>

                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' span style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false' required>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt != 'true' && $pujaregisteredsecondattempt == 'true') {
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

<?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 4600 && $_SESSION['ytdvalue'] < 9599 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $pujaregisteredfirstattempt == 'true' && $pujaregisteredsecondattempt == 'true') {
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

                                                 <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
                                                     echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
            <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'ture' && $sponsoreventfirst != 'true' && $sponsoreventsecond != 'true') {
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
          <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
                  echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
                                         echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered != 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond == 'true') {
                       echo "
                                <tr class='tr' id='sankalpapujamsgprice'>
                                <td class='td' style='text-transform: uppercase; font-weight: bold;color:red;'>You are eligible for one free puja sankalpa</td>
                               <td class='td'><select  name='' id='pujasankalp' 
                               class='form-control input-sm' aria-required='true' aria-invalid='false'>
                                <option value=''>Nothing Selected</option> 
                                <option value='Maha Sashti'>Maha Sashti</option>
                                <option value='Maha Saptami'>Maha Saptami</option>
                                <option value='Maha Astami'>Maha Astami</option>
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
                                                  <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst != 'true' && $sponsoreventsecond == 'true') {
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
     <?php if ($dataregister != 'true' && $_SESSION['ytdvalue'] >= 9600 && $pujaregistered == 'true' && $sponsoreventfirst == 'true' && $sponsoreventsecond != 'true') {
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
                                                    <a href="https://durgabari.org/HDBS_Puja_Payments/PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
                                                <?php } ?>
                                                <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                                                    <a href="https://durgabari.org/HDBS_Puja_Payments/Pujaregistration/index">Go to home</a> 
                        
                                                <?php } ?>
                                                <?php

            }
            else if ($_SESSION['myValue']['PaymentOption'] == 'ComplimentaryRegistration') {
                ?>
            <table border="4" width='585px' style= "text-align: -webkit-center;" >
                <tr>
                <td colspan='2'> <img src='https://durgabari.org/HDBS_Puja_Payments/thankyouscreen.jpg' alt='' height='167px' style="margin-left:13em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                </tr>
                <tr>
                <tr><td>order Id</td> <td><?php echo $_SESSION['myValue']['oid']; ?></td></td></tr>
                <tr><td>Member Id</td> <td><?php echo $_SESSION['myValue']['Member_id']; ?></td></td></tr>
                <tr><td>Full Name</td> <td><?php echo $_SESSION['myValue']['First_name'] . ' ' . $_SESSION['myValue']['Last_name']; ?></td></tr>
                <tr><td>Puja Type</td> <td><?php echo $_SESSION['myValue']['puja_type'];?></td></tr>
                <tr><td>Payment Method</td> <td><?php echo "Complimentary Registration"; ?></td></tr>
                <tr><td>Pay Date</td> <td><?php echo $registrationDate; ?></td></tr>
                <tr><td>Payment Status</td> <td>Confirmed</td></tr>
            </table>  
            <?php if (!$this->controller->isAdmin() && !$this->controller->isEditor()) { ?>
                <a href="https://durgabari.org/HDBS_Puja_Payments/PujaOnlinePayments/PujaOnlinePayments">Go to home</a> 
            <?php } ?>
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                 <a href="https://durgabari.org/HDBS_Puja_Payments/Pujaregistration/index">Go to home</a> 
               
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

function myFunction() {
       debugger;
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
        if (mynewytd >= 4600 && mynewytd < 9599){
            if (selectpuja.length > 1) {
                selectpuja.splice(-1);
                $("#sponsor").val(selectpuja);
                    alert("Please Select only one");
                    $('.selectpicker').selectpicker('deselectAll');
                } else {
                    last_valid_selection = $(this).val();
                }
        }
        if (mynewytd >= 9600) {
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
    debugger;
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
    
    if(totalnewytd > 1999 && totalnewytd < 5000 && selectsankalpapuja !== "" && selectsankalpapuja != undefined){
        pujasankalpaattempt1 = '1';
        pujasankalpaattempt2 = '0';
    }
    else if(totalnewytd > 5000 && selectsankalpapuja !== "" && selectsankalpapuja != undefined){
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
      window.location.replace("https://durgabari.org/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
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
   window.location.replace("https://durgabari.org/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
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
     window.location.replace("https://durgabari.org/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
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
     window.location.replace("https://durgabari.org/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
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
    window.location.replace("https://durgabari.org/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
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
     window.location.replace("https://durgabari.org/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
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
    window.location.replace("https://durgabari.org/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
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
     window.location.replace("https://durgabari.org/HDBS_Puja_Payments/PujaSankalpa/PujaSankalpa");
    //window.location.replace("http://localhost/HDBS_Payment/Parking&Badges/PujaSankalpa/PujaSankalpa");
    sessionStorage.setItem("jsArray", JSON.stringify(donationArray));
    sessionStorage.setItem("pujaArray", JSON.stringify(pujanamecategory));
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
//debugger;
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