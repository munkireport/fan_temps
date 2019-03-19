<div class="col-lg-4 col-md-6">
    <div class="panel panel-default" id="fan_temps_odd_inserted-widget">
        <div id="fan_temps_odd_inserted-widget" class="panel-heading" data-container="body">
            <h3 class="panel-title"><i class="fa fa-sign-in fa-rotate-270"></i> 
                <span data-i18n="fan_temps.MSDI"></span>
                <list-link data-url="/show/listing/fan_temps/smc"></list-link>
            </h3>
        </div>
        <div class="panel-body text-center"></div>
    </div><!-- /panel -->
</div><!-- /col -->

<script>
$(document).on('appUpdate', function(e, lang) {

    $.getJSON( appUrl + '/module/fan_temps/get_odd_inserted', function( data ) {
        if(data.error){
            //alert(data.error);
            return;
        }

        var panel = $('#fan_temps_odd_inserted-widget div.panel-body'),
        baseUrl = appUrl + '/show/listing/fan_temps/smc/';
        panel.empty();
        // Set blocks, disable if zero
        if(data.yes != "0"){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-warning"><span class="bigger-150">'+data.yes+'</span><br>&nbsp;&nbsp;'+i18n.t('yes')+'&nbsp;&nbsp;</a>');
        } else {
            panel.append(' <a href="'+baseUrl+'" class="btn btn-warning disabled"><span class="bigger-150">'+data.yes+'</span><br>&nbsp;&nbsp;'+i18n.t('yes')+'&nbsp;&nbsp;</a>');
        }
        if(data.no != "0"){
            panel.append(' <a href="'+baseUrl+'" class="btn btn-success"><span class="bigger-150">'+data.no+'</span><br>&nbsp;&nbsp;'+i18n.t('no')+'&nbsp;&nbsp;</a>');
        } else {
            panel.append(' <a href="'+baseUrl+'" class="btn btn-success disabled"><span class="bigger-150">'+data.no+'</span><br>&nbsp;&nbsp;'+i18n.t('no')+'&nbsp;&nbsp;</a>');
        }
    });
});

</script>
