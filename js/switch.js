// APP Name: IOT Relay Controller
// Author: EtaNetwork(Daud)
//File:switch.js
// Website: http://eta-network.com/

    function toggle(r_id){
        // var $realpath = window.location.pathname.match(/^(\/[^\/]*){1}/)[0]
        // alert($realpath);
        const {protocol, hostname, port } = window.location
        let $url = `${protocol}//${hostname}`
        $url = port?`${$url}:${port}`:$url
        $.ajax({
            type: "POST",cache: false,url: $url +"/switching.php",
            data: "relay_id="+r_id,
            //dataType:"json",
            // success: function(data) {alert(data);},
            // success: function(data, text) {alert(data)},
            error: function(request, status, error) {alert(request.responseText)},
            // error: function(err) {alert(err)}
        })
    }

    $(document).ready(function(){
      var options={onColor:'success', offColor:'default', animate:false}
      $("[name='Appliance_1']").bootstrapSwitch(options)
      $("[name='Appliance_2']").bootstrapSwitch(options)
      $("[name='Appliance_3']").bootstrapSwitch(options)
      $("[name='Appliance_4']").bootstrapSwitch(options)
    });