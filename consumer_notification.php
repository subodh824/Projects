<html>
    <title>Notification</title>
    <script type="text/javascript" src="/jquery-1.4.2.min.js"></script>
    <script src="/protobuf.js-6.6.5/dist/protobuf.min.js"></script>
    <body>
        <div>
            <div>Notification for Consumer ID : <?php echo $consumer_id; ?></div>
            <div id="my-notification"></div>
            
        </div>
    </body>
</html>
<script>
   $(document).ready(function() {
      loadNotification();
    });
    
    function loadNotification(next_msg) {
        next_msg = next_msg || 0;
        $url = 'http://localhost/broker/get_notification/' + '<?php echo $consumer_id; ?>' + '/' + next_msg;
        $.ajax({
            url: $url, 
            success: function(result) {
                if (result) {
                  result = JSON.parse(result);
                  $('#my-notification').append('<span>' + ' Timestamp : ' +  result.timestamp +' Message : ' + result.text +'</span><br>');
                  loadNotification(1);
                } else if (next_msg == 0) {
                    $('#my-notification').append('<p> No Notifications !!</p><br>');
                }
            }
        });
    }
</script>