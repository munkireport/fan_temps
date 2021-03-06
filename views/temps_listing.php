<?php $this->view('partials/head'); ?>

<div class="container-fluid">
  <div class="row pt-4">
  	<div class="col-lg-12">
		  <h3><span data-i18n="fan_temps.reporttitle_temps"></span> <span id="total-count" class='badge badge-primary'>…</span></h3>
		  <table class="table table-striped table-condensed table-bordered">
		    <thead>
		      <tr>
		      	<th data-i18n="listing.computername" data-colname='machine.computer_name'></th>
		        <th data-i18n="serial" data-colname='reportdata.serial_number'></th>
		        <th data-i18n="fan_temps.TA0P" data-colname='fan_temps.ta0p'></th>
		        <th data-i18n="fan_temps.TC0F" data-colname='fan_temps.tc0f'></th>
		        <th data-i18n="fan_temps.TC0D" data-colname='fan_temps.tc0d'></th>
		        <th data-i18n="fan_temps.tc0p_short" data-colname='fan_temps.tc0p'></th>
		        <th data-i18n="fan_temps.TB0T" data-colname='fan_temps.tb0t'></th>
		        <th data-i18n="fan_temps.TB1T" data-colname='fan_temps.tb1t'></th>
		        <th data-i18n="fan_temps.TB2T" data-colname='fan_temps.tb2t'></th>
		        <th data-i18n="fan_temps.TG0D" data-colname='fan_temps.tg0d'></th>
		        <th data-i18n="fan_temps.TG0H" data-colname='fan_temps.tg0h'></th>
		        <th data-i18n="fan_temps.tg0p_short" data-colname='fan_temps.tg0p'></th>
		        <th data-i18n="fan_temps.tl0p_short" data-colname='fan_temps.tl0p'></th>
		        <th data-i18n="fan_temps.th0p_short" data-colname='fan_temps.th0p'></th>
		        <th data-i18n="fan_temps.T_h0H" data-colname='fan_temps.th0h'></th>
		        <th data-i18n="fan_temps.T_h1H" data-colname='fan_temps.th1h'></th>
		        <th data-i18n="fan_temps.T_h2H" data-colname='fan_temps.th2h'></th>
		        <th data-i18n="fan_temps.TM0S" data-colname='fan_temps.tm0s'></th>
		        <th data-i18n="fan_temps.tm0p_short" data-colname='fan_temps.tm0p'></th>
		        <th data-i18n="fan_temps.T_s0P" data-colname='fan_temps.ts0p'></th>
		        <th data-i18n="fan_temps.TN0H" data-colname='fan_temps.tn0h'></th>
		        <th data-i18n="fan_temps.tn0d_short" data-colname='fan_temps.tn0d'></th>
		        <th data-i18n="fan_temps.tn0p_short" data-colname='fan_temps.tn0p'></th>
		        <th data-i18n="fan_temps.tp0p_short" data-colname='fan_temps.tp0p'></th>
		      </tr>
		    </thead>
		    <tbody>
		    	<tr>
		             <td data-i18n="listing.loading" colspan="24" class="dataTables_empty"></td>
		    	</tr>
		    </tbody>
		  </table>
    </div> <!-- /span 12 -->
  </div> <!-- /row -->
</div>  <!-- /container -->

<script type="text/javascript">

	$(document).on('appUpdate', function(e){

		var oTable = $('.table').DataTable();
		oTable.ajax.reload();
		return;

	});	

	$(document).on('appReady', function(e, lang) {

        // Get modifiers from data attribute
        var mySort = [], // Initial sort
            hideThese = [], // Hidden columns
            col = 0, // Column counter
            runtypes = [], // Array for runtype column 
            columnDefs = [{ visible: false, targets: hideThese }]; //Column Definitions

        $('.table th').map(function(){

            columnDefs.push({name: $(this).data('colname'), targets: col, render: $.fn.dataTable.render.text()});

            if($(this).data('sort')){
              mySort.push([col, $(this).data('sort')])
            }

            if($(this).data('hide')){
              hideThese.push(col);
            }

            col++
        });

	    oTable = $('.table').dataTable( {
            ajax: {
                url: appUrl + '/datatables/data',
                type: "POST",
                data: function(d){
                    d.mrColNotEmpty = "fan_temps.id";
                        
                    // Check for column in search
                    if(d.search.value){
                        $.each(d.columns, function(index, item){
                            if(item.name == 'munkireport.' + d.search.value){
                                d.columns[index].search.value = '> 0';
                            }
                        });
                    };
                }
            },
            dom: mr.dt.buttonDom,
            buttons: mr.dt.buttons,
            order: mySort,
            columnDefs: columnDefs,
		    createdRow: function( nRow, aData, iDataIndex ) {
	        	// Update name in first column to link
	        	var name=$('td:eq(0)', nRow).html();
	        	if(name == ''){name = "No Name"};
	        	var sn=$('td:eq(1)', nRow).html();
                var link = mr.getClientDetailLink(name, sn, '#tab_temps-tab');
	        	$('td:eq(0)', nRow).html(link);

                var temperature_unit = "<?=conf('temperature_unit')?>";
                // Check if temperature_unit exists, if not default to C
                if (!temperature_unit){
                    temperature_unit = "C"
                }
                
                // 
                var columnvar=$('td:eq(2)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(2)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(2)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(2)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(3)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(3)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(3)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(3)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(4)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(4)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(4)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(4)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }  
                
                // ambient air 0
                var columnvar=$('td:eq(5)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(5)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(5)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(5)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                var columnvar=$('td:eq(6)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(6)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(6)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(6)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                var columnvar=$('td:eq(7)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(7)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(7)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(7)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                var columnvar=$('td:eq(8)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(8)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(8)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(8)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                var columnvar=$('td:eq(9)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(9)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(9)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(9)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                var columnvar=$('td:eq(10)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(10)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(10)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(10)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(11)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(11)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(11)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(11)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(12)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(12)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(12)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(12)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(13)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(13)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(13)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(13)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(14)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(14)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(14)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(14)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(15)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(15)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(15)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(15)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(16)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(16)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(16)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(16)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(17)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(17)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(17)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(17)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(18)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(18)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(18)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(18)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(19)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(19)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(19)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(19)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(20)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(20)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(20)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(20)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(21)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(21)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(21)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(21)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(22)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(22)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(22)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(22)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }

                // 
                var columnvar=$('td:eq(23)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(23)', nRow).html('');
                } else{				 
                     temperature_c = parseFloat((columnvar * 1).toFixed(2))+"°C";
                     temperature_f = parseFloat(((columnvar * 9/5 ) + 32 ).toFixed(2))+"°F";
                     if ( temperature_unit == "F" ){
                          $('td:eq(23)', nRow).html('<span title="'+temperature_c+'">'+temperature_f+'</span>');
                     } else{
                          $('td:eq(23)', nRow).html('<span title="'+temperature_f+'">'+temperature_c+'</span>');
                     }
                }
		    }
	    });
	});
</script>

<?php $this->view('partials/foot'); ?>
