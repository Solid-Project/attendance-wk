<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
</head>
<body>
    <table width="100%" style="border-collapse: collapse">
        <tr style="border-bottom: 1pt solid black;">
            <td align="left"><img src="<?=$user->TenantLogo?>" width="25%"></td>
            <td align="right">
                <h1>QUOTATION</h1>
            </td>
        </tr>
    </table>
    <br/>

    <table width="100%" border="0" style="border-bottom: 1; border-collapse: collapse">
        <tr>
            <td align="left">
                <table width="100%" border="0">
                    <tr>
                        <td>
                            Quotation No.
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?=@$quo->QuotationNumber?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Quotation Date
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?=@date_format(date_create($quo->QuotationDate), "d/m/Y")?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Due Date
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?=@date_format(date_create($quo->DueDate), "d/m/Y")?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td>
                            RFQ No.
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?=(@$quo->RFQNumber)?$quo->RFQNumber:'-'?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            RFQ Date.
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?=(@$quo->RFQDate)?$quo->RFQDate:'-'?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Project No.
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?=(@$quo->ProjectNumber)?$quo->ProjectNumber:'-'?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>

                </table>
            </td>

            <!-- quoteTo -->
            <td align="right">
                <table width="100%" border="0">
                    <tr>
                        <td align="right">
                            Quote To
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <?=(@$quo->CustomerName)?$quo->CustomerName:'-'?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <?=(@$quo->CustomerAddress)?$quo->CustomerAddress:'-'?>
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <?=(@$quo->CustomerAddrKelurahan)?$quo->CustomerAddrKelurahan:'-'?>
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <?=(@$quo->CustomerAddrKecamatan)?$quo->CustomerAddrKecamatan:'-'?><?=(@$quo->CustomerAddrKota)?", ".$quo->CustomerAddrKota:'-'?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <?=(@$quo->CustomerAddrProvinsi)?$quo->CustomerAddrProvinsi:'-'?>
                            <?=(@$quo->CustomerAddrKodePos)?", ".$quo->CustomerAddrKodePos:'-'?>
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <?=(@$quo->CustomerNoTelp)?$quo->CustomerNoTelp:''?>
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <?=(@$quo->CustomerNoFax)?$quo->CustomerNoFax:''?>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>


    <table width="100%" style="border-collapse: collapse; margin-top: 30px;">
        <tr style="border-top: 1pt solid black;">
            <td align="justify" style="padding: 15px;">
                            <?=(@$quo->Description)?$quo->Description:''?></td>
        </tr>
    </table>
    <br/>


    <table width="100%" style="border-collapse: collapse; margin-top: 30px;">
        <tr style="border-top: 1pt solid black; border-bottom: 1pt solid black;">
            <td align="center" style="padding: 10px;" width="5%">No</td>
            <td align="center" style="padding: 10px;">Description</td>
            <td align="center" style="padding: 15px;" width="5%">Qty</td>
            <td align="center" style="padding: 10px;" width="15%">Item Price</td>
            <td align="center" style="padding: 10px;" width="15%">Unit Price</td>
        </tr>

        <?php 
            $dataTransaction = json_decode($this->api->CallAPI('GET', 'http://localhost/api/project-management/api/v1/Transaction', ['TenantName' => $quo->TenantName, 'ProjectNumber' => $quo->ProjectNumber, 'ProjectStatus' => 'Draft', 'order_by' => ['DateCreated', 'DESC']]));

            
            $no = 1;
            $subTotal = 0;
            $valueAddedTax = 0;
            foreach ($dataTransaction->result as $key) {
                $subTotal = $subTotal + $key->TotalPriceProjection;
        ?>
        <tr>
            <td align="center" valign="top"><?=$no?></td>
            <td><?=$key->ItemName?> 
                <?php if (@$key->ItemDescription != ""){ ?>
                    <table border="0">
                        <tr>
                            <td>
                                <p align="justify"><?=$key->ItemDescription?></p>
                            </td>
                        </tr>
                    </table>
                <?php } ?>
            </td>
            <td align="center" style="padding: 15px;"><?=number_format($key->Qty, 0, ',', '.')?></td>
            <td align="right" style="padding: 15px;"><?=number_format($key->PriceProjection, 0, ',', '.')?></td>
            <td align="right">Rp. <?=number_format($key->TotalPriceProjection, 0, ',', '.')?></td>
        </tr>
        <?php $no++;} ?>

        <tr style="border-bottom: 1pt solid black;">
            <td colspan="5">&nbsp;</td>
        </tr>

        <tr>
            <td align="right" colspan="2">&nbsp;</td>
            <td align="right" colspan="2">Sub Total</td>
            <td align="right">Rp. <?=number_format($subTotal, 0, ',', '.')?></td>
        </tr>

        <tr>
            <td align="left" colspan="2"><b>Says</b> <i># Ten Million Rupiahs only #</i></td>
            <td align="right" colspan="2">Value Added Tax</td>
            <td align="right">Rp. <?=number_format($valueAddedTax, 0, ',', '.')?></td>
        </tr>

        <tr>
            <td align="right" colspan="3">&nbsp;</td>
            <td align="right" style="border-bottom: 1pt solid black;">Grand Total</td>
            <td align="right" style="border-bottom: 1pt solid black;">Rp. <?=number_format($subTotal - $valueAddedTax, 0, ',', '.')?></td>
        </tr>

    </table>
    <br/>

    <table width="100%" border="0" style="border-collapse: collapse; margin-top: 30px;">
        <tr>
            <td align="justify" width="10%">Term and Conditions</td>
            <td align="justify" width="5%">:</td>
            <td align="justify">&nbsp;</td>
        </tr>
        <tr>
            <td align="justify" colspan="3">
                <ol>
                    <li>Payment Term is CBD</li>
                    <li>Franco Jakarta</li>
                    <li>Delivery 6 - 8 Weeks</li>
                </ol>
            </td>
        </tr>
    </table>
    <br/>

    <table width="100%" border="0" style="border-collapse: collapse; margin-top: 30px;">
        <tr>
            <td width="70%"></td>
            <td></td>
            <td align="center" style="border-bottom: 1px solid #000"><?=$user->EmployeeFirstName?> <?=$user->EmployeeMiddleName?> <?=$user->EmployeeLastName?></td>
        </tr>
    </table>
    <br/>

</body>
</html>