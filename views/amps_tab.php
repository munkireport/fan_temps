<div id="amps"></div>
<h2 data-i18n="fan_temps.tabtitle_amps"></h2>

<div id="apms-msg" data-i18n="listing.loading" class="col-lg-12 text-center"></div>

<script>
$(document).on('appReady', function(){
	$.getJSON(appUrl + '/module/fan_temps/get_tab_data/' + serialNumber, function(data){
        if( ! data ){
            // Change loading message to no data
            $('#apms-msg').text(i18n.t('no_data'));
            $('#fans-msg').text(i18n.t('no_data'));
            $('#temps-msg').text(i18n.t('no_data'));
            $('#smc-msg').text(i18n.t('no_data'));
            
        } else {
            
            // Hide loading/no data message
            $('#apms-msg').text('');
            $('#fans-msg').text('');
            $('#temps-msg').text('');
            $('#smc-msg').text('');
            
            var skipThese = ['TEMPERATURE_UNIT'];
            var amps_rows = ''
            var fan_rows = ''
            var smc_rows = ''
            var temps_rows = ''
            var volts_rows = ''
            var watts_rows = ''
            // Process each key in the JSON array
            for (var prop in data){
                local_prop = escape_lower_case(prop)
                // Skip skipThese
                if(skipThese.indexOf(prop) == -1){
                    if (data[prop] == null){
                       // Do nothing for nulls to blank them
                    
                    // Create fan speed table section
                    } else if (prop.startsWith("F") && prop.endsWith("Mn")){
					   fan_rows = fan_rows + '<tr><th>&nbsp;&nbsp;&nbsp;&nbsp;'+i18n.t('fan_temps.fanmin')+'</th><td>'+parseInt(data[prop])+' '+i18n.t('fan_temps.rpm')+'</td></tr>';
                    } else if (prop.startsWith("F") && prop.endsWith("Mx")){
					   fan_rows = fan_rows + '<tr><th>&nbsp;&nbsp;&nbsp;&nbsp;'+i18n.t('fan_temps.fanmax')+'</th><td>'+parseInt(data[prop])+' '+i18n.t('fan_temps.rpm')+'</td></tr>';
                        
                    } else if (prop.startsWith("F") && prop.endsWith("Ac")){
                        
                        if (data[(prop.replace('Ac', 'ID'))]) {
                           fan_rows = fan_rows + '<tr><th>'+data[(prop.replace('Ac', 'ID'))]+' '+i18n.t('fan_temps.fan')+' '+i18n.t('fan_temps.current_speed')+'</th><td>'+parseInt(data[prop])+' '+i18n.t('fan_temps.rpm')+'</td></tr>';
                            
                        } else {
                           fan_rows = fan_rows + '<tr><th>'+i18n.t('fan_temps.fan')+' '+(prop.replace('Ac', '').replace('F', ''))+' '+i18n.t('fan_temps.current_speed')+'</th><td>'+parseInt(data[prop])+' '+i18n.t('fan_temps.rpm')+'</td></tr>';
                        }
                        
                    } else if (i18n.t('fan_temps.'+local_prop) == 'fan_temps.'+local_prop) {
                       // Hide rows that do not have a localization
//                        alert(prop)
                        
                    // Start of amps, volts, watts rows
                    } else if (prop.startsWith("I") || prop == "B0AC" || prop == "B0RM" || prop == "B0FC" || prop == "CHBI" || prop == "D0IR" || prop == "D1IR" || prop == "D2IR" || prop == "D3IR" || prop == "D4IR"){ 
                       amps_rows = amps_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' Amps</td></tr>';

                    } else if (prop.startsWith("V") || prop == "BC1V" || prop == "BC2V" || prop == "BC3V" || prop == "CHBV" || prop == "D0VR" || prop == "D1VR" || prop == "D2VR" || prop == "D3VR" || prop == "D4VR" || prop == "D0VM" || prop == "D1VM" || prop == "D2VM" || prop == "D3VM" || prop == "D4VM" || prop == "D0VX" || prop == "D1VX" || prop == "D2VX" || prop == "D3VX" || prop == "D4VX"){
                       volts_rows = volts_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' Volts</td></tr>';

                    } else if (prop.startsWith("P")){
                       watts_rows = watts_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' Watts</td></tr>';

                    // Temperature rows
                    } else if (prop.startsWith("T")){
					   temperature_f = parseFloat(((data[prop] * 9/5 ) + 32 ).toFixed(2));
					   if (data['TEMPERATURE_UNIT'] == "F"){
					        temps_rows = temps_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td><span title="'+data[prop]+'°C">'+temperature_f+'°F</span></td></tr>';
					   } else {
					        temps_rows = temps_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td><span title="'+temperature_f+'°F">'+data[prop]+'°C</span></td></tr>';
					   }
                        
                    // Start of fan rows
                    } else if (prop == "FNFD" && data[prop] > "0"){
					   fan_rows = fan_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</th><td>'+i18n.t('yes')+'</td></tr>';
                    } else if (prop == "FNFD" && data[prop] == "0"){
					   fan_rows = fan_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</th><td>'+i18n.t('no')+'</td></tr>';
                        
                    } else if (prop == "MSSF" && data[prop] == "1"){
					   fan_rows = fan_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</th><td>'+i18n.t('yes')+'</td></tr>';
                    } else if (prop == "MSSF" && data[prop] == "0"){
					   fan_rows = fan_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</th><td>'+i18n.t('no')+'</td></tr>';
                                      
                    } else if (prop == "FNum"){
					   fan_rows = fan_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</th><td>'+data[prop]+'</td></tr>';
                        
                    } else if (prop == "dBAH" || prop == "dBAT"){
					   fan_rows = fan_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop+'_short')+'</th><td>'+data[prop]+' dBDA</td></tr>';
                        
                    } else if (prop.startsWith("dBA")){
					   fan_rows = fan_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.fan')+' '+(prop.replace('dBA', ''))+" "+i18n.t('fan_temps.noise')+'</th><td>'+data[prop]+' dBA</td></tr>';
               
                    // Start of SMC rows
                    } else if ((prop == "AUPO" || prop == "MSTM" || prop == "SPHT" || prop == "SGHT" || prop == "BBAD" || prop == "BBIN") && parseInt(data[prop]) == "1"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('yes')+'</td></tr>';
                    } else if ((prop == "AUPO" || prop == "MSTM" || prop == "SPHT" || prop == "SGHT" || prop == "BBAD" || prop == "BBIN") && parseInt(data[prop]) == "0"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('no')+'</td></tr>';
                        
                    } else if (prop == "MSDI" && parseInt(data[prop]) == "1"){
					   smc_rows = smc_rows + '<tr><th>'+i18n.t('fan_temps.'+prop)+'</th><td>'+i18n.t('yes')+'</td></tr>';
                    } else if (prop == "MSDI" && parseInt(data[prop]) == "0"){
					   smc_rows = smc_rows + '<tr><th>'+i18n.t('fan_temps.'+prop)+'</th><td>'+i18n.t('no')+'</td></tr>';
                        
                    } else if (prop == "LSOF" && parseInt(data[prop]) == "1"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('off')+'</td></tr>';
                    } else if (prop == "LSOF" && parseInt(data[prop]) == "0"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('on')+'</td></tr>';
                        
                    } else if (prop == "MSLD" && parseInt(data[prop]) == "1"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('fan_temps.closed')+'</td></tr>';
                    } else if (prop == "MSLD" && parseInt(data[prop]) == "0"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('fan_temps.open')+'</td></tr>';
                        
                    } else if (prop == "HDBS" && parseInt(data[prop]) == "1"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('enabled')+'</td></tr>';
                    } else if (prop == "HDBS" && parseInt(data[prop]) == "0"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('disabled')+'</td></tr>';
                        
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "5"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown5')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "3"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown3')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "2"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown2')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "1"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown1')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "0"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown0')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-1"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_1')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-2"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_2')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-3"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_3')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-4"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_4')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-20"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_20')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-30"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_30')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-40"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_40')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-50"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_50')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-60"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_60')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-61"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_61')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-62"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_62')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-70"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_70')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-71"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_71')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-72"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_72')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-74"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_74')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-75"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_75')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-76"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_76')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-78"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_78')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-79"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_79')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-82"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_82')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-83"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_83')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-84"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_84')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-86"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_86')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-95"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_95')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-100"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_100')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-101"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_101')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-102"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_102')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-103"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_103')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-127"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_127')+'</td></tr>';
                    } else if ((prop == "MSSD" || prop == "MSSP") && data[prop] == "-128"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' - '+i18n.t('fan_temps.shutdown_128')+'</td></tr>';
                        
                    } else if(prop == "B0TF" && data[prop] == "65535"){
                        // Do nothing for this key if "empty"
                        
                    } else if(prop == "B0TF" && data[prop] !== "65535"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' '+i18n.t('fan_temps.minutes')+'</td></tr>';
                        
                    } else if (prop == "BRSC"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+'%</td></tr>';
                    } else if (prop == "ALSL"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' lux</td></tr>';
                    } else if (prop == "NATi"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+' '+i18n.t('fan_temps.seconds')+'</td></tr>';
                        
                    } else if (prop == "NATJ" && data[prop] == "0"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('fan_temps.ninja_0')+'</td></tr>';
                    } else if (prop == "NATJ" && data[prop] == "1"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('fan_temps.ninja_1')+'</td></tr>';
                    } else if (prop == "NATJ" && data[prop] == "2"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('fan_temps.ninja_2')+'</td></tr>';
                    } else if (prop == "NATJ" && data[prop] == "3"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('fan_temps.ninja_3')+'</td></tr>';
                    } else if (prop == "NATJ" && data[prop] == "4"){
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+i18n.t('fan_temps.ninja_4')+'</td></tr>';
                        
                    } else if (prop == "SGTT" || prop == "SCTg" || prop == "SGTg" || prop == "SHTg" || prop == "SLTg" || prop == "SLTp" || prop == "SOTg" || prop == "SpTg" || prop == "SLPT" || prop == "SLST" || prop == "SpPT" || prop == "SpST"){
					   temperature_f = parseFloat(((data[prop] * 9/5 ) + 32 ).toFixed(2));
					   if (data['TEMPERATURE_UNIT'] == "F"){
					        smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td><span title="'+data[prop]+'°C">'+temperature_f+'°F</span></td></tr>';
					   } else {
					        smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td><span title="'+temperature_f+'°F">'+data[prop]+'°C</span></td></tr>';
					   }
                    
                    } else {
					   smc_rows = smc_rows + '<tr><th><span title="'+i18n.t('fan_temps.sensorname')+": "+prop+'">'+i18n.t('fan_temps.'+local_prop)+'</span></th><td>'+data[prop]+'</td></tr>';
                    }
                }
            }

            // Only show and sort amps table if data exists
            if (amps_rows !== ""){
                $('#amps-tab')
                    .append($('<h4>')
                        .append($('<i>')
                            .addClass('fa fa-bolt'))
                        .append(' '+i18n.t('fan_temps.amps')))
                    .append($('<div style="max-width:370px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody id="amps_table">')
                                .append(amps_rows))))
                sortTable_temps(amps_table);
            }

            // Only show and sort volts table if data exists
            if ( volts_rows !== ""){
                $('#amps-tab')
                    .append($('<h4>')
                        .append($('<i>')
                            .addClass('fa fa-battery-full'))
                        .append(' '+i18n.t('fan_temps.volts')))
                    .append($('<div style="max-width:370px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody id="volts_table">')
                                .append(volts_rows))))
                sortTable_temps(volts_table);
            }

            // Only show and sort watts table if data exists
            if ( watts_rows !== ""){
                $('#amps-tab')
                    .append($('<h4>')
                        .append($('<i>')
                            .addClass('fa fa-lightbulb-o'))
                        .append(' '+i18n.t('fan_temps.watts')))
                    .append($('<div style="max-width:370px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody id="watts_table">')
                                .append(watts_rows))))
                sortTable_temps(watts_table);
            }
            
            // Only show and sort smc table if data exists
            if ( smc_rows !== ""){
                $('#smc-tab')
                    .append($('<div style="max-width:575px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody id="smc_table">')
                                .append(smc_rows))))
                sortTable_temps(smc_table);
            }
            
            // Only show and sort temps table if data exists
            if ( temps_rows !== ""){
                $('#temps-tab')
                    .append($('<div style="max-width:370px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody id="temps_table">')
                                .append(temps_rows))))
                sortTable_temps(temps_table);
            }
            
            // Only show fan table if data exists, do not sort it
            if ( fan_rows !== ""){
                $('#fans-tab')
                    .append($('<div style="max-width:370px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody id="fan_table">')
                                .append(fan_rows))))
            }
        } 
	});
    
    
    
    // Escape lower case letters to properly localize them
    function escape_lower_case(in_string){
        var out_string = in_string.replace(/[a-z]/g, function(match) {
            return "_"+match
        });
        return out_string
    }
    
    // Function to sort tables
    function sortTable_temps(table) {
      var rows, switching, i, x, y, shouldSwitch;
      switching = true;
      /* Make a loop that will continue until
      no switching has been done: */
      while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows */
        for (i = 0; i < (rows.length - 1); i++) {
          // Start by saying there should be no switching:
          shouldSwitch = false;
          /* Get the two elements you want to compare,
          one from current row and one from the next: */
          x = rows[i].getElementsByTagName("th")[0];
          y = rows[i + 1].getElementsByTagName("th")[0];
          // Check if the two rows should switch place:
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
        if (shouldSwitch) {
          /* If a switch has been marked, make the switch
          and mark that a switch has been done: */
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
        }
      }
    }
});
</script>
