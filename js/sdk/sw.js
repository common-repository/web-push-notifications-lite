'use strict';

//console.log('Started', self);
self.addEventListener('install', function(event) {
  self.skipWaiting();
  console.log('Installed', event);
});
self.addEventListener('activate', function(event) {
  console.log('Activated', event);
});

registration.pushManager.getSubscription().then(function(subscription) {
  console.log("got subscription id: ", subscription.endpoint);

  if (subscription) {


var api_url = 'https://pushem.org/sdk/https/query.json.php';

        var str = registration.scope;
        var arr = str.split('/');
        //console.log(':^)',arr[2]);

var endpoint_line = api_url+'?sub='+subscription.endpoint+'&domain='+arr[2];
console.log(endpoint_line);

self.addEventListener('push', function(event) {
event.waitUntil(fetch(endpoint_line).then(function(response) {

  console.log(response);
      if (response.status !== 200) {
        console.log('Looks like there was a problem. Status Code: ' + response.status);  
        throw new Error();  
      }

      // Examine the text in the response  
      return response.json().then(function(data) {
        console.log(data);
        
        if (!data.error || data.notification) {
        
        console.log(data.notification.title);
        
        var title = data.notification.title;  
        var message = data.notification.body;
        var icon = data.notification.icon;
        var link = data.notification.link; //COMES WITH NOTIFICATION ID + SUBSCRIBER_ID + UTM
        var audio = data.notification.audio;
        var tag = data.notification.tag;
        var subid = data.notification.sub_id;
        var id = data.notification.id;
        if (title != 'undefined' && title != '') {
        return self.registration.showNotification(title, {  
          body: message,
          icon: icon,
          tag: tag,
          audio: audio,
          data : {
            link : link,
            subid : subid,
            id : id
            }
        });
        }
    	}

      });
    })
);

});


self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  //console.log(event);
  //CALL CLICK COUNTER + NOTIFICATION ID + SUBSCRIBER_ID
  var url = event.notification.data.link;
  var subid = event.notification.data.subid;
  var id = event.notification.data.id;

  event.waitUntil(
    clients.matchAll({
      type: 'window'
    })
    .then(function(windowClients) {
      //console.log('WindowClients', windowClients);
      for (var i = 0; i < windowClients.length; i++) {
        var client = windowClients[i];
        //console.log('WindowClient', client);
        if (client.url === url && 'focus' in client) {
          var focusclickurl = 'https://pushem.org/api/stats/click/register/?id='+id+'&sub_id='+subid;
          //console.log(focusclickurl);
          fetch(focusclickurl).then(function(response) { });

          return client.focus();
        }
      }
      if (clients.openWindow) {
        //CALL OPEN SITE COUNTER + NOTIFICATION ID + SUBSCRIBER_ID (Encode TOKEN??)
        var clickurl = 'https://pushem.org/api/stats/click/register/?id='+id+'&sub_id='+subid;
        //console.log(clickurl);
        fetch(clickurl).then(function(response) { });

        return clients.openWindow(url);
      }
    })
  );
});


}

});

