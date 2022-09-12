<div class="m-chat" onclick="toggleChat()">
        <picture>
          <source srcset="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chatbot.webp" type="image/webp"><img class="lazyload" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chatbot.png" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chatbot.png" alt="chatbot" loading="lazy" width="70" height="70">
        </picture>
      </div>
      <div class="m-chat_inner">
        <form id="regForm">
          <div class="m-chat_top">
            <button id="prevBtn" type="button" onclick="nextPrev(-1)"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.6699 1.8699L9.89992 0.099903L-7.73358e-05 9.9999L9.89992 19.8999L11.6699 18.1299L3.53992 9.9999L11.6699 1.8699H11.6699Z" fill="white"/>
</svg>
            </button>
            <p>HỖ TRỢ CHỌN LENS</p>
            <div class="close" onclick="toggleChat()"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.5866 2.24525L15.8828 0.541504L9.12826 7.29609L2.37367 0.541504L0.669922 2.24525L7.42451 8.99984L0.669922 15.7544L2.37367 17.4582L9.12826 10.7036L15.8828 17.4582L17.5866 15.7544L10.832 8.99984L17.5866 2.24525Z" fill="white"/>
</svg>
            </div>
          </div>
          <div class="m-chat_bottom">
            <button id="nextBtn" type="button" onclick="nextPrev(1)">TIẾP TỤC</button>
          </div>
          <div class="tab">
            <p class="tab_ttl center">Chúng tôi có thể giúp gì cho bạn ?</p><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_1.svg" loading="lazy">
            <div class="radiobtn">
              <input id="demand1" type="radio" oninput="this.className = ''" name="demand" value="Tư vấn" checked>
              <label for="demand1">Tư vấn</label>
            </div>
            <div class="radiobtn">
              <input id="demand2" type="radio" oninput="this.className = ''" name="demand" value="Mua hàng">
              <label for="demand2">Mua hàng</label>
            </div>
          </div>
          <div class="tab">
            <p class="tab_ttl center">Bạn cần chúng tôi tư vấn về điều gì ?</p><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_2.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_2.svg" loading="lazy">
            <div class="radiobtn">
              <input id="support" type="radio" oninput="this.className = ''" name="support" value="Tư vấn về kính áp tròng" checked>
              <label for="support">Tư vấn về kính áp tròng</label>
            </div>
            <div class="radiobtn">
              <input id="support2" type="radio" oninput="this.className = ''" name="support" value="Tư vấn khác">
              <label for="support2">Tư vấn khác</label>
            </div>
          </div>
          <div class="tab">
            <p class="tab_ttl center">1. Bạn có tật khúc xạ mắt không?</p><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_3.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_3.svg" loading="lazy">
            <div class="radiobtn">
              <input id="matcam" type="radio" oninput="this.className = ''" name="matcam" value="Không cận" checked>
              <label for="matcam">Không cận</label>
            </div>
            <div class="radiobtn">
              <input id="matcam2" type="radio" oninput="this.className = ''" name="matcam" value="Cận và loạn thị">
              <label for="matcam2">Cận và loạn thị</label>
            </div>
            <div class="radiobtn">
              <input id="matcam3" type="radio" oninput="this.className = ''" name="matcam" value="Cận thị">
              <label for="matcam3">Cận thị</label>
            </div>
          </div>
          <div class="tab">
            <p class="tab_ttl center">2. Bạn cận bao nhiêu độ?</p>
            <label for="mat_trai">Mắt trái:</label>
            <select id="mat_trai" name="mat_trai">
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
            </select>
            <label for="mat_phai">Mắt Phải:</label>
            <select id="mat_phai" name="mat_phai">
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
            </select>
          </div>
          <div class="tab">
            <p class="tab_ttl center">3. Bạn thích tròng lens size  như thế nào?</p><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_3.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_3.svg" loading="lazy">
            <div class="radiobtn">
              <input id="size" type="radio" oninput="this.className = ''" name="size" value="Không cận" checked>
              <label for="size">Size S (Không giãn)</label>
            </div>
            <div class="radiobtn">
              <input id="size2" type="radio" oninput="this.className = ''" name="size" value="Cận và loạn thị">
              <label for="size2">Size M (Giãn nhẹ)</label>
            </div>
          </div>
          <div class="tab">
            <p class="tab_ttl center">4. Bạn sử dụng lens trong dịp nào?</p><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_3.svg" data-src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/chat_3.svg" loading="lazy">
            <div class="radiobtn">
              <input id="forday" type="radio" oninput="this.className = ''" name="forday" value="Không cận" checked>
              <label for="forday">Hàng ngày, đi làm, đi học</label>
            </div>
            <div class="radiobtn">
              <input id="forday2" type="radio" oninput="this.className = ''" name="forday" value="Cận và loạn thị">
              <label for="forday2">Đi chơi, bar, pub</label>
            </div>
          </div>
        </form>
      </div>