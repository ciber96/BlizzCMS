<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $template['title']; ?></title>
    <link rel="icon" type="image/x-icon" href="<?= $template['assets'].'images/favicon.ico'; ?>">
    <link rel="stylesheet" href="<?= $template['assets'].'uikit/css/uikit.min.css'; ?>">
    <link rel="stylesheet" href="<?= $template['assets'].'amaranjs/css/amaran.min.css'; ?>">
    <link rel="stylesheet" href="<?= $template['assets'].'css/default.css'; ?>">
    <script src="<?= $template['assets'].'uikit/js/uikit.min.js'; ?>"></script>
    <script src="<?= $template['assets'].'uikit/js/uikit-icons.min.js'; ?>"></script>
    <script src="<?= $template['assets'].'js/jquery.min.js'; ?>"></script>
    <script src="<?= $template['assets'].'fontawesome/js/all.js'; ?>" defer></script>
    <script src="<?= $template['assets'].'amaranjs/js/jquery.amaran.min.js'; ?>"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script> const whTooltips = {colorLinks: false, iconizeLinks: false, renameLinks: false, dropchance: true}; </script> 
  </head>
  <body>
    <div class="uk-navbar-container uk-navbar-transparent">
      <div class="uk-container">
        <nav class="uk-navbar" uk-navbar>
          <div class="uk-navbar-left">
            <a href="<?= base_url(); ?>" class="uk-navbar-item uk-logo uk-margin-small-right"><?= config_item('website_name'); ?></a>
          </div>
          <div class="uk-navbar-right">
            <ul class="uk-navbar-nav">
              <?php if (!$this->website->isLogged()): ?>
              <li class="uk-visible@m"><a href="<?= base_url('register'); ?>"><i class="fas fa-user-plus"></i>&nbsp;<?= lang('button_register'); ?></a></li>
              <li class="uk-visible@m"><a href="<?= base_url('login'); ?>"><i class="fas fa-sign-in-alt"></i>&nbsp;<?= lang('button_login'); ?></a></li>
              <?php endif; ?>
              <?php if ($this->website->isLogged()): ?>
              <li class="uk-visible@m">
                <a href="#">
                  <?php if($this->base->getUserInfoGeneral($this->session->userdata('id'))->num_rows()): ?>
                  <img class="uk-border-circle" src="<?= base_url('assets/images/profiles/'.$this->website->getNameAvatar($this->website->getImageProfile($this->session->userdata('id')))); ?>" width="30" height="30" alt="Avatar">
                  <?php else: ?>
                  <img class="uk-border-circle" src="<?= base_url('assets/images/profiles/default.png'); ?>" width="30" height="30" alt="Avatar">
                  <?php endif; ?>
                  <span class="uk-text-middle uk-text-bold">&nbsp;<?= $this->session->userdata('nickname'); ?>&nbsp;<i class="fas fa-caret-down"></i></span>
                </a>
                <div class="uk-navbar-dropdown" uk-dropdown="boundary: .uk-container">
                  <ul class="uk-nav uk-navbar-dropdown-nav">
                    <?php if ($this->website->isLogged()): ?>
                    <li><a href="<?= base_url('panel'); ?>"><i class="far fa-user-circle"></i> <?= lang('button_user_panel'); ?></a></li>
                    <?php if($this->website->getIsModerator()): ?>
                    <li><a href="<?= base_url('mod'); ?>"><i class="fas fa-gavel"></i> <?= lang('button_mod_panel'); ?></a></li>
                    <?php endif; ?>
                    <?php if($this->website->getIsAdmin()): ?>
                    <li><a href="<?= base_url('admin'); ?>"><i class="fas fa-cog"></i> <?= lang('button_admin_panel'); ?></a></li>
                    <?php endif; ?>
                    <li><a href="<?= base_url('logout'); ?>"><i class="fas fa-sign-out-alt"></i> <?= lang('button_logout'); ?></a></li>
                    <?php endif; ?>
                  </ul>
                </div>
              </li>
              <li>
                <a href="#"><i class="fas fa-shopping-cart"></i>&nbsp;<span class="uk-badge"><?= $this->cart->total_items() ?></span></a>
                <div class="uk-navbar-dropdown" uk-dropdown="boundary: .uk-container">
                  <div class="blizzcms-cart-dropdown">
                    <?php if($this->cart->total_items() > 0): ?>
                    <p class="uk-text-center uk-margin-small"><?= lang('store_cart_added'); ?> <span class="uk-text-bold"><?= $this->cart->total_items() ?> <?= lang('table_header_items'); ?></span> <?= lang('store_cart_in_your'); ?></p>
                    <a href="<?= base_url('cart'); ?>" class="uk-button uk-button-default uk-button-small uk-width-1-1"><i class="fas fa-eye"></i> <?= lang('button_view_cart'); ?></a>
                    <?php else: ?>
                    <p class="uk-text-center uk-margin-remove"><?= lang('store_cart_no_items'); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
              </li>
              <?php endif; ?>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <div class="uk-navbar-container">
      <div class="uk-container">
        <nav class="uk-navbar" uk-navbar="mode: click">
          <div class="uk-navbar-left">
            <ul class="uk-navbar-nav">
              <?php foreach ($this->base->get_menu() as $menulist): ?>
              <?php if($menulist->main == '2'): ?>
              <li class="uk-visible@m">
                <a href="#">
                  <i class="<?= $menulist->icon ?>"></i>&nbsp;<?= $menulist->name ?>&nbsp;<i class="fas fa-caret-down"></i>
                </a>
                <div class="uk-navbar-dropdown">
                  <ul class="uk-nav uk-navbar-dropdown-nav">
                    <?php foreach ($this->base->get_parent_menu($menulist->id) as $menuchildlist): ?>
                      <li>
                        <?php if($menuchildlist->type == '1'): ?>
                        <a href="<?= base_url($menuchildlist->url); ?>">
                          <i class="<?= $menuchildlist->icon ?>"></i>&nbsp;<?= $menuchildlist->name ?>
                        </a>
                        <?php elseif($menuchildlist->type == '2'): ?>
                        <a target="_blank" href="<?= $menuchildlist->url ?>">
                          <i class="<?= $menuchildlist->icon ?>"></i>&nbsp;<?= $menuchildlist->name ?>
                        </a>
                        <?php endif; ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </li>
              <?php elseif($menulist->main == '1' && $menulist->child == '0'): ?>
              <li class="uk-visible@m">
                <?php if($menulist->type == '1'): ?>
                <a href="<?= base_url($menulist->url); ?>">
                  <i class="<?= $menulist->icon ?>"></i>&nbsp;<?= $menulist->name ?>
                </a>
                <?php elseif($menulist->type == '2'): ?>
                <a target="_blank" href="<?= $menulist->url ?>">
                  <i class="<?= $menulist->icon ?>"></i>&nbsp;<?= $menulist->name ?>
                </a>
                <?php endif; ?>
              </li>
              <?php endif; ?>
              <?php endforeach; ?>
            </ul>
            <a class="uk-navbar-toggle uk-hidden@m" uk-navbar-toggle-icon href="#mobile" uk-toggle></a>
          </div>
          <div class="uk-navbar-right">
            <?php if ($this->website->isLogged()): ?>
            <div class="uk-navbar-item">
              <ul class="uk-subnav uk-subnav-divider subnav-points">
                <li><span uk-tooltip="title:<?=lang('panel_dp'); ?>;pos: bottom"><i class="dp-icon"></i></span> <?= $this->base->getCharDPTotal($this->session->userdata('id')); ?></li>
                <li><span uk-tooltip="title:<?=lang('panel_vp'); ?>;pos: bottom"><i class="vp-icon"></i></span> <?= $this->base->getCharVPTotal($this->session->userdata('id')); ?></li>
              </ul>
            </div>
            <?php endif; ?>
          </div>
        </nav>
        <div id="mobile" data-uk-offcanvas="flip: true">
          <div class="uk-offcanvas-bar">
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <div class="uk-panel">
              <p class="uk-logo uk-text-center uk-margin-small"><?= config_item('website_name'); ?></p>
              <?php if ($this->website->isLogged()): ?>
              <div class="uk-padding-small uk-padding-remove-vertical uk-margin-small uk-text-center">
                <?php if($this->base->getUserInfoGeneral($this->session->userdata('id'))->num_rows()): ?>
                <img class="uk-border-circle" src="<?= base_url('assets/images/profiles/'.$this->website->getNameAvatar($this->website->getImageProfile($this->session->userdata('id')))); ?>" width="36" height="36" alt="Avatar">
                <?php else: ?>
                <img class="uk-border-circle" src="<?= base_url('assets/images/profiles/default.png'); ?>" width="36" height="36" alt="Avatar">
                <?php endif; ?>
                <span class="uk-label"><?= $this->session->userdata('nickname'); ?></span>
              </div>
              <?php endif; ?>
              <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
                <?php if (!$this->website->isLogged()): ?>
                <li><a href="<?= base_url('register'); ?>"><i class="fas fa-user-plus"></i> <?= lang('button_register'); ?></a></li>
                <li><a href="<?= base_url('login'); ?>"><i class="fas fa-sign-in-alt"></i> <?= lang('button_login'); ?></a></li>
                <?php endif; ?>
                <?php if ($this->website->isLogged()): ?>
                <li><a href="<?= base_url('panel'); ?>"><i class="far fa-user-circle"></i> <?= lang('button_user_panel'); ?></a></li>
                <?php if($this->website->getIsAdmin()): ?>
                <li><a href="<?= base_url('admin'); ?>"><i class="fas fa-cog"></i> <?= lang('button_admin_panel'); ?></a></li>
                <?php endif; ?>
                <li><a href="<?= base_url('logout'); ?>"><i class="fas fa-sign-out-alt"></i> <?= lang('button_logout'); ?></a></li>
                <?php endif; ?>
                <?php foreach ($this->base->get_menu() as $menulist): ?>
                <?php if($menulist->main == '2'): ?>
                <li class="uk-parent">
                  <a href="#">
                    <i class="<?= $menulist->icon ?>"></i>&nbsp;<?= $menulist->name ?>
                  </a>
                  <ul class="uk-nav-sub">
                    <?php foreach ($this->base->get_parent_menu($menulist->id) as $menuchildlist): ?>
                    <li>
                      <?php if($menuchildlist->type == '1'): ?>
                      <a href="<?= base_url($menuchildlist->url); ?>">
                        <i class="<?= $menuchildlist->icon ?>"></i>&nbsp;<?= $menuchildlist->name ?>
                      </a>
                      <?php elseif($menuchildlist->type == '2'): ?>
                      <a target="_blank" href="<?= $menuchildlist->url ?>">
                        <i class="<?= $menuchildlist->icon ?>"></i>&nbsp;<?= $menuchildlist->name ?>
                      </a>
                      <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </li>
                <?php elseif($menulist->main == '1' && $menulist->child == '0'): ?>
                <li>
                  <?php if($menulist->type == '1'): ?>
                  <a href="<?= base_url($menulist->url); ?>">
                    <i class="<?= $menulist->icon ?>"></i>&nbsp;<?= $menulist->name ?>
                  </a>
                  <?php elseif($menulist->type == '2'): ?>
                  <a target="_blank" href="<?= $menulist->url ?>">
                    <i class="<?= $menulist->icon ?>"></i>&nbsp;<?= $menulist->name ?>
                  </a>
                  <?php endif; ?>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?= $template['body']; ?>

    <section class="uk-section uk-section-xsmall">
      <div class="uk-container">
        <div class="uk-text-center">
          <a target="_blank" href="<?= config_item('social_facebook'); ?>" class="uk-icon-button uk-margin-small-right"><i class="fab fa-facebook-f"></i></a>
          <a target="_blank" href="<?= config_item('social_twitter'); ?>" class="uk-icon-button uk-margin-small-right"><i class="fab fa-twitter"></i></a>
          <a target="_blank" href="<?= config_item('social_youtube'); ?>" class="uk-icon-button"><i class="fab fa-youtube"></i></a>
        </div>
        <p class="uk-text-center uk-margin-small">Copyright <i class="far fa-copyright"></i> <?= date('Y'); ?> <span class="uk-text-bold"><?= config_item('website_name'); ?></span>. <?= lang('footer_rights'); ?></p>
        <p class="uk-text-small uk-margin-small uk-text-center">World of Warcraft® and Blizzard Entertainment® are all trademarks or registered trademarks of Blizzard Entertainment in the United States and/or other countries. These terms and all related materials, logos, and images are copyright © Blizzard Entertainment. This site is in no way associated with or endorsed by Blizzard Entertainment®.</p>
        <p class="uk-h6 uk-text-bold uk-text-uppercase uk-margin-small uk-text-center">Proudly powered by <a target="_blank" href="https://wow-cms.com">BlizzCMS</a></p>
      </div>
    </section>
  </body>
</html>
