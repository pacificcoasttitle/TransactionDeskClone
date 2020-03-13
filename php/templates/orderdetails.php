<?php
$order_message_body = '<html>
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
                                                                        <td style="margin-top:;font-size: 22px; font-family:Montserrat; Font-weight: 800; color: #04415D;text-transform: uppercase; text-align:center;">
                                                                
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
                                                        
                                                        <p><span style="font-weight:bold;font-size:16px">File #:</span> '.$orderNumber.'</p>
                                                        <p><span style="font-weight:bold;font-size:16px">Opened By:</span> '.$OpenName.'</p>
                                                        <p><span style="font-weight:bold;font-size:16px">Open Mail:</span> '.$OpenEmail.'</p>
                                                        <p><span style="font-weight:bold;font-size:16px">Open Telephone:</span> '.$Opentelephone.'</p>
                                                        <p><span style="font-weight:bold;font-size:16px">Product:</span> '.$ProductType.'</p>
                                                        <p><span style="font-weight:bold;font-size:16px">Sales Price:</span> '.$SalesAmount.'</p>
                                                        <p><span style="font-weight:bold;font-size:16px">Loan Amount:</span> '.$LoanAmount.'</p><br>
                                                      </div>
                                                            
                                                        </td>
                                                    </tr>
                                                    
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
                                            <span> &copy; Pacific Coast Title 2019 - '.$currYear.' - ALL RIGHTS RESERVED </span>
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
</html>';
?>