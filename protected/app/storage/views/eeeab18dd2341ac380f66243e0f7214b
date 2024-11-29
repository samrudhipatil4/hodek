

<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/jquery.min.js"></script><script>
    $.ajax({

        method: 'POST', // Type of response and matches what we said in the route
        url: 'mailTask', // This is the url we gave in the route
        // a JSON object to send back
        success: function(response){
alert(response);
            // What to do if we succeed
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
</script>
