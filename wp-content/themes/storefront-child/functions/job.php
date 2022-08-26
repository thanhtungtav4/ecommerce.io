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
                //filter.find('.search-submit').text('Processing...'); // changing the button label
              },
              success:function(data){
                //document.getElementById('#response_job_box').style.display = "block";
                // filter.find('button').text('Apply filter'); // changing the button label back
                $('#response').html(data); // insert data

              }
            });
            return false;
          });
        </script>
    <?php
  }
}
add_action('wp_footer', 'ajax_job_search_javascript');

add_action('wp_ajax_filter_job_action', 'filter_job_action');
add_action('wp_ajax_nopriv_filter_job_action', 'filter_job_action');

function filter_job_action(){
    $args = array(
      'post_type' => 'tuyen_dung', // we will sort posts by date
      's' => $_POST['title'],
      'post_status' => 'publish',
      'orderby'     => 'title',
      'order'       => 'ASC',
      'suppress_filters' => 1,
    );
    if( !empty($_POST['location'])  || !empty($_POST['jobname'])){
      $args['tax_query'] = array(
        'relation' => 'OR',
        array(
          'taxonomy' => 'location',
          'field' => 'slug',
          'terms' => $_POST['location']
        ),
        array(
          'taxonomy' => 'linh_vuc',
          'field' => 'slug',
          'terms' => $_POST['jobname']
        )
      );
    }
    $query = new WP_Query( $args );

    if( $query->have_posts() ) :
      while( $query->have_posts() ): $query->the_post();
        //var_dump($query->post);
        include( get_stylesheet_directory() . '/module/item_job.php' );
      endwhile;
      wp_reset_postdata();
    else :
      echo 'No Job found';
    endif;
	  die();
}