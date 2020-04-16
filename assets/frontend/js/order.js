$(document).ready(function() {    
});


function createService4(fipCode,address,city)
{
	$.ajax({
        // url: 'php/createservice.php',
        url: base_url+'createService',
        data: {
            fipCode: fipCode,
            address: address,
            city: city,
            methodId: 4,
        },
        type: "POST",
        dataType: "xml"
    })
    	.done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
                
                    $('#legalDescription, #vestingInformation').prev('.loader').hide();
                    $('#legalDescription').html('No data found.');
                    $('#vestingInformation').html('No data found.');
                    $('#grantDeedInfoFile').prev('.loader').hide();
                    $('#grantDeedInfoFile').css('border','1px solid #000000');
                    $('#grantDeedInfoFile').css('padding','15px');
                    $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');
                
            } 
            else if (responseStatus == 'Success') 
            {
                $requestId = $(response).find('RequestID').text();
                getRequestSummaries($requestId,'4');
            }
        })
        .fail(function(err) {
            $('#legalDescription, #vestingInformation').prev('.loader').hide();
            $('#legalDescription').html('No data found.');
            $('#vestingInformation').html('No data found.');
            $('#grantDeedInfoFile').prev('.loader').hide();
            $('#grantDeedInfoFile').css('border','1px solid #000000');
            $('#grantDeedInfoFile').css('padding','15px');
            $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');         
        });
}

function createService3(apn,state,county)
{
	$.ajax({
        // url: 'php/createservice.php',
        url: base_url+'createService',
        data: {
            apn: apn,
            state: state,
            county: county,
            methodId: 3,
        },
        dataType: "xml",
        type: "POST"
    })
    	.done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
                $('#firstInstallment, #secondInstallment').prev('.loader').hide();
                $('#firstInstallment').css('border','1px solid #000000');
                $('#firstInstallment').css('padding','15px');
                $('#firstInstallment').html('<span class="orderinfo1">No data found.</span>');
                $('#secondInstallment').css('border','1px solid #000000');
                $('#secondInstallment').css('padding','15px');
                $('#secondInstallment').html('<span class="orderinfo1">No data found.</span>');
            } 
            else if (responseStatus == 'Success') 
            {
                $requestId = $(response).find('RequestID').text();
                getRequestSummaries($requestId,'3');
            }
        })
        .fail(function(err) {
            $('#firstInstallment, #secondInstallment').prev('.loader').hide();
            $('#firstInstallment').css('border','1px solid #000000');
            $('#firstInstallment').css('padding','15px');
            $('#firstInstallment').html('<span class="orderinfo1">No data found.</span>');
            $('#secondInstallment').css('border','1px solid #000000');
            $('#secondInstallment').css('padding','15px');
            $('#secondInstallment').html('<span class="orderinfo1">No data found.</span>');
        });
}

function getRequestSummaries(requestId,methodId)
{
    var apn = $("#apn").val();
	$.ajax({
        url: base_url+'getRequestSummaries',
        data: {
            requestId: requestId,
            methodId: methodId,
            apn: apn,
        },
        dataType: "xml",
        type: "POST"
    })
    	.done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
               $('#legalDescription, #vestingInformation').prev('.loader').hide();
                $('#legalDescription').html('No data found.');
                $('#vestingInformation').html('No data found.');
                
                $('#grantDeedInfoFile').prev('.loader').hide();
                $('#grantDeedInfoFile').css('border','1px solid #000000');
                $('#grantDeedInfoFile').css('padding','15px');
                $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');
            
                $('#firstInstallment, #secondInstallment').prev('.loader').hide();
                $('#firstInstallment').css('border','1px solid #000000');
                $('#firstInstallment').css('padding','15px');
                $('#firstInstallment').html('<span class="orderinfo1">No data found.</span>');
                $('#secondInstallment').css('border','1px solid #000000');
                $('#secondInstallment').css('padding','15px');
                $('#secondInstallment').html('<span class="orderinfo1">No data found.</span>');
                
            } 
            else if (responseStatus == 'Success') 
            {
                $resultId = $(response).find("ResultThumbNail:first").find("ID").text();
                /*if(L_V_CreateService == '' || L_V_GetRequestSummary == '' || L_V_GetResultById == '')
                {
                    serviceId = '';
                    if(methodId == 4)
                    {
                        serviceId = $(response).find("RequestSummaries:first").find("RequestSummary:first").find("Order:first").find("Services:first").find("Service:first").find("ID:first").text();
                        imageCreateRequest(serviceId,methodId);
                    }
                }*/
                
                getResultById($resultId,methodId);
            }
        })
        .fail(function(err) {
                $('#legalDescription, #vestingInformation').prev('.loader').hide();
                $('#legalDescription').html('No data found.');
                $('#vestingInformation').html('No data found.');
                
                $('#grantDeedInfoFile').prev('.loader').hide();
                $('#grantDeedInfoFile').css('border','1px solid #000000');
                $('#grantDeedInfoFile').css('padding','15px');
                $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');
            
                $('#firstInstallment, #secondInstallment').prev('.loader').hide();
                $('#firstInstallment').css('border','1px solid #000000');
                $('#firstInstallment').css('padding','15px');
                $('#firstInstallment').html('<span class="orderinfo1">No data found.</span>');
                $('#secondInstallment').css('border','1px solid #000000');
                $('#secondInstallment').css('padding','15px');
                $('#secondInstallment').html('<span class="orderinfo1">No data found.</span>');
        });
}

function getResultById(resultId,methodId)
{
    var apn = $("#apn").val();
	$.ajax({
        url: base_url+'getResultById',
        data: {
            resultId: resultId,
            apn: apn,
            methodId: methodId
        },
        dataType: "xml",
        type: "POST"
    })
    	.done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
                $('#legalDescription, #vestingInformation').prev('.loader').hide();
                $('#legalDescription').html('No data found.');
                $('#vestingInformation').html('No data found.');
                
           
                $('#firstInstallment, #secondInstallment').prev('.loader').hide();
                $('#firstInstallment').css('border','1px solid #000000');
                $('#firstInstallment').css('padding','15px');
                $('#firstInstallment').html('<span class="orderinfo1">No data found.</span>');
                $('#secondInstallment').css('border','1px solid #000000');
                $('#secondInstallment').css('padding','15px');
                $('#secondInstallment').html('<span class="orderinfo1">No data found.</span>');
                
            } 
            else if (responseStatus == 'Success') 
            {
            	/*if(L_V_CreateService == '' || L_V_GetRequestSummary == '' || L_V_GetResultById == '')
                {
                    if(methodId == 4)
                    {
                        var briefLegal = $(response).find("Result:first").find("BriefLegal").text();
                        var vesting = $(response).find("Result:first").find("Vesting").text();
                        var instrumentNumber = $(response).find("Result:first").find("LvDeeds").find("LegalAndVesting2DeedInfo:first").find("InstrumentNumber").text();
                        

                        $('#legalDescription, #vestingInformation').prev('.loader').hide();
                       
                        if(briefLegal)
                        {
                            $('#legalDescription').html(briefLegal);
                        }
                        else
                        {
                            $('#legalDescription').html('No data found.');
                        }

                        if(vesting)
                        {
                            $('#vestingInformation').html(vesting);
                        }
                        else
                        {
                            $('#vestingInformation').html('No data found.');
                        }

                        if(instrumentNumber)
                        {
                            var recordedDate = $(response).find("Result:first").find("LvDeeds").find("LegalAndVesting2DeedInfo:first").find("RecordedDate").text();         
                            var dateParts =recordedDate.split('/');
                            if(dateParts[2])
                            {
                                var docId = instrumentNumber.replace(dateParts[2], "");
                                var recDate = dateParts[2];
                                instrumentSearch(docId,recDate,state,county);
                            }
                            
                        }

                    }
                }
                if(Tax_CreateService == '' || Tax_GetRequestSummary == '' || Tax_GetResultById == '')
                {
                    if(methodId == 3)
                    {      
                        $('#firstInstallment, #secondInstallment').prev('.loader').hide();
                        if($(response).find("Result:first").find("TaxReport").find("Installments").children('item').length)
                        {
                            $(response).find("Result:first").find("TaxReport").find("Installments").children('item').each(function(i) {
                                var balance = $(this).find('Balance').text() ? $(this).find('Balance').text() : ' - ';
                                var amount  = $(this).find('Amount').text()? $(this).find('Amount').text() : ' - ';
                                var duedate = $(this).find('DueDate').text() ? $(this).find('DueDate').text() : ' - ';
                                var number  = $(this).find('Number').text() ? $(this).find('Number').text() : ' - ';
                                var paymentdate = $(this).find('PaymentDate').text() ? $(this).find('PaymentDate').text() : ' - ';
                                var penalty = $(this).find('Penalty').text() ? $(this).find('Penalty').text() : ' - ';
                                var status = $(this).find('Status').text() ? $(this).find('Status').text() : ' - ';
                                var amountpaid = $(this).find('AmountPaid').text() ? $(this).find('AmountPaid').text() : ' - ';
                                var taxyear = $(this).find('TaxYear').text() ? $(this).find('TaxYear').text() : ' - ';
                                if(i == 0)
                                {
                                    var firstIntdata = '<p>Balance: '+balance+'</p><p>Amount: '+amount+'</p><p>DueDate: '+duedate+'</p><p>Number: '+number+'</p><p>PaymentDate: '+paymentdate+'</p><p>Penalty: '+penalty+'</p><p>Status: '+status+'</p><p>AmountPaid: '+amountpaid+'</p><p>TaxYear: '+taxyear+'</p>';
                                    
                                    $('#firstInstallment').css('border','1px solid #000000');
                                    $('#firstInstallment').css('padding','15px');
                                    $('#firstInstallment').html(firstIntdata);
                                }
                                else if(i == 1)
                                {
                                    var secondIntdata = '<p>Balance: '+balance+'</p><p>Amount: '+amount+'</p><p>DueDate: '+duedate+'</p><p>Number: '+number+'</p><p>PaymentDate: '+paymentdate+'</p><p>Penalty: '+penalty+'</p><p>Status: '+status+'</p><p>AmountPaid: '+amountpaid+'</p><p>TaxYear: '+taxyear+'</p>';
                                    
                                    $('#secondInstallment').css('border','1px solid #000000');
                                    $('#secondInstallment').css('padding','15px');
                                    $('#secondInstallment').html(secondIntdata);
                                }
                            });
                        }             
                        else
                        {
                            $('#firstInstallment').css('border','1px solid #000000');
                            $('#firstInstallment').css('padding','15px');
                            $('#firstInstallment').html('<span class="orderinfo1">No data found.</span>');
                            $('#secondInstallment').css('border','1px solid #000000');
                            $('#secondInstallment').css('padding','15px');
                            $('#secondInstallment').html('<span class="orderinfo1">No data found.</span>');
                        }
                    }
                }*/
            }
        })
        .fail(function(err) {
            
                $('#legalDescription, #vestingInformation').prev('.loader').hide();
                $('#legalDescription').html('No data found.');
                $('#vestingInformation').html('No data found.');
                $('#firstInstallment, #secondInstallment').prev('.loader').hide();
                $('#firstInstallment').css('border','1px solid #000000');
                $('#firstInstallment').css('padding','15px');
                $('#firstInstallment').html('<span class="orderinfo1">No data found.</span>');
                $('#secondInstallment').css('border','1px solid #000000');
                $('#secondInstallment').css('padding','15px');
                $('#secondInstallment').html('<span class="orderinfo1">No data found.</span>');
        });
}

function imageCreateRequest(serviceId,methodId,fileNumber)
{
    if(methodId == 4)
    {
        $('#grantDeedInfoFile').next('.loader').show();
    }
    
    $.ajax({
        url: base_url+'imageCreateRequest',
        data: {
            serviceId: serviceId,
        },
        dataType: "xml",
        type: "POST"
    })
        .done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
                if(methodId == 4)
                {
                    
                    $('#grantDeedInfoFile').next('.loader').hide();
                    $('#grantDeedInfoFile').css('border','1px solid #000000');
                    $('#grantDeedInfoFile').css('padding','15px');
                    $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>'); 
                    
                }
                else if(methodId == 3)
                {
                    $('#instrumentInfoFile').next('.loader').hide();
                    $('#instrumentInfoFile').css('border','1px solid #000000');
                    $('#instrumentInfoFile').css('padding','15px');
                    $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
                }                
            } 
            else if (responseStatus == 'Success') 
            {
                $requestId = $(response).find('RequestID').text();
                getRequestStatus($requestId,methodId,fileNumber);
            }
        })
        .fail(function(err) {
            if(methodId == 4)
            {
                $('#grantDeedInfoFile').next('.loader').hide();
                $('#grantDeedInfoFile').css('border','1px solid #000000');
                $('#grantDeedInfoFile').css('padding','15px');
                $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');
                
            }
            else if(methodId == 3)
            {
                $('#instrumentInfoFile').next('.loader').hide();
                $('#instrumentInfoFile').css('border','1px solid #000000');
                $('#instrumentInfoFile').css('padding','15px');
                $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
            }
        });
}

function getRequestStatus(requestId,methodId,fileNumber)
{
    $.ajax({
        url: base_url+'getRequestStatus',
        data: {
            requestId: requestId
        },
        dataType: "xml",
        type:"POST"
    })
        .done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
                if(methodId == 4)
                {
                    
                        $('#grantDeedInfoFile').next('.loader').hide();
                        $('#grantDeedInfoFile').css('border','1px solid #000000');
                        $('#grantDeedInfoFile').css('padding','15px');
                        $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');
                    
                }
                else if(methodId == 3)
                {
                    $('#instrumentInfoFile').next('.loader').hide();
                    $('#instrumentInfoFile').css('border','1px solid #000000');
                    $('#instrumentInfoFile').css('padding','15px');
                    $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
                }
            } 
            else if (responseStatus == 'Success') 
            {
                $resultId = $(response).find("RequestId:first").text();
                generateImage($resultId,methodId,fileNumber);
            }
        })
        .fail(function(err) {
            if(methodId == 4)
            {
                 $('#grantDeedInfoFile').next('.loader').hide();
                    $('#grantDeedInfoFile').css('border','1px solid #000000');
                    $('#grantDeedInfoFile').css('padding','15px');
                    $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');
                
            }
            else if(methodId == 3)
            {
                $('#instrumentInfoFile').next('.loader').hide();
                $('#instrumentInfoFile').css('border','1px solid #000000');
                $('#instrumentInfoFile').css('padding','15px');
                $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
            }
        });
}

function generateImage(requestId,methodId,fileNumber)
{
    $.ajax({
        url: base_url+'generateImage',
        data: {
            requestId: requestId,
            methodId: methodId,
            fileNumber: fileNumber,
        },
        dataType: "xml",
        type: "POST"
    })
        .done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
                if(methodId == 4)
                {
                        $('#grantDeedInfoFile').prev('.loader').hide();
                        $('#grantDeedInfoFile').css('border','1px solid #000000');
                        $('#grantDeedInfoFile').css('padding','15px');
                        $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');
                    
                }
                else if(methodId == 3)
                {
                    $('#instrumentInfoFile').prev('.loader').hide();
                    $('#instrumentInfoFile').css('border','1px solid #000000');
                    $('#instrumentInfoFile').css('padding','15px');
                    $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
                }
                
            } 
            else if (responseStatus == 'Success') 
            {
                var base64_data = $(response).find("Data:first").text();
                var bin = atob(base64_data);

                if(methodId == 3)
                {
                    /*if(L_V_CreateService == '' || L_V_GetRequestSummary == '' || L_V_GetResultById == '')
                    {
                        if (navigator.msSaveBlob)
                        {
                            var link = document.createElement('a');
                            link.setAttribute('id', 'btn-download-grant-deed');
                            link.innerHTML = 'Download Grant Deed';
                            link.download = 'GrantDeed.pdf';
                            link.className= 'btn btn-default btn-sm btn_mrg-top_30';
                            link.href = 'javascript:void(0);';
                            document.body.appendChild(link);

                            document.getElementById("btn-download-grant-deed").addEventListener("click", function(){
                                
                                var filename = "GrantDeed.pdf";
                                
                                download(filename, base64_data);
                            }, false);
                        }
                        else
                        {
                            var link = document.createElement('a');
                            link.innerHTML = 'Download Grant Deed';
                            link.download = 'GrantDeed.pdf';
                            link.className= 'btn btn-default btn-sm btn_mrg-top_30';
                            link.href = 'data:application/octet-stream;base64,' + base64_data;
                            document.body.appendChild(link);
                        }                    
                       
                        $('#instrumentInfoFile').next('.loader').hide();
                        $('#instrumentInfoFile').html(link);
                    }
                    else
                    {*/
                        if (navigator.msSaveBlob)
                        {
                            var filename = "GrantDeed.pdf";
                            download(filename, base64_data);
                        }
                        else
                        {
                            download('GrantDeed.pdf', base64_data);
                        }
                        $('#instrumentInfoFile').next('.loader').hide();
                    /*}*/
                }
                else if(methodId == 4)
                {
                    /*if(L_V_CreateService == '' || L_V_GetRequestSummary == '' || L_V_GetResultById == '')
                    {
                        if (navigator.msSaveBlob)
                        {
                            var link = document.createElement('a');
                            link.setAttribute('id', 'btn-download-L-V');
                            link.innerHTML = 'Download L&V';
                            link.download = 'L&V.pdf';
                            link.className= 'btn btn-default btn-sm btn_mrg-top_30';
                            link.href = 'javascript:void(0);';
                            document.body.appendChild(link);

                            document.getElementById("btn-download-L-V").addEventListener("click", function(){
                                
                                var filename = "L&V.pdf";
                                
                                download(filename, base64_data);
                            }, false);
                        }
                        else
                        {
                            var link = document.createElement('a');
                            link.setAttribute('id', 'dwn-btn');
                            link.innerHTML = 'Download L&V';
                            link.download = 'L&V.pdf';
                            link.className= 'btn btn-default btn-sm btn_mrg-top_30';
                            link.href = 'data:application/octet-stream;base64,' + base64_data;
                            document.body.appendChild(link);
                        }
                        $('#grantDeedInfoFile').next('.loader').hide();
                        $('#grantDeedInfoFile').html(link);
                    }
                    else
                    {*/
                        if (navigator.msSaveBlob)
                        {
                            var filename = "L&V.pdf";                            
                            download(filename, base64_data);
                        }
                        else
                        {
                            download('L&V.pdf', base64_data);
                        }
                        $('#grantDeedInfoFile').next('.loader').hide();
                    /*}*/
                }
            }
        })
        .fail(function(err) {
            if(methodId == 4)
            {
                if(methodId == 4)
                {
                    $('#grantDeedInfoFile').prev('.loader').hide();
                    $('#grantDeedInfoFile').css('border','1px solid #000000');
                    $('#grantDeedInfoFile').css('padding','15px');
                    $('#grantDeedInfoFile').html('<span class="orderinfo1">No data found.</span>');
                }
                else if(methodId == 3)
                {
                    $('#instrumentInfoFile').prev('.loader').hide();
                    $('#instrumentInfoFile').css('border','1px solid #000000');
                    $('#instrumentInfoFile').css('padding','15px');
                    $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
                }
            }
            else if(methodId == 3)
            {
                $('#instrumentInfoFile').prev('.loader').hide();
                $('#instrumentInfoFile').css('border','1px solid #000000');
                $('#instrumentInfoFile').css('padding','15px');
                $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
            }
            
        });
}

function instrumentSearch(docId,recDate,state,county,fileNumber)
{
    $('#instrumentInfoFile').next('.loader').show();
    $.ajax({
        // url: 'php/createservice.php',
        url: base_url+'instrumentService',
        data: {
            state: state,
            county: county,
            docId: docId,
            recDate: recDate,
            methodId: 3,
        },
        dataType: "xml",
        type: "POST"
    })
        .done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
                
                $('#instrumentInfoFile').prev('.loader').hide();
                $('#instrumentInfoFile').css('border','1px solid #000000');
                $('#instrumentInfoFile').css('padding','15px');
                $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
                
            } 
            else if (responseStatus == 'Success') 
            {
                $requestId = $(response).find('RequestID').text();
                getInstrumentRequestSummaries($requestId,'3',fileNumber);
            }
        })
        .fail(function(err) {
            
            $('#instrumentInfoFile').prev('.loader').hide();
            $('#instrumentInfoFile').css('border','1px solid #000000');
            $('#instrumentInfoFile').css('padding','15px');
            $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>'); 
                      
        });
}

function getInstrumentRequestSummaries(requestId,methodId,fileNumber)
{
    var apn = $("#apn").val();
    $.ajax({
        url: base_url+'getRequestSummaries',
        data: {
            requestId: requestId,
            methodId: methodId,
            apn: apn,
        },
        dataType: "xml",
        type: "POST"
    })
        .done(function(response, textStatus, jqXHR) {

            var responseStatus = $(response).find('ReturnStatus').text();
            
            if (responseStatus == 'Failed') 
            {
                $('#instrumentInfoFile').prev('.loader').hide();
                $('#instrumentInfoFile').css('border','1px solid #000000');
                $('#instrumentInfoFile').css('padding','15px');
                $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
            } 
            else if (responseStatus == 'Success') 
            {
                serviceId = '';                
                serviceId = $(response).find("RequestSummaries:first").find("RequestSummary:first").find("Order:first").find("Services:first").find("Service:first").find("ID:first").text();
                imageCreateRequest(serviceId,methodId,fileNumber);
            }
        })
        .fail(function(err) {
            $('#instrumentInfoFile').prev('.loader').hide();
            $('#instrumentInfoFile').css('border','1px solid #000000');
            $('#instrumentInfoFile').css('padding','15px');
            $('#instrumentInfoFile').html('<span class="orderinfo1">No data found.</span>');
        });
}

function base64toBlob(base64Data, contentType) {
    contentType = contentType || '';
    var sliceSize = 1024;
    var byteCharacters = atob(base64Data);
    var bytesLength = byteCharacters.length;
    var slicesCount = Math.ceil(bytesLength / sliceSize);
    var byteArrays = new Array(slicesCount);

    for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
        var begin = sliceIndex * sliceSize;
        var end = Math.min(begin + sliceSize, bytesLength);

        var bytes = new Array(end - begin);
        for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
            bytes[i] = byteCharacters[offset].charCodeAt(0);
        }
        byteArrays[sliceIndex] = new Uint8Array(bytes);
    }
    return new Blob(byteArrays, { type: contentType });
}

function download(filename, text) {

    /*if(L_V_CreateService == '' || L_V_GetRequestSummary == '' || L_V_GetResultById == '')
    {
        var csvData = base64toBlob(text,'application/octet-stream');
        var csvURL = navigator.msSaveBlob(csvData, filename);

        var element = document.createElement('a');
        element.setAttribute('href', csvURL);
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);

        document.body.removeChild(element);
    }
    else
    {*/
        if (navigator.msSaveBlob)
        {
            var csvData = base64toBlob(text,'application/octet-stream');
            var csvURL = navigator.msSaveBlob(csvData, filename);
            var element = document.createElement('a');
            element.setAttribute('href', csvURL);
            element.setAttribute('download', filename);

            element.style.display = 'none';
            document.body.appendChild(element);

            document.body.removeChild(element);
        }
        else
        {
            var csvURL = 'data:application/octet-stream;base64,'+text;
            var element = document.createElement('a');
            element.setAttribute('href', csvURL);
            element.setAttribute('download', filename);

            element.style.display = 'none';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }
    /*}*/

    
}