<?php
$event_to_test = 'PageView';
if(isset($_REQUEST['ett']) && $_REQUEST['ett'] != ''){
  $event_to_test = $_REQUEST['ett'];
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>SPA - Facebook Tracking - Simple Example</title>

  <!-- Facebook Pixel Code -->
  <script>
    !function (f, b, e, v, n, t, s) {
      if (f.fbq) return; n = f.fbq = function () {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
      n.queue = []; t = b.createElement(e); t.async = !0;
      t.src = v; s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1654677854812921');
    fbq.disablePushState = true;
    fbq('track', '<?php echo $event_to_test;?>', {
      eventID: btoa(Date.now().toString())
    });
  </script>
  <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1654677854812921&ev=PageView&noscript=1" />
  </noscript>
  <!-- End Facebook Pixel Code -->

</head>

<body>
  <ul id="menu" class="clearfix">
    <li><a href="link1">Link 1</a></li>
    <li><a href="link2">Link 2</a></li>
    <li><a href="link3">Link 3</a></li>
  </ul>

  <hr />

  <div id="content"></div>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js"></script>
  <script>
    (function ($) {
      var loadContent = function (href) {
        $.ajax(href + ".html", {
          success: function (data) {
            history.pushState({ 'url': href }, 'New URL: ' + href, href);
            $('#content').html(data + new Date());

            //optional - just to demonstrate that additional events can be fired on particular path changes
            var eventname = null;
            switch (href) {
              case 'link1':
                eventname = '<?php echo $event_to_test;?>';
                break;
              case 'link2':
                eventname = 'AddPaymentInfo';
                break;
              case 'link3':
                eventname = 'CompleteRegistration';
                break;
              default:
            }

            fbq('track', eventname, { eventID: btoa(Date.now().toString()) });
            //sending same event after some delay, after 3 secs
            window.setTimeout(function(){
              fbq('track', eventname, { eventID: btoa(Date.now().toString()) });
            },3000);
            

          },
          error: function () {
            console.log('An error occurred');
          }
        });
      };

      var init = function () {
        $('#menu a').click(function (e) {
          e.preventDefault();
          loadContent($(this).attr("href"));
        });

        // ensure back and forward buttons work
        window.onpopstate = function (event) {
          loadContent(location.pathname.split('/').pop());
        };
      };

      $(document).ready(function () {
        init();
      });
    })(jQuery);
  </script>





</body>

</html>
