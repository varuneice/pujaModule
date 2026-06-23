
<style>
    .body{
        padding:0px;
        margin:0px;
    }
.logo .profile {
    margin-left: 50%;
    border-radius: 25%;
    transform: translate(-50%);
    filter: brightness(123%);
    padding: 10px;
   
} 
.logo .logo-caption {
    font-family: 'Poiret One', cursive;
    color: #bd8585;
    text-align: center;
   
}
.logo-caption .h1 {
    font-size:2.5rem;;
}
h3{
    
    font-size:30px;
    color: #bd8585;
    margin-left:24%;
    font-family: initial;
}
.logo .tweak {
  color: #ff5252;
  font-weight: bold;
}
.abd{
    font-weight: bold;
    font-family: 'Poiret One', cursive;
    font-size:20px;
    color:00000;
}
.btn-custom {
  background: #ff5252;
  border-color: rgba(48, 46, 45, 1);
  color: #ffffff;
  font-weight: bold;
  font-size:20px;
  width: -webkit-fill-available;
}
.btn-custom:hover{
	-webkit-transition: all 500ms ease;
	-moz-transition: all 500ms ease;
	-ms-transition: all 500ms ease;
	-o-transition: all 500ms ease;
	transition: all 500ms ease;
	background: rgba(48, 46, 45, 1);
	border-color: #ff5252;
}
.footer {
  padding-top: 10px;
  margin-left: 15%;
  width: 85%;
  background: #111111;
  position: relative;
  bottom: 0;
  z-index: 1;
}
.form-group label {
    display: inline-block;
    font-weight: bold;
    margin-bottom: 5px;
}

.form-control {
    background-color: #f9fcfa;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgb(0 0 0 / 8%) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
.form-horizontal .form-group {
    margin: 10px;
}
.asb {
    border-width: 0;
    border: 0 none;
    margin: 0;
    padding: 0;
}
.text-center{
text-align:center;
}
.btn.btn-primary {
    background-color: #00a5c5;
    border-color: #367fa9;
    color: #fff;
    font-size: 20px;
}
  </style>

<div id="menu-container" style="width: 40%; margin:3px auto;  background-color:rgba(211,211,211) !important;">
    <!--div class="grid">
        <header class="header bordered" role="banner">
           <img src="picture/full_logo.PNG" > <h1><b>Houston Durgabari Society</b></h1>
        </header>
        <div class="breadcrumb">
            <div class="sub-breadcrumb">
                <span class="time">It is currently <?php echo date('l jS \of F Y h:i:s'); ?></span>
            </div>
        </div-->
        <div id="page-body">
            <main role="main">
                
                <!--h1 class="bordered title"><span class="green">L</span>OG IN</h1-->
                <div class="logo">
                    <img src="./logo.jpg" class="profile"/>
                    <h3><b>Houston Durgabari Society</b></h3>
        			<h1 class="logo-caption"><span class="tweak">D</span>onation</h1>
        		</div> 
                <!-- logo class -->
                <form id="login" class="form-horizontal" method="post" action="" role="form">
                    <input type="hidden" name="login_user" value="1" />
                    <fieldset class="asb">
                        
                    <div class="form-group">
                    <label class="abd" for="type">Donation Type</label>
                    <select name="Donation_Type" id="type"  class="form-control input-sm medium valid" aria-required="true" aria-invalid="false"  >
                        <option value="" class ="amd">---</option>
                        <option value="1">Donation</option>
                         <option value="2">Other Payment</option>
                         </select>
                </div>

                <div class="form-group" id="hide1">
                   <input type="radio" id="gift" name="gift" value="gift">
                    <label for="gift">Gift Shop</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="rental" name="rental" value="rental">
                    <label for="rental">Rental</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="misc" name="misc" value="misc">
                    <label for="misc">Misc</label><br>

                      <label for="payment" class="abd">Payment For:</label>
                        <input id="Payment" class="form-control input-sm" type="text" placeholder="" value="" name="Payment_For">
                    </div>

                    <div class="form-group">
                        <label for="MemberName" class="abd">Member Name</label>
                        <input id="MemberName" class="form-control input-sm" type="text" placeholder="MemberName" value="" name="MemberName" tabindex="1"-->
                    </div>

                    <div class="form-group">
                        <label for="Amount" class="abd">$Amount</label>
                        <input id="Amount" class="form-control input-sm" type="number" placeholder="$Amount" value="" name="Amount" tabindex="1"-->
                    </div>

                    <div class="form-group">
                        <label for="Pay" class="abd">Payment Option</label>
                        <select name="PaymentOption" id="type" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false">
                         <option value="" class ="amd">---</option>
                         <option value="1">Zelle</option>
                         <option value="2">Stripe</option>
                         </select>
                    </div>


                        <div class="form-group">
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="Save" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button>
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="Save" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Payment</button>
                        </div>
                    </fieldset>
                    <div class="card-footer">
                      <!-- <div class="text-center">
                       <a class="text-light" onclick="displayForgotPasswordForm();" style="cursor: pointer; color:#ffffff; font-size: 20px;">Login here</a>
                       </div> -->
                     </div> 
                </form>
            </main>
        </div>
    <!-- </div> -->
</div>
<script>
function hideDiv(elem) {
  
    if(elem.value == "Donation"){
	 document.getElementById('hide1').style.display = 'none';
	//document.getElementById('hide2').style.display = "block";
	
	}
    else
	{
        document.getElementById('hide1').style.display = 'block';
		//document.getElementById('hide2').style.display = "";
      
}
}

</script>
