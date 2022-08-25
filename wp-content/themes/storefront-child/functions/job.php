<?php
  // add ajax submit form
function ajax_job_search_javascript() {
  if (is_page('tuyen-dung') || is_page('job')) {
    ?>
        <script type="text/javascript">
          $('#job_filter').submit(function(){
            var filter = $('#job_filter');
            $.ajax({
              url:filter.attr('action'),
              data:filter.serialize(), // form data
              type:filter.attr('method'), // POST
              beforeSend:function(xhr){
                // filter.find('button').text('Processing...'); // changing the button label
              },
              success:function(data){
                // filter.find('button').text('Apply filter'); // changing the button label back
                $('#response').html(data); // insert data
                console.log(data);
              }
            });
            return false;
          });
        </script>
    <?php
  }
}
add_action('wp_footer', 'ajax_job_search_javascript');