<div class="modal_top">
    <h3> <?php the_title() ?> </h3>
    <ol class="modal_img">
      <li class="brown">
        <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lavier-brown-lens-50x50.png" alt="Logo" loading="lazy" width="50" height="50">
        <p>brown</p>
      </li>
      <li class="brown">
        <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lavier-brown-lens-50x50.png" alt="Logo" loading="lazy" width="50" height="50">
        <p>brown</p>
      </li>
      <li class="brown">
        <img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/category_list.jpg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/lavier-brown-lens-50x50.png" alt="Logo" loading="lazy" width="50" height="50">
        <p>brown</p>
      </li>
    </ol>
  </div>
  <div class="modal_content">
    <table>
      <tbody>
        <tr>
          <th>HSD: </th>
          <td> 3 tháng</td>
        </tr>
        <?php if(get_field('time_deo', get_the_ID())) : ?>
          <tr>
            <th>Đeo:</th>
            <td><?php the_field('time_deo', get_the_ID()) ?></td>
          </tr>         
       <?php endif ;?>
        <tr>
          <th>Size:</th>
          <td>S</td>
        </tr>
        <?php if(get_field('gdia', get_the_ID())) : ?>
          <tr>
            <th>GDIA:</th>
            <td><?php the_field('gdia', get_the_ID()) ?></td>
          </tr>         
       <?php endif ;?>
       <?php if(get_field('dia', get_the_ID())) : ?>
          <tr>
            <th>DIA:</th>
            <td><?php the_field('dia', get_the_ID()) ?></td>
          </tr>         
       <?php endif ;?>
        <tr>
          <th>Độ Cận:</th>
          <td>0 - 10 độ </td>
        </tr>
        <tr>
          <th>Phù hợp:</th>
          <td>
            <table>
              <tbody>
                <tr>
                  <td>Đi học</td>
                  <td>Đi Làm</td>
                  <td>Đi Chơi</td>
                </tr>
                <tr>
                  <td>Đi học</td>
                  <td>Đi Làm</td>
                  <td>Đi Chơi</td>
                </tr>
                <tr>
                  <td>Đi học</td>
                  <td>Đi Làm</td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal_bottom">
    <button class="modal-close-btn" id="close-btn" onclick="closeQuickView()">
      <svg fill="#2B2929" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="40px" height="40px">
        <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z"></path>
      </svg>
    </button>
    <div class="modal_cart">
      <p class="price">
        <?php echo wc_get_product( get_the_ID() )->get_price_html(); ?>
      </p>
      <a class="btn" href="<?php the_permalink() ?>">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 20 20" version="1.1">
          <g id="surface1">
          <path style=" stroke:none;fill-rule:nonzero;fill:#ffff;fill-opacity:1;" d="M 7.417969 8.789062 C 7.761719 8.789062 8.042969 8.507812 8.042969 8.164062 L 8.042969 5.726562 C 8.042969 4.636719 8.929688 3.75 10.019531 3.75 C 11.109375 3.75 11.996094 4.636719 11.996094 5.726562 L 11.996094 8.164062 C 11.996094 8.507812 12.273438 8.789062 12.621094 8.789062 C 12.964844 8.789062 13.246094 8.507812 13.246094 8.164062 L 13.246094 5.726562 C 13.246094 3.949219 11.796875 2.5 10.019531 2.5 C 8.238281 2.5 6.792969 3.949219 6.792969 5.726562 L 6.792969 8.164062 C 6.792969 8.507812 7.070312 8.789062 7.417969 8.789062 Z M 7.417969 8.789062 "></path>
          <path style=" stroke:none;fill-rule:nonzero;fill:#ffff;fill-opacity:1;" d="M 17.1875 7.382812 L 13.871094 7.382812 L 13.871094 8.164062 C 13.871094 8.851562 13.308594 9.414062 12.621094 9.414062 C 11.929688 9.414062 11.371094 8.851562 11.371094 8.164062 L 11.371094 7.382812 L 8.667969 7.382812 L 8.667969 8.164062 C 8.667969 8.851562 8.105469 9.414062 7.417969 9.414062 C 6.726562 9.414062 6.167969 8.851562 6.167969 8.164062 L 6.167969 7.382812 L 2.8125 7.382812 C 2.640625 7.382812 2.535156 7.519531 2.574219 7.6875 L 4.761719 16.59375 C 4.894531 17.09375 5.421875 17.5 5.9375 17.5 L 14.0625 17.5 C 14.582031 17.5 15.105469 17.09375 15.238281 16.59375 L 17.425781 7.6875 C 17.464844 7.519531 17.359375 7.382812 17.1875 7.382812 Z M 17.1875 7.382812 "></path>
          </g>
        </svg>
      </a>
    </div>
  </div>