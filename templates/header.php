<nav class="navbar fixed-top navbar-toggleable-md">
  <nav class="navbar-nav mr-auto">
    <a class="navbar-brand" href="<?= esc_url(home_url('/')); ?>" data-toggle="tooltip" data-placement="right" title="Qwota"><span class="sr-only"><?php bloginfo('name'); ?></span>
      
      <!-- LOGO SVG -->
      <svg version="1.1" id="logo-q" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   viewBox="0 0 1280 1024" xml:space="preserve">

    <path d="M709.398,176.034L705.215,7.408l-128.99,180.464L303.04,211.773l-0.007,659.072l137.322-12.014
      c-0.036-0.057-0.066-0.122-0.104-0.179l131.064-11.467L575.504,1016l128.99-180.464l273.185-23.902l0.007-659.072L709.398,176.034
      z M923.482,211.585l-0.007,550.514l-246.837,21.594l-50.842,71.124v-0.008l50.835-71.116l246.844-21.596L923.482,211.585z
       M630.739,780.907l1.323,53.485l40.877-57.177l-40.877,57.18L630.739,780.907z M817.336,227.67l99.371-8.694v0.003l-99.372,8.694
      C817.334,227.672,817.336,227.671,817.336,227.67z M316.584,856.055l0.007-631.869l267.025-23.359L692.676,48.255l3.204,128.962
      l-0.005,0l-3.199-128.963L583.622,200.827l-267.031,23.363L316.584,856.055z M357.24,497.244l0.003-235.935l246.837-21.594
      l50.842-71.124v0.005l-50.835,71.119l-246.844,21.596L357.24,497.244z M370.787,796.85l0.007-523.125l240.677-21.054
      l30.913-43.232l0.992,40.44l171.483-15.003c0.021-0.064,0.045-0.127,0.066-0.191l95.006-8.312l-0.007,523.31l-240.677,21.055
      l-30.913,43.232l-0.992-40.44L370.787,796.85z M964.127,799.222l-267.025,23.359L588.042,975.153l-3.546-142.722l0.007,0
      l3.54,142.723l109.054-152.571l267.031-23.363l0.007-631.865L964.127,799.222z"/>
    <path d="M811.308,554.359c7.199-19.899,10.851-41.145,10.851-63.141c0-27.003-4.777-51.407-14.206-72.538
      c-9.448-21.15-22.695-39.064-39.362-53.243c-16.654-14.162-36.451-24.613-58.848-31.064c-22.331-6.415-46.719-8.525-72.517-6.269
      c-23.76,2.081-47.024,8.35-69.15,18.642c-22.113,10.286-41.956,23.912-58.967,40.494c-17.011,16.601-30.774,36.11-40.904,57.984
      c-10.156,21.944-15.311,45.75-15.311,70.754c0,26.989,4.625,51.603,13.743,73.153c9.118,21.586,22.053,40.106,38.436,55.046
      c16.369,14.95,36.107,26.086,58.649,33.099c16.846,5.244,35.141,7.904,54.368,7.904c6.411,0,13.048-0.294,19.731-0.88
      c17.818-1.558,34.439-4.721,49.406-9.402c14.06-4.393,27.412-10.682,39.726-18.708l25.467,27.915l86.306-20.984l-57.571-53.442
      C794.291,591.945,804.427,573.349,811.308,554.359z M722.951,523.979c-2.097,6.944-5.022,13.554-8.714,19.704l-21.345-20.27
      l-88.635,18.778l53.462,48.341c-6.524,2.329-13.246,3.805-20.055,4.4c-12.234,1.082-23.853-0.292-34.664-4.056
      c-10.798-3.765-20.333-9.521-28.339-17.11c-8.046-7.613-14.503-17.028-19.201-27.988c-4.724-10.94-7.119-23.433-7.119-37.126
      c0-10.785,2.389-21.5,7.1-31.851c4.718-10.438,11.222-19.989,19.327-28.389c8.112-8.396,17.752-15.473,28.656-21.038
      c10.851-5.548,22.576-8.905,34.836-9.981c2.627-0.228,5.22-0.344,7.781-0.344c9.329,0,18.361,1.552,26.843,4.612
      c10.805,3.907,20.267,9.74,28.14,17.329c7.894,7.612,14.219,16.763,18.798,27.204c4.579,10.385,6.894,21.56,6.894,33.216
      C726.716,507.461,725.452,515.725,722.951,523.979z"/>
  
  </svg>
  <!-- / LOGO SVG -->

    </a>
    <?php
    // If it's the Home page then display the 'add' button
    if(is_front_page()) { ?>
      <button class="btn mr-auto quote-form-open-close hidden-sm-down add-quote__open" data-toggle="tooltip" data-placement="right" title="Add a Quote"><span class="sr-only">Add Quote</span> <span class="ti-plus"></span></button>
    <?php } ?>

    <ul class="nav">
      <li><a href="<?php bloginfo('url'); ?>/popular-quotes" data-toggle="tooltip" data-placement="right" title="Popular Quotes" class="nav-link"><span class="sr-only">Popular Quotes</span><span class="ti-crown"></span></a></li>   
    </ul>

    <h2 class="site-description"><span class="ribbon">The Bestest <span class="color">Quotes</span> In Popular Culture</span></h2>

  </nav>  
  <nav class="navbar-nav float-right">
    <?php
    // If it's the Home page then show how many quotes are being shown
    if(is_front_page()) { ?>
      <div class="quote-count hidden-md-down">Qwota has <span class="quote-count__total"><?php $comments_count = wp_count_comments(); echo  $comments_count->approved; ?></span> quotes so far. <button class="btn btn-link quote-form-open-close btn-text">Add more?</button></div>
    <?php } ?>
    <ul class="nav">
      <li><a href="<?php bloginfo('url'); ?>/about-qwota" data-toggle="tooltip" data-placement="left" title="About Qwota"  class="nav-link hidden-sm-down"><span class="sr-only">About Qwota</span><span class="ti-help"></span></a></li>
    </ul>
  </nav>
</nav>
