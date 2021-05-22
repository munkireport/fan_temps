<?php $this->view('partials/head'); ?>

<div class="container-fluid">
  <div class="row pt-4">
  	<div class="col-lg-12">
		  <h3><span data-i18n="fan_temps.reporttitle_fans"></span> <span id="total-count" class='badge badge-primary'>…</span></h3>
		  <table class="table table-striped table-condensed table-bordered">
		    <thead>
		      <tr>
		      	<th data-i18n="listing.computername" data-colname='machine.computer_name'></th>
		        <th data-i18n="serial" data-colname='reportdata.serial_number'></th>
		        <th data-i18n="name" data-colname='fan_temps.f0id'></th>
		        <th data-i18n="fan_temps.speed" data-colname='fan_temps.f0ac'></th>
		        <th data-i18n="fan_temps.minfan" data-colname='fan_temps.f0mn'></th>
		        <th data-i18n="fan_temps.maxfan" data-colname='fan_temps.f0mx'></th>
		        <th data-i18n="name" data-colname='fan_temps.f1id'></th>
		        <th data-i18n="fan_temps.speed" data-colname='fan_temps.f1ac'></th>
		        <th data-i18n="fan_temps.minfan" data-colname='fan_temps.f1mn'></th>
		        <th data-i18n="fan_temps.maxfan" data-colname='fan_temps.f1mx'></th>
		        <th data-i18n="name" data-colname='fan_temps.f2id'></th>
		        <th data-i18n="fan_temps.speed" data-colname='fan_temps.f2ac'></th>
		        <th data-i18n="fan_temps.minfan" data-colname='fan_temps.f2mn'></th>
		        <th data-i18n="fan_temps.maxfan" data-colname='fan_temps.f2mx'></th>
		        <th data-i18n="fan_temps.fnfd_short" data-colname='fan_temps.fnfd'></th>
		        <th data-i18n="fan_temps.mssf_short" data-colname='fan_temps.mssf'></th>
		        <th data-i18n="fan_temps.fnum_short" data-colname='fan_temps.fnum'></th>
		      </tr>
		    </thead>
		    <tbody>
		    	<tr>
			   <td data-i18n="listing.loading" colspan="17" class="dataTables_empty"></td>
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
                    d.mrColNotEmpty = "fan_temps.f0mx";
                        
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
                var link = mr.getClientDetailLink(name, sn, '#tab_fans-tab');
	        	$('td:eq(0)', nRow).html(link);

                var columnvar=$('td:eq(3)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(3)', nRow).html('');
                } else{				 
                     $('td:eq(3)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }
                
                var columnvar=$('td:eq(4)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(4)', nRow).html('');
                } else{				 
                     $('td:eq(4)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }
                
                var columnvar=$('td:eq(5)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(5)', nRow).html('');
                } else{				 
                     $('td:eq(5)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }
                
                var columnvar=$('td:eq(7)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(7)', nRow).html('');
                } else{				 
                     $('td:eq(7)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }
                
                var columnvar=$('td:eq(8)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(8)', nRow).html('');
                } else{				 
                     $('td:eq(8)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }
                
                var columnvar=$('td:eq(9)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(9)', nRow).html('');
                } else{				 
                     $('td:eq(9)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }
                
                var columnvar=$('td:eq(11)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(11)', nRow).html('');
                } else{				 
                     $('td:eq(11)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }
                
                var columnvar=$('td:eq(12)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(12)', nRow).html('');
                } else{				 
                     $('td:eq(12)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }
                
                var columnvar=$('td:eq(13)', nRow).html();
                if(columnvar == "") {
                     $('td:eq(13)', nRow).html('');
                } else{				 
                     $('td:eq(13)', nRow).html(columnvar+" "+i18n.t('fan_temps.rpm'));
                }

                var columnvar=$('td:eq(14)', nRow).html();
                columnvar = columnvar > '1' ? i18n.t('yes') :
                (columnvar === '0' ? i18n.t('no') : '')
                $('td:eq(14)', nRow).html(columnvar)
                
                var columnvar=$('td:eq(15)', nRow).html();
                columnvar = columnvar == '1' ? i18n.t('yes') :
                (columnvar === '0' ? i18n.t('no') : '')
                $('td:eq(15)', nRow).html(columnvar)

             }
	    });
	});
</script>

<?php $this->view('partials/foot'); ?>
