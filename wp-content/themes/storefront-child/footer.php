<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>
 <?php if(is_product_category() || is_search())  : ?>
  <div class="l-container mt-2">
    <?php require_once( get_stylesheet_directory() . '/module/footer_info.php' ); ?>
  </div>
<?php endif; ?>
<?php require( get_stylesheet_directory() . '/module/chat_bot.php' ); ?>
	<footer class="c-footer">
      <?php if(!wp_is_mobile()) : ?>
      <div class="l-container c-footer_top">
        <dl>
          <dd class="c-footer_logo"><a href="#">
              <picture>
                <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.webp" type="image/webp">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.png" alt="caras" loading="lazy" width="161" height="46">
              </picture></a>
            <dd class="c-footer_copy">© Copyright 2022 CARAS LENS. All rights reserved.</dd>
          </dd>
          <dt class="c-footer_fw"><?php _e('FOLLOW AT', 'storefront') ?>
            <dl class="c-footer_social c-footer_certificates">
              <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" width="39" height="39"></dd>
              <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/insta.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/insta.png" width="39" height="39"></dd>
              <dd><img class="lazyload" loading="lazy" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png" width="39" height="39"></dd>
            </dl>
          </dt>
        </dl>
        <dl>
          <dt><?php _e('CÔNG TY CỔ PHẦN THƯƠNG MẠI CALEN', 'storefront') ?></dt>
          <dd><strong><?php _e('Business registration certificate:', 'storefront') ?>&nbsp;</strong><?php _e('0317006667', 'storefront') ?></dd>
          <dd><strong>Email:&nbsp;</strong><a href="mailto:support@caraslens.vn">support@caraslens.vn</a></dd>
          <dd><strong><?php _e('Import license No. 17830NK/BYT-TB-CT granted by the Ministry of Health', 'storefront') ?></strong></dd>
          <dd><strong>Hotline:&nbsp;</strong><a href="tel:1900636304">1900 63 63 04</a></dd>
        </dl>
        <dl>
          <dt><?php _e('CUSTOMER SUPPORT', 'storefront') ?>
            <dl>
              <dd><a href="/chinh-sach-bao-hanh/"><?php _e('Warranty Policy', 'storefront') ?></a></dd>
              <dd><a href="/chinh-sach-giao-nhan/"><?php _e('Delivery policy', 'storefront') ?></a></dd>
              <dd><a href="/huong-dan-mua-hang/"><?php _e('Shopping guide', 'storefront') ?></a></dd>
              <dd><a href="/hoi-dap/"><?php _e('FAQs', 'storefront') ?></a></dd>
              <dd><a href="/<?php echo apply_filters( 'wpml_get_translated_slug', 'showroom', 'page' , 'ICL_LANGUAGE_CODE');?>"><?php _e('CONTACT US', 'storefront') ?></a></dd>
            </dl>
          </dt>
          <dt>MEDICAL CERTIFICATES
            <dl class="c-footer_social c-footer_certificates">
              <dd>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.png" alt="byt" loading="lazy" width="47" height="47">
                </picture>
              </dd>
              <dd>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.png" alt="fda" loading="lazy" width="56" height="22">
                </picture>
              </dd>
              <dd>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.png" alt="iso" loading="lazy" width="50" height="49">
                </picture>
              </dd>
            </dl>
          </dt>
        </dl>
        <dl>
          <dt><?php _e('CARAS AFFILIATE PROGRAM', 'storefront') ?>
            <dl>
              <dd><a href="#">Affiliate program</a></dd>
            </dl>
          </dt>
          <dt><a href="https://caras.talent.vn/" rel="nofollow" target="_blank">CƠ HỘI VIỆC LÀM TẠI CARASE</a></dt>
          <dt>PAYMENT ACCEPT
            <dl class="c-footer_social c-footer_certificates">
              <dd>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.png" alt="visa" loading="lazy" width="71" height="23">
                </picture>
              </dd>
              <dd>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.png" alt="jcb" loading="lazy" width="45" height="32">
                </picture>
              </dd>
              <dd>
                <picture>
                  <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.png" alt="mastercard" loading="lazy" width="56" height="33.5">
                </picture>
              </dd>
            </dl>
          </dt>
        </dl>
      </div>
      <div class="l-container c-footer_bottom">
        <dl>
          <dd>
            <picture>
              <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bct.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bct.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bct.png" alt="Bct" loading="lazy" width="101" height="86">
            </picture>
          </dd>
        </dl>
        <dl>
          <dd>
            <picture>
              <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bsi.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bsi.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bsi.png" alt="Bsi" loading="lazy" width="155" height="75.5">
            </picture>
          </dd>
        </dl>
        <dl>
          <dd>
            <picture>
              <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dmca.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dmca.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dmca.png" alt="dmca" loading="lazy" width="193" height="61">
            </picture>
          </dd>
        </dl>
        <dl>
          <dd>
            <picture>
              <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chong-hang-gia.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chong-hang-gia.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chong-hang-gia.png" alt="chong hang gia" loading="lazy" width="124" height="123">
            </picture>
          </dd>
        </dl>
      </div>
      <?php else : ?>
        <div class="l-container c-footer_top">
          <div class="m-support"><strong><?php _e('SUPPORT', 'storefront') ?></strong>
            <div class="m-support_inner">
              <ul class="m-support_list">
                <li><a href="/chinh-sach-bao-hanh/"><?php _e('Warranty Policy', 'storefront') ?></a></li>
                <li><a href="/chinh-sach-giao-nhan/"><?php _e('Delivery policy', 'storefront') ?></a></li>
                <li><a href="/huong-dan-mua-hang/"><?php _e('Shopping guide', 'storefront') ?></a></li>
              </ul>
              <ul class="m-support_list">
                <li><a href="#">Affiliate</a></li>
                <li><a href="/hoi-dap/">Q&A</a></li>
                <li><a href="/showroom/"><?php _e('CONTACT US', 'storefront') ?></a></li>
                <li><a href="https://caras.talent.vn/" rel="nofollow" target="_blank"><?php _e('JOB OPPORTUNITIES IN', 'storefront') ?></a></li>
              </ul>
            </div>
          </div>
          <div class="m-med">
            <div class="m-med_block"><strong>MEDICAL CERTIFICATES</strong>
              <ul class="l-icon">
                <li>
                  <a href="#">
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.png" alt="byt" loading="lazy" width="47" height="47">
                    </picture>
                  </a>
                </li>
                <li>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/fda.png" alt="fda" loading="lazy" width="56" height="22">
                  </picture>
                </li>
                <li>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/iso.png" alt="iso" loading="lazy" width="50" height="49">
                  </picture>
                </li>
              </ul>
            </div>
            <div class="m-med_block"><strong>PAYMENT ACCEPT</strong>
              <ul class="l-icon">
                <li>
                    <picture>
                      <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/visa.png" alt="visa" loading="lazy" width="71" height="23">
                    </picture>
                </li>
                <li>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/jcb.png" alt="jcb" loading="lazy" width="45" height="32">
                  </picture>
                </li>
                <li>
                  <picture>
                    <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/mastercard.png" alt="mastercard" loading="lazy" width="56" height="33.5">
                  </picture>
                </li>
              </ul>
            </div>
            <div class="m-med_block"><strong>SOCIAL MEDIA</strong>
              <ul class="l-icon">
                <li>
                  <a href="#">
                    <img class="lazyload" loading="lazy" alt="facebook" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/facebook.png" width="39" height="39">
                  </a>
                </li>
                <li>
                  <a href="#">
                    <img class="lazyload" loading="lazy" alt="insta" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/insta.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/insta.png"  width="39" height="39">
                  </a>
                </li>
                <li>
                  <a href="#">
                    <img class="lazyload" loading="lazy" alt="youtube" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png" width="39" height="39">
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="m-info-company">
            <div class="m-info-company_information"><strong><?php _e('Trade Joint Stock Company', 'storefront') ?> CALEN</strong>
              <p class="txt">(Calen Trading Joint Stock Company)</p>
              <p class="txt"><?php _e('619 Nguyen Dinh Chieu, Ward 2, Ward 3, HCMC', 'storefront') ?></p>
              <p class="txt"><?php _e('Tax code', 'storefront') ?>: 0317006667</p>
              <p class="txt">Hotline: 1900 636304</p>
              <p class="txt"><?php _e('PUBLICATION & IMPORT LICENSE', 'storefront') ?>: 220002087/PCBB-HCM</p>
            </div>
            <ul class="m-info-company_cert">
              <li>
                <picture>
                  <img class="lazyload" loading="lazy" alt="bộ y tế" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/byt.png" width="48" height="48">
                </picture>
              </li>
              <li>
                <picture>
                  <img class="lazyload" loading="lazy" alt='bsi' data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bsi.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/bsi.png" width="88" height="44">
                </picture>
              </li>
              <li>
                <picture>
                  <img class="lazyload" loading="lazy" alt="dmca" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dmca.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/dmca.png" width="88" height="28">
                </picture>
              </li>
              <li>
                <picture>
                  <img class="lazyload" loading="lazy" alt="chong hang gia" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chong-hang-gia.png" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chong-hang-gia.png" width="88" height="88">
                </picture>
              </li>
            </ul>
          </div>
          <div class="m-copy-right">
            <div class="logo">
              <picture>
                <img data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.png"  src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/caras_logo_white.png" alt="CARAS LENS" loading="lazy">
              </picture>
            </div><small class="copyright">&copy;Copyright 2022 CARAS LENS. All rights reserved.</small>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </footer>
    <?php require( get_stylesheet_directory() . '/module/loadjs.php' ); ?>
		<?php wp_footer(); ?>
    <div class="overlay" id="overlay"></div>
    <div class="modal" id="modal">
      <div class="modal_inner">
        <div class="modal_content" >
            <svg width="105" height="105" viewBox="0 0 105 105" xmlns="http://www.w3.org/2000/svg" fill="#f78da7">
                <circle cx="12.5" cy="12.5" r="12.5">
                    <animate attributeName="fill-opacity"
                    begin="0s" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
                <circle cx="12.5" cy="52.5" r="12.5" fill-opacity=".5">
                    <animate attributeName="fill-opacity"
                    begin="100ms" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
                <circle cx="52.5" cy="12.5" r="12.5">
                    <animate attributeName="fill-opacity"
                    begin="300ms" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
                <circle cx="52.5" cy="52.5" r="12.5">
                    <animate attributeName="fill-opacity"
                    begin="600ms" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
                <circle cx="92.5" cy="12.5" r="12.5">
                    <animate attributeName="fill-opacity"
                    begin="800ms" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
                <circle cx="92.5" cy="52.5" r="12.5">
                    <animate attributeName="fill-opacity"
                    begin="400ms" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
                <circle cx="12.5" cy="92.5" r="12.5">
                    <animate attributeName="fill-opacity"
                    begin="700ms" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
                <circle cx="52.5" cy="92.5" r="12.5">
                    <animate attributeName="fill-opacity"
                    begin="500ms" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
                <circle cx="92.5" cy="92.5" r="12.5">
                    <animate attributeName="fill-opacity"
                    begin="200ms" dur="1s"
                    values="1;.2;1" calcMode="linear"
                    repeatCount="indefinite" />
                </circle>
            </svg>
        </div>
      </div>
    </div>
  </body>
</html>
