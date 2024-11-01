'use strict'; 



var scripts = document.getElementsByTagName( "script" ) ;

var currentScriptUrl = ( document.currentScript || scripts[scripts.length] ).src ;

var scriptName = currentScriptUrl.length > 0 ? currentScriptUrl : scripts[scripts.length].baseURI.split( "/" ).pop() ;

var arr = scriptName.split('?');

var params = arr[1];

if ('serviceWorker' in navigator) {


navigator.serviceWorker.register(pushem_data.swpath).then(function(reg) {

navigator.serviceWorker.getRegistration(pushem_data.swpath).then(function(reg) {
        reg.pushManager.getSubscription(reg).then(function(sub) {

            if (sub != null) {

                var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                document.cookie = "emdn_gcm_endpoint="+sub.endpoint+"; path=/; expires="+d;

            }

            var get_settings_line = 'https://pushem.org/api/sources/get_settings/?'+params;

            fetch(get_settings_line).then(function(response) {

                response.json().then(function(data) {

                if (sub == null) {                   

                if (data.source.mode == 'auto') {

                    reg.pushManager.subscribe({

                        userVisibleOnly: true

                    }).then(function(sub) {



                        //SET COOKIE, USE FOR ANONYMOUS

                            var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                            document.cookie = "emdn_gcm_endpoint="+sub.endpoint+"; path=/; expires="+d;

                        //END OF COOKIE

                                    document.getElementById('pushem-notification-https-unsub').innerHTML = data.source.unsubbtn;

                                    document.getElementById('pushem-notification-https-unsub').style.display = 'block';



                                    document.getElementById('pushem-notification-https-msg').innerHTML = data.source.submsg;

                                    document.getElementById('pushem-notification-https-msg').style.display = 'block';

                                    setTimeout(function() { document.getElementById('pushem-notification-https-msg').style.display = 'none' }, 2000);

            

                    var endpoint_line = "https://pushem.org/api/subscribers/add/?"+params+"&sub_endpoint="+sub.endpoint;

            

                    fetch(endpoint_line).then(function(response) {



                    });



                    var httpunsubbtn = document.getElementById('pushem-notification-https-unsub');

                        httpunsubbtn.style.cursor = 'pointer';

                            httpunsubbtn.onclick = function() {

                                reg.pushManager.getSubscription(reg).then(function(sub) {

                                    sub.unsubscribe().then(function(event) {



                                        //SET COOKIE, USE FOR ANONYMOUS

                                            var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                                            var s = "";

                                            document.cookie = "emdn_gcm_endpoint="+s+"; path=/; expires="+d;

                                        //END OF COOKIE

                                    document.getElementById('pushem-notification-https-unsub').style.display = 'none';

                                    document.getElementById('pushem-notification-https-sub').style.display = 'block';



                                    document.getElementById('pushem-widget-https').style.display = 'none';

                                    document.getElementById('pushem-widget-https-bg').style.display = 'none';



                                    document.getElementById('pushem-notification-https-msg').innerHTML = data.source.unsubmsg;

                                    document.getElementById('pushem-notification-https-msg').style.display = 'block';

                                    setTimeout(function() { document.getElementById('pushem-notification-https-msg').style.display = 'none' }, 2000);



                                    var idget_line = "https://pushem.org/api/subscribers/get_by_endpoint/?"+params+"&sub_endpoint="+sub.endpoint;

                                    fetch(idget_line).then(function(response) {

                                        response.json().then(function(data) {                



                                        var idremove_line = "https://pushem.org/api/subscribers/remove/?"+params+"&id="+data.subscriber.id;

                                        fetch(idremove_line).then(function(response) {



                                        });



                                    });

                                    });







                    var httpsubbtn = document.getElementById('pushem-notification-https-sub');

                        httpsubbtn.style.cursor = 'pointer';

                            httpsubbtn.onclick = function() {

                                reg.pushManager.subscribe({

                                    userVisibleOnly: true

                                }).then(function(sub) {



                                    //SET COOKIE, USE FOR ANONYMOUS

                                        var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                                        document.cookie = "emdn_gcm_endpoint="+sub.endpoint+"; path=/; expires="+d;

                                    //END OF COOKIE


                                    document.getElementById('pushem-notification-https-sub').style.display = 'none';

                                    document.getElementById('pushem-notification-https-unsub').style.display = 'block';



                                    document.getElementById('pushem-widget-https').style.display = 'none';

                                    document.getElementById('pushem-widget-https-bg').style.display = 'none';



                                    document.getElementById('pushem-notification-https-msg').innerHTML = data.source.submsg;

                                    document.getElementById('pushem-notification-https-msg').style.display = 'block';

                                    setTimeout(function() { document.getElementById('pushem-notification-https-msg').style.display = 'none' }, 2000);



                                    var endpoint_line = "https://pushem.org/api/subscribers/add/?"+params+"&sub_endpoint="+sub.endpoint;



                                    fetch(endpoint_line).then(function(response) {



                                    });



                                });     

                            };





                                    });

                                });

                            };



                    });

                } else {

                    document.getElementById('pushem-notification-https-sub').innerHTML = data.source.subbtn;

                    document.getElementById('pushem-notification-https-sub').style.display = 'block';



                    var httpsubbtn = document.getElementById('pushem-notification-https-sub');

                        httpsubbtn.style.cursor = 'pointer';

                            httpsubbtn.onclick = function() {

                                reg.pushManager.subscribe({

                                    userVisibleOnly: true

                                }).then(function(sub) {



                                    //SET COOKIE, USE FOR ANONYMOUS

                                        var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                                        document.cookie = "emdn_gcm_endpoint="+sub.endpoint+"; path=/; expires="+d;

                                    //END OF COOKIE

                                    document.getElementById('pushem-notification-https-sub').style.display = 'none';

                                    document.getElementById('pushem-notification-https-unsub').style.display = 'block';



                                    document.getElementById('pushem-widget-https').style.display = 'none';

                                    document.getElementById('pushem-widget-https-bg').style.display = 'none';



                                    document.getElementById('pushem-notification-https-msg').innerHTML = data.source.submsg;

                                    document.getElementById('pushem-notification-https-msg').style.display = 'block';

                                    setTimeout(function() { document.getElementById('pushem-notification-https-msg').style.display = 'none' }, 2000);



                                    var endpoint_line = "https://pushem.org/api/subscribers/add/?"+params+"&sub_endpoint="+sub.endpoint;



                                    fetch(endpoint_line).then(function(response) {



                                    });













                    var httpunsubbtn = document.getElementById('pushem-notification-https-unsub');

                        httpunsubbtn.style.cursor = 'pointer';

                            httpunsubbtn.onclick = function() {

                                reg.pushManager.getSubscription(reg).then(function(sub) {

                                    sub.unsubscribe().then(function(event) {



                                        //SET COOKIE, USE FOR ANONYMOUS

                                            var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                                            var s = "";

                                            document.cookie = "emdn_gcm_endpoint="+s+"; path=/; expires="+d;

                                        //END OF COOKIE

                                    document.getElementById('pushem-notification-https-unsub').style.display = 'none';

                                    document.getElementById('pushem-notification-https-sub').style.display = 'block';



                                    document.getElementById('pushem-widget-https').style.display = 'none';

                                    document.getElementById('pushem-widget-https-bg').style.display = 'none';



                                    document.getElementById('pushem-notification-https-msg').innerHTML = data.source.unsubmsg;

                                    document.getElementById('pushem-notification-https-msg').style.display = 'block';

                                    setTimeout(function() { document.getElementById('pushem-notification-https-msg').style.display = 'none' }, 2000);



                                    var idget_line = "https://pushem.org/api/subscribers/get_by_endpoint/?"+params+"&sub_endpoint="+sub.endpoint;

                                    fetch(idget_line).then(function(response) {

                                        response.json().then(function(data) {                



                                        var idremove_line = "https://pushem.org/api/subscribers/remove/?"+params+"&id="+data.subscriber.id;

                                        fetch(idremove_line).then(function(response) {



                                        });



                                    });

                                    });




                    var httpsubbtn = document.getElementById('pushem-notification-https-sub');

                        httpsubbtn.style.cursor = 'pointer';

                            httpsubbtn.onclick = function() {

                                reg.pushManager.subscribe({

                                    userVisibleOnly: true

                                }).then(function(sub) {



                                    //SET COOKIE, USE FOR ANONYMOUS

                                        var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                                        document.cookie = "emdn_gcm_endpoint="+sub.endpoint+"; path=/; expires="+d;

                                    //END OF COOKIE


                                    document.getElementById('pushem-notification-https-sub').style.display = 'none';

                                    document.getElementById('pushem-notification-https-unsub').style.display = 'block';



                                    document.getElementById('pushem-widget-https').style.display = 'none';

                                    document.getElementById('pushem-widget-https-bg').style.display = 'none';



                                    document.getElementById('pushem-notification-https-msg').innerHTML = data.source.submsg;

                                    document.getElementById('pushem-notification-https-msg').style.display = 'block';

                                    setTimeout(function() { document.getElementById('pushem-notification-https-msg').style.display = 'none' }, 2000);



                                    var endpoint_line = "https://pushem.org/api/subscribers/add/?"+params+"&sub_endpoint="+sub.endpoint;



                                    fetch(endpoint_line).then(function(response) {



                                    });



                                });     

                            };





                                    });

                                });

                            };





















                                });     

                            };

                }



                } else {


                    document.getElementById('pushem-notification-https-unsub').innerHTML = data.source.unsubbtn;

                    document.getElementById('pushem-notification-https-unsub').style.display = 'block';



                    var httpunsubbtn = document.getElementById('pushem-notification-https-unsub');

                        httpunsubbtn.style.cursor = 'pointer';

                            httpunsubbtn.onclick = function() {

                                reg.pushManager.getSubscription(reg).then(function(sub) {

                                    sub.unsubscribe().then(function(event) {



                                    //SET COOKIE, USE FOR ANONYMOUS

                                        var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                                        var s = "";

                                        document.cookie = "emdn_gcm_endpoint="+s+"; path=/; expires="+d;

                                    //END OF COOKIE


                                    document.getElementById('pushem-notification-https-unsub').style.display = 'none';

                                    document.getElementById('pushem-notification-https-sub').style.display = 'block';



                                    document.getElementById('pushem-widget-https').style.display = 'none';

                                    document.getElementById('pushem-widget-https-bg').style.display = 'none';



                                    document.getElementById('pushem-notification-https-msg').innerHTML = data.source.unsubmsg;

                                    document.getElementById('pushem-notification-https-msg').style.display = 'block';

                                    setTimeout(function() { document.getElementById('pushem-notification-https-msg').style.display = 'none' }, 2000);



                                    var idget_line = "https://pushem.org/api/subscribers/get_by_endpoint/?"+params+"&sub_endpoint="+sub.endpoint;


                                    fetch(idget_line).then(function(response) {

                                        response.json().then(function(data) {                



                                        var idremove_line = "https://pushem.org/api/subscribers/remove/?"+params+"&id="+data.subscriber.id;

                                        fetch(idremove_line).then(function(response) {



                                        });



                                    });

                                    });







                    var httpsubbtn = document.getElementById('pushem-notification-https-sub');

                        httpsubbtn.style.cursor = 'pointer';

                            httpsubbtn.onclick = function() {

                                reg.pushManager.subscribe({

                                    userVisibleOnly: true

                                }).then(function(sub) {



                                    //SET COOKIE, USE FOR ANONYMOUS

                                        var d = new Date(new Date().getTime() + 3600 * 1000 * 365);

                                        document.cookie = "emdn_gcm_endpoint="+sub.endpoint+"; path=/; expires="+d;

                                    //END OF COOKIE


                                    document.getElementById('pushem-notification-https-sub').style.display = 'none';

                                    document.getElementById('pushem-notification-https-unsub').style.display = 'block';



                                    document.getElementById('pushem-widget-https').style.display = 'none';

                                    document.getElementById('pushem-widget-https-bg').style.display = 'none';



                                    document.getElementById('pushem-notification-https-msg').innerHTML = data.source.submsg;

                                    document.getElementById('pushem-notification-https-msg').style.display = 'block';

                                    setTimeout(function() { document.getElementById('pushem-notification-https-msg').style.display = 'none' }, 2000);



                                    var endpoint_line = "https://pushem.org/api/subscribers/add/?"+params+"&sub_endpoint="+sub.endpoint;



                                    fetch(endpoint_line).then(function(response) {



                                    });



                                });     

                            };





                                    });

                                });

                            };



                }

            });

            });

        });

    });



}).catch(function(error) {

    console.log(':^(', error);

});



}



