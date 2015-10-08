<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/style.css">
        
        <style>
            * {
                margin:0px;
                padding:5px;
            }
            body {
                color: #000 !important;
            }
            table {
                width:100%;
            }
            #header table {
                width:100%;
                padding: 0px;
            }
            #header table td, .amount-summary td {
                vertical-align: text-top;
                padding: 5px;
            }
            #company-name{
                color:#000;
                font-size: 18px;
            }
            #invoice-to td {
                text-align: left
            }
            #invoice-to {
                margin-bottom: 15px;
            }
            #invoice-to-right-table td {
                padding-right: 5px;
                padding-left: 5px;
                text-align: right;
            }
            .seperator {
                height: 25px
            }
            .top-border {
                border-top: none;
            }
            .no-bottom-border {
                border:none !important;
                background-color: white !important;
            }
        </style>
        
	</head>
	<body>
        
        <div id="header">
            <table>
                <tr>
                    <td style="text-align: left;">
                        <h1 style="color: #585858;"><?php echo lang('mInvoice'); ?></h1>
                        <p>
                            <abbr>Num. </abbr><?php echo lang('invoice'); ?>: <?php echo $invoice->invoice_number . '<br>' ; ?>
                            
                            <?php echo lang('invoice_date'); ?>:
                            <?php echo date_from_mysql($invoice->invoice_date_created, TRUE) ; ?>
                            <br>
                            <?php echo lang('due_date'); ?>:
                            <?php echo date_from_mysql($invoice->invoice_date_due, TRUE); ?>
                        </p>
                    </td>
                    
                    <td style="text-align: right;">
                        <?php echo invoice_logo_pdf(); ?>
                        <?php echo $invoice->user_name; ?>
                        <p>
                            <?php if ($invoice->usuario_custom_nif) { echo $invoice->usuario_custom_nif . '<br>'; } ?>
                            <?php if ($invoice->user_address_1) { echo $invoice->user_address_1 . '<br>'; } ?>
                            <?php if ($invoice->user_city) { echo $invoice->user_city . ', '; } ?>
                            <?php if ($invoice->user_state) { echo $invoice->user_state . ' '; } ?>
                            <?php if ($invoice->user_zip) { echo $invoice->user_zip . '<br>'; } ?> 
                            <!--<?php if ($invoice->user_mobile) { ?><abbr>Tel: </abbr><?php echo $invoice->user_mobile . '<br>'; ?><?php } ?>-->
                            <u style="color: #585858;"><?php if ($invoice->user_email) { ?><?php echo $invoice->user_email; ?><?php } ?></u>
                            <!--<?php if ($invoice->user_fax) { ?><abbr>F:</abbr><?php echo $invoice->user_fax; ?><?php } ?>-->
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        
        <div id="invoice-to">
            <table style="width: 100%;">
                <tr>
                    <td style="padding-left: 5px;">
                        <br><br>
                        <!--<p><?php echo lang('bill_to'); ?>:</p>-->
                        <h4 style="color: #585858;"><?php echo lang('mClient'); ?></h4>	
                        <p><?php echo $invoice->client_name; ?><br>
                            <?php if ($invoice->cliente_custom_cif) { echo $invoice->cliente_custom_cif . '<br>'; } ?>
                            <?php if ($invoice->client_address_1) { echo $invoice->client_address_1 . '<br>'; } ?>
                            <?php if ($invoice->client_city) { echo $invoice->client_city . ','; } ?>
                            <?php if ($invoice->client_state) { echo $invoice->client_state . ' '; } ?>
                            <?php if ($invoice->client_zip) { echo $invoice->client_zip . '<br>'; } ?>
                            <!--<?php if ($invoice->client_phone) { ?><abbr>Tel:</abbr><?php echo $invoice->client_phone; ?><br><?php } ?>-->
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div id="invoice-items">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <!--<th><?php echo lang('item'); ?></th>-->
                        <th><?php echo lang('description'); ?></th>
                        <th style="text-align: right;"><?php echo lang('qty'); ?></th>
                        <!--<th style="text-align: right;"><?php echo lang('qty'); ?></th>-->
                        <th style="text-align: right;"><?php echo lang('price'); ?></th>
                        <th style="text-align: right;"><?php echo lang('total'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <!--<td><?php echo $item->item_name; ?></td>-->
                            <td><?php echo nl2br($item->item_description); ?></td>
                            <td style="text-align: right;"><?php echo format_amount($item->item_quantity); ?></td>
                            <td style="text-align: right;"><?php echo format_currency($item->item_price); ?></td>
                            <td style="text-align: right;"><?php echo format_currency($item->item_subtotal); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <br><br><br><br><br><br><br>
            
            <table>
                <tr>
                    <td style="text-align: right;">
                        <table class="amount-summary">
                            <tr>
                                <td style="text-align: right;"><?php echo lang('subtotal'); ?>:</td>
                                <td style="text-align: right;"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
                            </tr>
                            <?php if ($invoice->invoice_item_tax_total > 0) { ?>
                            <tr>
                                <td style="text-align: right;"><?php echo lang('item_tax'); ?>:</td>
                                <td style="text-align: right;"><?php echo format_currency($invoice->invoice_item_tax_total); ?></td>
                            </tr>
                               
                            <tr>
                                <td style="text-align: right;"><strong><?php echo lang('total'); ?> FACTURA:</strong></td>
                                <td style="text-align: right;"><strong><?php echo format_currency($invoice->invoice_total); ?></strong></td>
                            </tr>
                                                                                                                                                    
                            
                            <?php } ?>
                            <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
                                <tr>    
                                    <td style="text-align: right;"><?php echo $invoice_tax_rate->invoice_tax_rate_name . ' ' . $invoice_tax_rate->invoice_tax_rate_percent; ?>%</td>
                                    <td style="text-align: right;"><?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?></td>
                                </tr>
                            <?php endforeach ?>
                            <!--
                            <tr>
                                <td style="text-align: right;"><?php echo lang('paid'); ?>:</td>
                                <td style="text-align: right;"><?php echo format_currency($invoice->invoice_paid) ?></td>
                            </tr>
                            -->
                            <tr>
                                <td style="text-align: right;"><strong><?php echo lang('balance'); ?>:</strong></td>
                                <td style="text-align: right;"><strong><?php echo format_currency($invoice->invoice_total - $invoice_tax_rate->invoice_tax_rate_amount) ?></strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <div class="seperator"></div>
            <?php if ($invoice->invoice_terms) { ?>
            <h4><?php echo lang('terms'); ?></h4>
            <p><?php echo nl2br($invoice->invoice_terms); ?></p>
            <?php } ?>
        </div>
	</body>
</html>