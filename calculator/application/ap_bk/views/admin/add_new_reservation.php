   

        
        <div class="breadLine">
            
            <ul class="breadcrumb">
                                
                 <li><a href="<?=base_url()?>index.php/admin">Dashboard</a></li>  
                <li class="active">Add New Reservation</li>

            </ul>
                        
                               
                    
               
            
        </div>
        <div class="clearfix">
         <?php if($this->session->flashdata('message'))
                { 
                  
                  ?>
                  <div class='alert alert-success fade-in'>
                    <button data-dismiss='alert' class='close' type='button'>×</button>
                         <strong id = 'success'><?=$this->session->flashdata('message');?></strong>
                         </div>                  
           <?php } ?>
        </div>
        
        <div class="panel">
                                    
           
            
            <div class="panel-heading">
           Add New Reservation
            </div>
            <div class="panel-body">   
                
                    
                       
                      <form  action="<?php echo base_url(); ?>index.php/admin/add_new_reservation" method="post" onsubmit="return check_form2()">
                                <fieldset>
                                    <!-- Address form -->
                                   <div class="clearfix form-group">
                                        <label class="col-lg-3">Reservation Type: <span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                           <div class="controls col-lg-7">
                                  <select name="trip_type" id="input" class="form-control" onclick="show_return(this)" >
                                    <option value="">Select</option>
<option>One way trip to airport</option>
<option>One way trip from airport</option>
<option>One way trip to other location</option>
<option>Round trip to airport</option>
<option>Round trip from airport</option>
<option>Round trip to other location</option>
<option>Wedding</option>
<option>Prom</option>
<option>Birthday party</option>
<option>Others</option>

                                  </select>
 <input  id="other_subject_published" type="text" class="form-control" style="display:none;">
                                    </div>
                                   </div>
                                    <div class="clearfix form-group">
                                            <label class="col-lg-3">Number of Passengers<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <select name="no_passengers" id="inputNo_passengers" class="form-control" >
                                                  <option value=""></option>
                                                  <?php foreach (range(1,20) as $key): ?>
                                                      <option><?=$key?></option>
                                                  <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix form-group">
                                            <label class="col-lg-3">Number of  bags<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <select name="no_bags" id="inputNo_passengers" class="form-control" >
                                                  <option value=""></option>
                                                  <?php foreach (range(1,20) as $key): ?>
                                                      <option><?=$key?></option>
                                                  <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>

                                         <div class="clearfix form-group">
                                            <label class="col-lg-3">Vehicle Type<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                               <select class="form-control"  name="vehicle_type" id="vehical" onchange="check_other_subject('vehicle',this,'vehicle_type')">
                                               <option value="">Select</option>
                                               <option value="Lincoln Town Car Sedan">Lincoln Town Car Sedan</option>
                                               <option value="6 Passengers Luxury SUV">6 Passengers Luxury SUV</option>
                                               <option value="6 Passengers Strech Limo">6 Passengers Strech Limo</option>
                                               <option value="10 Passengers Stretch Limo">10 Passengers Stretch Limo</option>
                                               <option value="14 Passenger Stretch SUV Limo">14 Passenger Stretch SUV Limo</option>
                                               <option>Others</option>
                                               </select>
                                               <input  id="other_subject_vehicle" type="text" class="form-control" style="display:none;">
                                                </div>
                                        </div>
                                       

                                    <legend>Pickup Details</legend>
                                    <!-- full-name input-->
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Travel Date<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="date" class="form-control datepicker"  name="travel_date" id="datepicker" >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                     <div class="clearfix form-group">
                                        <label class="col-lg-3">Pickup Time<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-3">
                                          <select class="form-control col-lg-4" id="pickup_time_hours" class="ftds" name="pickup_time_hours"><option>Hours</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
                                          </select>
                                        </div>
                                         <div class="controls col-lg-2">
                                          <select class="form-control col-lg-4" id="pickup_time_min" class="ftds" name="pickup_time_min"><option value="">Minutes</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="00">00</option></select>
                                        </div>
                                          <div class="controls col-lg-2">
                                          <select class="form-control col-lg-4" id="pickup_time_am_pm" class="ftds" name="pickup_time_am_pm"><option value="am">AM</option><option value="pm">PM</option>
                                          </select>
                                        </div>
    
                                    </div>
                                    <div class="clearfix">
                                      <div class="clearfix form-group">
                                        <label class="col-lg-3">Phone number at the time of pickup<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control" name="phone_pickup"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="clearfix">
                                    
                                    </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Pick From<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <select name="pickup_from" id="inputPickup" onchange="show_location(this.value,'pick')" class="form-control" >
                                                <option value="">Select</option>
                                                <option value="airport">Airport</option>
                                                <option value="address">Location</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                     <div id="airport_loc_pick" style="display:none;">

                                      <div class="clearfix form-group">
                                      <label class="col-lg-3"></label>
                                       <div class="controls col-lg-7">
                                            <select name="airport" id="inputPickup" class="form-control" >
                                                <option value="">Select</option><option value="Toronto Pearson Airport (YYZ)">Toronto Pearson Airport (YYZ)</option><option value="Buffalo International Airport (BUF)">Buffalo International Airport (BUF)</option><option value="Hamilton Airport (YHM)">Hamilton Airport (YHM)</option><option value="Billy Bishop Airport-Toronto City Airport (YTZ)">Billy Bishop Airport-Toronto City Airport (YTZ)</option><option value="Detroit Airport (DTW)">Detroit Airport (DTW)</option><option value="Other">Other</option>
                                            </select>
                                        </div>
                                        </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Airline<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="airline" class="form-control"  name="airline_pick"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Flight Number<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="flight_no" class="form-control"  name="flight_number_pick"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>

                                            
                                    </div>

                                     <div id="address_loc_pick" style="display:none;">

                                      <div class="clearfix form-group">
                                      <label class="col-lg-3">Address</label>
                                       <div class="controls col-lg-7">
                                           <textarea name="pickup_address" id="input" class="form-control" rows="3" ></textarea>
                                        </div>
                                        </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">City<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input name="pickup_city" class="form-control"   >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Postal/Zip Code<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control"  name="postal_code"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>

                                            
                                    </div>

                                   <legend>DropOff Details</legend>
                                         <div class="clearfix form-group">
                                        <label class="col-lg-3">Drop off to<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <select name="dropoff_location" id="inputPickup" onchange="show_location(this.value,'dropoff')" class="form-control" >
                                                <option value="">Select</option>
                                                <option value="airport">Airport</option>
                                                <option value="address">Location</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                     <div id="airport_loc_dropoff" style="display:none;">

                                      <div class="clearfix form-group">
                                      <label class="col-lg-3"></label>
                                       <div class="controls col-lg-7">
                                            <select name="drop_airport" id="inputPickup" class="form-control" >
                                                <option value="">Select</option><option value="Toronto Pearson Airport (YYZ)">Toronto Pearson Airport (YYZ)</option><option value="Buffalo International Airport (BUF)">Buffalo International Airport (BUF)</option><option value="Hamilton Airport (YHM)">Hamilton Airport (YHM)</option><option value="Billy Bishop Airport-Toronto City Airport (YTZ)">Billy Bishop Airport-Toronto City Airport (YTZ)</option><option value="Detroit Airport (DTW)">Detroit Airport (DTW)</option><option value="Other">Other</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>

                                     <div id="address_loc_dropoff" style="display:none;">

                                      <div class="clearfix form-group">
                                      <label class="col-lg-3">Address</label>
                                       <div class="controls col-lg-7">
                                           <textarea name="address_drop" id="input" class="form-control" rows="3" ></textarea>
                                        </div>
                                        </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">City<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control"  name="city_drop" >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Postal/Zip Code<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control"  name="postal_drop" id="postal_drop" >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                  
                                            
                                    </div>
                                    
                                        <legend>Customer Details</legend>
                                         <div class="clearfix form-group">
                                           <label class="col-lg-3">Name<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                             <input type="text" class="form-control"  name="cust_name" >
                                            
                                            </div>
                                         </div>
                                         <div class="clearfix form-group">
                                           <label class="col-lg-3">Email<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                             <input type="text" class="form-control"  name="email" >
                                            
                                            </div>
                                         </div>

                                        
                                    <legend>Card Details</legend>
                                     <div class="clearfix form-group">
                                            <label class="col-lg-3">Payment type<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <select name="payment_type" id="inputPickup" class="form-control" >
                                                <option value="">Select</option>
                                                <option>CC on hold</option>
                                                <option>CC to be charged</option>
                                                <option>Cash</option>
                                                <option>Invoice</option>
                                                <option>Corporate</option>
                                            </select>
                                            </div>
                                        </div>


                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Credit card number<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control"  name="credit_card_no" id="full-name" >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                     <div class="clearfix form-group">
                                            <label class="col-lg-3">Expiry Date<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <input type="text" class="form-control"  name="exp_date" id="full-name" >
                                            </div>
                                        </div>
                                         <div class="clearfix form-group">
                                            <label class="col-lg-3">CVV number<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <input type="text" class="form-control"  name="cvv" id="full-name" >
                                            </div>
                                        </div>

                                        <div class="clearfix form-group">
                                            <label class="col-lg-3">Name on Card<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <input type="text" class="form-control"  name="name_card" id="full-name" >
                                            </div>
                                        </div>
 <div class="clearfix form-group">
                                            <label class="col-lg-3">Billing Postal Code<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <input type="text" class="form-control"  name="billing_postal_code" id="full-name" >
                                            </div>
                                        </div>
                                        


                                        
                                      
                                         <div class="clearfix">
                                    
                                    </div>
                                    <div id="return_details" style="display:none;">
                                          <legend>Return Details</legend>
                                        <div class="clearfix form-group">
                                        <label class="col-lg-3">Travel Date<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="date" class="form-control datepicker"  name="return_date"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                     <div class="clearfix form-group">
                                        <label class="col-lg-3">Pickup Time<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-3">
                                          <select class="form-control col-lg-4" id="return_time_hours" class="ftds" name="return_time_hours"><option>Hours</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>
                                        </div>
                                         <div class="controls col-lg-2">
                                          <select class="form-control col-lg-4" id="return_time_min" class="ftds" name="return_time_min"><option value="">Minutes</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="00">00</option></select>
                                        </div>
                                         <div class="controls col-lg-2">
                                          <select class="form-control col-lg-4" id="return_time_am_pm" class="ftds" name="return_time_am_pm"><option value="am">AM</option><option value="pm">PM</option>
                                          </select>
                                        </div>
    
                                    </div>
                                    <div class="clearfix">
                                      <div class="clearfix form-group">
                                        <label class="col-lg-3">Phone number at the time of pickup<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control" name="return_phone"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Pick From<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                           <select name="return_pickup_from" id="inputPickup" onchange="show_location(this.value,'drop')" class="form-control" >
                                                <option value="">Select</option>
                                                <option value="airport">Airport</option>
                                                <option value="address">Location</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                     <div id="airport_loc_drop" style="display:none;">

                                      <div class="clearfix form-group">
                                      <label class="col-lg-3"></label>
                                       <div class="controls col-lg-7">
                                            <select name="airport_return" id="inputPickup" class="form-control" >
                                                <option value="">Select</option><option value="Toronto Pearson Airport (YYZ)">Toronto Pearson Airport (YYZ)</option><option value="Buffalo International Airport (BUF)">Buffalo International Airport (BUF)</option><option value="Hamilton Airport (YHM)">Hamilton Airport (YHM)</option><option value="Billy Bishop Airport-Toronto City Airport (YTZ)">Billy Bishop Airport-Toronto City Airport (YTZ)</option><option value="Detroit Airport (DTW)">Detroit Airport (DTW)</option><option value="Other">Other</option>
                                            </select>
                                        </div>
                                        </div>
                                  
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Flight Detail Return<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control" name="flight_detail_return"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>

                                            
                                    </div>

                                     <div id="address_loc_drop" style="display:none;">

                                      <div class="clearfix form-group">
                                      <label class="col-lg-3">Address</label>
                                       <div class="controls col-lg-7">
                                           <textarea name="return_pick_address" id="input" class="form-control" rows="3" ></textarea>
                                        </div>
                                        </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">City<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control"  name="return_city"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="clearfix form-group">
                                        <label class="col-lg-3">Postal/Zip Code<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                        <div class="controls col-lg-7">
                                            <input type="text" class="form-control" name="retun_postal_code"  >
                                            <p class="help-block"></p>
                                        </div>
                                    </div>

                                            
                                    </div>

                                    
                                    

                                    </div>
                             <div class="clearfix form-group">
                                            <label class="col-lg-3">Driver's Name<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <select name="driver_name" id="inputPickup" class="form-control" >
                                                <option value="">Select</option>
                                                <option value="Sumeet">Sumeet</option>
                                                <option value="Paul">Paul</option>
                                                <option value="David">David</option>
                                                <option value="Blair">Blair</option>
                                            </select>
                                            </div>
                                        </div>
                                <div class="clearfix form-group">
                                            <label class="col-lg-3">Additional Information<span style="color:red;font-weight:bold;font-size:18px;">*</span></label>
                                            <div class="controls col-lg-7">
                                                <textarea name="additional_note" id="inputAdditional_note" class="form-control" rows="3" required="required"></textarea>
                                            </div>
                                        </div>

                                        
                                    
                                   
                                    <div class="col-lg-12">All fields marked by * should be filled out.</div>
                                        <div class="clearfix form-group">
                                          
                                             <button class="btn btn-success btn-lg" type="submit" id="sregister" >Add</button>
                                        </div>
                                        
                                    </fieldset>
                                </form>


                    </div>
                                              
                
            </div>   
            </div> 
        </div> 


        <script type="text/javascript">
       function show_return (stat) 
       {

        var sel = $(stat).val();
        var ff = sel.split(" ");
          if(ff[0]=='Round')
          {
            $("#return_details").show();
          }
          else
          {
            $("#return_details").hide();
          }
          check_other_subject('published',stat,'trip_type');
       }

       function check_other_subject (type,spc,name) 
{
  var value = $(spc).val();
  if(value=='Others')
  {
    $("#other_subject_"+type).show();
    $("#other_subject_"+type).attr('required','required');
    $("#other_subject_"+type).attr('name',name);
    $("#other_subject_"+type).attr('placeholder','Enter the value.');
    $(spc).removeAttr('name');
  }
  else
  {
    $("#other_subject_"+type).hide();
    $("#other_subject_"+type).removeAttr('required');
    $("#other_subject_"+type).removeAttr('name');
    $(spc).attr('name',name);
  }
}

       function show_location (val,add) 
       {
           if(val=="airport")
           {
              $("#"+val+"_loc_"+add).show();
              $("#address"+"_loc_"+add).hide();
           }
           if(val=="address")
           {
              $("#"+val+"_loc_"+add).show();
              $("#airport"+"_loc_"+add).hide();
           }

       }

function other_box (value) 
{
    if(value == "other")
    {
        $("#other_type").show(100);
        $("#other_type").attr("","");
    }
    else
    {
        $("#other_type").val("");
         $("#other_type").removeAttr("");
         $("#other_type").hide(100);
    }
}
                        </script>
        </script>
