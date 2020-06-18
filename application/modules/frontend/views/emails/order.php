<?php
?>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>Smart forms - Email message template </title>
      <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700,800" rel="stylesheet">
   </head>
   <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
      <center>
         <table style="padding:30px 10px;background:#F4F4F4;width:100%;font-family:arial" cellpadding="0" cellspacing="0">
            <tbody>
               <tr>
                  <td>
                     <table style="max-width:540px;min-width:320px" align="center" cellspacing="0">
                        <tbody>
                           <tr>
                              <td style="background:#fff;border:1px solid #D8D8D8;padding:30px 30px" align="center">
                                 <table align="center">
                                    <tbody>
                                       <tr>
                                          <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                             <table style="margin:auto" align="center">
                                                <tbody>
                                                   <tr>
                                                      <td style="margin-top:;font-size: 22px; font-family:Montserrat; font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                         NEW ORDER DETAILS  
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                             <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                                <p><span style="font-weight:bold;font-size:16px">File #:</span> <?php echo $orderNumber; ?></p>
                                                <p><span style="font-weight:bold;font-size:16px">Opened By:</span> <?php echo $OpenName; ?></p>
                                                <p><span style="font-weight:bold;font-size:16px">Open Mail:</span> <?php echo $OpenEmail; ?></p>
                                                <?php 
                                                  if(isset($Opentelephone) && !empty($Opentelephone))
                                                  {
                                                  ?>
                                                      <p><span style="font-weight:bold;font-size:16px">Open Telephone:</span> <?php echo $Opentelephone; ?></p>
                                                  <?php
                                                  }
                                                  ?>
                                                <?php
                                                  if(isset($CompanyName) && !empty($CompanyName))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Company:</span> <?php echo $CompanyName; ?></p>
                                                <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(isset($StreetAddress) && !empty($StreetAddress))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Address:</span> <?php echo $StreetAddress; ?></p>
                                                <?php
                                                  } 
                                                ?>
                                                <?php
                                                  if(isset($City) && !empty($City))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">City:</span> <?php echo $City; ?></p>
                                                <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(isset($Zipcode) && !empty($Zipcode))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Zipcode:</span> <?php echo $Zipcode; ?></p>
                                                <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(isset($Notes) && !empty($Notes))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Notes:</span> <?php echo $Notes; ?></p>
                                                <?php
                                                  }
                                                ?>          
                                                <br>
                                             </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                             <table style="margin:auto" align="center">
                                                <tbody>
                                                   <tr>
                                                      <td style="margin-top:;font-size: 22px; font-family:Montserrat;font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                         PROPERTY DETAILS
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                             <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                                <p><span style="font-weight:bold;font-size:16px">Property Address:</span> <?php echo $PropertyAddress; ?></p>
                                                <p><span style="font-weight:bold;font-size:16px">Full Street Address:</span> <?php echo $FullProperty; ?></p>
                                                <p><span style="font-weight:bold;font-size:16px">APN:</span> <?php echo $APN; ?></p>
                                                <p><span style="font-weight:bold;font-size:16px">County:</span> <?php echo $County; ?></p>
                                                <p><span style="font-weight:bold;font-size:16px">Breif Legal Description:</span> <?php echo $LegalDescription; ?></p>
                                                <br>
                                             </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                             <table style="margin:auto" align="center">
                                                <tbody>
                                                   <tr>
                                                      <td style="margin-top:;font-size: 22px; font-family:Montserrat;font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                         SELLER DETAILS  
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                             <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                              <?php
                                                  if(isset($PrimaryOwner) && !empty($PrimaryOwner))
                                                  {
                                              ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Primary Owner:</span> <?php echo $PrimaryOwner; ?></p>
                                              <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(isset($SecondaryOwner) && !empty($SecondaryOwner))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Secondary Owner:</span> <?php echo $SecondaryOwner; ?></p>
                                                <?php
                                                  }
                                                ?>          
                                                <br>
                                             </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                             <table style="margin:auto" align="center">
                                                <tbody>
                                                   <tr>
                                                      <td style="margin-top:;font-size: 22px; font-family:Montserrat; font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                         TRANSACTION DETAILS
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                             <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                              <?php
                                                  if(isset($SalesRep) && !empty($SalesRep))
                                                  {
                                              ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Sales Rep:</span> <?php echo $SalesRep; ?></p>
                                              <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(isset($TitleOfficer) && !empty($TitleOfficer))
                                                  {
                                                ?>
                                                      <p><span style="font-weight:bold;font-size:16px">Title Officer:</span> <?php echo $TitleOfficer; ?></p>
                                                <?php
                                                  }
                                                ?>
                                                
                                                <p><span style="font-weight:bold;font-size:16px">Product:</span> <?php echo $ProductType; ?></p>
                                                <?php
                                                  if(isset($SalesAmount) && !empty($SalesAmount))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Sales Price:</span> <?php echo $SalesAmount; ?></p>
                                                <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(isset($LoanAmount) && !empty($LoanAmount))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Loan Amount:</span> <?php echo $LoanAmount; ?></p>
                                                <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(isset($LoanNumber) && !empty($LoanNumber))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Loan Number:</span> <?php echo $LoanNumber; ?></p>
                                                <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(isset($EscrowNumber) && !empty($EscrowNumber))
                                                  {
                                                ?>
                                                    <p><span style="font-weight:bold;font-size:16px">Escrow Number:</span> <?php echo $EscrowNumber; ?></p>
                                                >?php
                                                  }
                                                ?>
                                                
                                                <br>
                                             </div>
                                          </td>
                                       </tr>
                                       <?php
                                          if(isset($buyers_agent) && !empty($buyers_agent))
                                          {
                                       ?>
                                            <tr>
                                              <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                                 <table style="margin:auto" align="center">
                                                    <tbody>
                                                       <tr>
                                                          <td style="margin-top:;font-size: 22px; font-family:Montserrat; font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                             BUYERS AGENT DETAILS
                                                          </td>
                                                       </tr>
                                                    </tbody>
                                                 </table>
                                              </td>
                                           </tr>
                                           <tr>
                                              <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                                 <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                                    <p><span style="font-weight:bold;font-size:16px">Name:</span> <?php echo $buyers_agent['name']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Email Address:</span> <?php echo $buyers_agent['email']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Telephone:</span> <?php echo $buyers_agent['telephone']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Company:</span> <?php echo $buyers_agent['company']; ?></p>
                                                    <br>
                                                 </div>
                                              </td>
                                           </tr>  
                                       <?php
                                          }
                                       ?>
                                       <?php
                                          if(isset($listing_agent) && !empty($listing_agent))
                                          {
                                       ?>
                                            <tr>
                                              <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                                 <table style="margin:auto" align="center">
                                                    <tbody>
                                                       <tr>
                                                          <td style="margin-top:;font-size: 22px; font-family:Montserrat; font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                             LISTING AGENT DETAILS
                                                          </td>
                                                       </tr>
                                                    </tbody>
                                                 </table>
                                              </td>
                                           </tr>
                                           <tr>
                                              <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                                 <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                                    <p><span style="font-weight:bold;font-size:16px">Name:</span> <?php echo $listing_agent['name']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Email Address:</span> <?php echo $listing_agent['email']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Telephone:</span> <?php echo $listing_agent['telephone']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Company:</span> <?php echo $listing_agent['company']; ?></p>
                                                    <br>
                                                 </div>
                                              </td>
                                           </tr>  
                                       <?php
                                          }
                                       ?>
                                       <?php
                                          if(isset($lender_details) && !empty($lender_details))
                                          {
                                       ?>
                                            <tr>
                                              <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                                 <table style="margin:auto" align="center">
                                                    <tbody>
                                                       <tr>
                                                          <td style="margin-top:;font-size: 22px; font-family:Montserrat; Font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                             LENDER DETAILS
                                                          </td>
                                                       </tr>
                                                    </tbody>
                                                 </table>
                                              </td>
                                           </tr>
                                           <tr>
                                              <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                                 <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                                    <p><span style="font-weight:bold;font-size:16px">Name:</span> <?php echo $lender_details['name']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Email Address:</span> <?php echo $lender_details['email']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Telephone:</span> <?php echo $lender_details['telephone']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Company:</span> <?php echo $lender_details['company']; ?></p>
                                                    <br>
                                                 </div>
                                              </td>
                                           </tr>  
                                       <?php
                                          }
                                       ?>
                                       <?php
                                          if(isset($escrow_details) && !empty($escrow_details))
                                          {
                                       ?>
                                            <tr>
                                              <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                                 <table style="margin:auto" align="center">
                                                    <tbody>
                                                       <tr>
                                                          <td style="margin-top:;font-size: 22px; font-family:Montserrat; font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                             ESCROW DETAILS
                                                          </td>
                                                       </tr>
                                                    </tbody>
                                                 </table>
                                              </td>
                                           </tr>
                                           <tr>
                                              <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                                 <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                                    <p><span style="font-weight:bold;font-size:16px">Name:</span> <?php echo $escrow_details['name']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Email Address:</span> <?php echo $escrow_details['email']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Telephone:</span> <?php echo $escrow_details['telephone']; ?></p>
                                                    <p><span style="font-weight:bold;font-size:16px">Company:</span> <?php echo $escrow_details['company']; ?></p>
                                                    <br>
                                                 </div>
                                              </td>
                                           </tr>  
                                       <?php
                                          }
                                       ?>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>
                     <table style="max-width:650px" align="center">
                        <tbody>
                           <tr>
                              <td style="color:#b4b4b4;font-size:11px;padding-top:10px;line-height:15px;font-family:arial">
                                 <span> &copy; Pacific Coast Title 2019 - <?php echo $currYear; ?> - ALL RIGHTS RESERVED </span>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
      </center>
   </body>
</html>