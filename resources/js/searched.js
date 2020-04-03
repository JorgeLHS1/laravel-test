import Echo from "laravel-echo"

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '7b5859a166ce5d77ad8f',
  cluster: 'us2',
  forceTLS: true
});

var channel = Echo.channel('searched-places');
channel.listen('.searched-place', function(data) {
  alert(JSON.stringify(data));
});

// Echo.channel('searched-places')
//     .listen('searched-place', (e) => {
//         console.log(e.query);
//         console.log(e.user);
//         console.log(e);
//     });
