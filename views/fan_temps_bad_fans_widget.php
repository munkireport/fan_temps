<div class="col-lg-4 col-md-6">
    <div class="card" id="fan_temps_bad_fans-widget">
        <div id="fan_temps_bad_fans-widget" class="card-header" data-container="body">
            <i class="fa fa-asterisk"></i> 
            <span data-i18n="fan_temps.MSSF"></span>
            <a href="/show/listing/fan_temps/fans" class="pull-right"><i class="fa fa-list"></i></a>
        </div>
        <div class="card-body text-center"></div>
    </div>
</div><!-- /col -->

<script>
$(document).on('appUpdate', function(e, lang) {

    $.getJSON( appUrl + '/module/fan_temps/get_bad_fans', function( data ) {
        if(data.error){
            //alert(data.error);
            return;
        }

        var panel = $('#fan_temps_bad_fans-widget div.card-body'),
        baseUrl = appUrl + '/show/listing/fan_temps/fans/';
        panel.empty();
        // Set blocks, disable if zero
        if(data.yes != "0"){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-danger"><span class="bigger-150">'+data.yes+'</span><br>&nbsp;&nbsp;'+i18n.t('yes')+'&nbsp;&nbsp;</a>');
        } else {
            panel.append(' <a href="'+baseUrl+'" class="btn btn-danger disabled"><span class="bigger-150">'+data.yes+'</span><br>&nbsp;&nbsp;'+i18n.t('yes')+'&nbsp;&nbsp;</a>');
        }
        if(data.no != "0"){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-success"><span class="bigger-150">'+data.no+'</span><br>&nbsp;&nbsp;'+i18n.t('no')+'&nbsp;&nbsp;</a>');
        } else {
            panel.append(' <a href="'+baseUrl+'" class="btn btn-success disabled"><span class="bigger-150">'+data.no+'</span><br>&nbsp;&nbsp;'+i18n.t('no')+'&nbsp;&nbsp;</a>');
        }
    });
});

</script>
