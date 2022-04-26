<header class="page-topbar" id="header">
    <div class="navbar navbar-fixed">
        <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-blue">
            <div class="nav-wrapper">
                <ul class="left">
                    <li>
                        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="<?= base_url() ?>/home"><img src="<?= base_url() ?>/img/cespidh/logo.jpg" alt="materialize logo">
                            <span class="logo-text hide-on-med-and-down"><?= isset(configInfo()['name_app']) ? configInfo()['name_app'] : 'IPLANET' ?></span></a>
                        </h1>
                    </li>
                </ul>
                <ul class="navbar-list right">
                    <li class="hide-on-large-only search-input-wrapper"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search</i></a></li>
                    <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);"
                           data-target="notifications-dropdown"><i class="material-icons">notifications_none
                                <?php if(countNotification() > 0): ?>
                                    <small class="notification-badge"><?= countNotification() ?></small>
                                <?php endif; ?>
                            </i></a></li>
                    <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);"
                           data-target="profile-dropdown"><?= session('users')['name'] ?><span class="avatar-status avatar-online"><img  style="height: 29px !important;"
                                        src="<?= session('user') && session('user')->photo ? base_url().'/assets/upload/images/'.session('user')->photo : base_url().'/assets/img/'.'user.png' ?>" alt="avatar">
                                <i></i>

                            </span>
                            <small style="float: right; padding-left: 10px; font-size: 16px;"
                                   class="new badge"><?= session('user')->username ?></small>

                          </a>
                    </li>
                </ul>
                <ul class="dropdown-content" id="notifications-dropdown">
                    <li>
                        <h6>NOTIFICACIONES</h6>
                    </li>
                    <li class="divider"></li>
                    <?php foreach (notification() as $item): ?>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle <?= $item['color'] ?> small"><?= $item['icon'] ?></span>
                                <?= $item['title'] ?></a>
                            <time class="media-meta grey-text darken-2"><?= $item['body'] ?></time>
                            <br>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00"><?= different($item['created_at']) ?>
                            </time>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <!-- profile-dropdown-->
                <ul class="dropdown-content" id="profile-dropdown">
                    <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/perfile"><i class="material-icons">person_outline</i>
                            Perfil</a></li>
                    <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/about"><i class="material-icons">help_outline</i> About</a></li>
                    <?php  if(session()->get('user')->role_id == 1): ?>
                        <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/config/configurations"><i class="material-icons">settings</i>
                                Configure</a></li>
                        <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/config/roles"><i class="material-icons">face</i>
                                Roles</a></li>
                        <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/config/users"><i class="material-icons">peoples</i>
                                Usuarios</a></li>
                        <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/config/menus"><i class="material-icons">menu</i>
                                Menu</a></li>
                        <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/config/permissions"><i class="material-icons">lock_outline</i>
                                Permisos</a></li>
                        <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/config/notifications"><i class="material-icons">contact_mail</i>
                                Notificar</a></li>

                        <li class="divider"></li>
                    <?php  endif; ?>

                    <li><a class="grey-text text-darken-1" href="<?= base_url() ?>/logout"><i
                                    class="material-icons">keyboard_tab</i> Logout</a></li>
                </ul>
            </div>
        </nav>

        <!-- BEGIN: Horizontal nav start-->
        <nav class="white hide-on-med-and-down" id="horizontal-nav">
            <div class="nav-wrapper">
                <ul class="left hide-on-med-and-down" id="ul-horizontal-nav" data-menu="menu-navigation">
                    <li><a href="<?= base_url() ?>/home"><i class="material-icons">home</i><span>Home</span></a></li>
                    <?php foreach (menu() as $item): ?>
                        <li>
                            <a class="<?= countMenu($item->id) ? 'dropdown-menu':''?> <?= isActive(urlOption($item->id)); ?>"
                            href="<?= countMenu($item->id) ? urlOption() : urlOption($item->id) ?>"
                                data-target="<?= str_replace(' ', '',$item->option) ?>">
                                <i class="material-icons"><?= $item->icon ? $item->icon : 'filter_tilt_shift' ?></i>
                                <span>
                                    <span class="dropdown-title" data-i18n="Templates"><?= $item->option ?></span>
                                    <?php if (countMenu($item->id)): ?>
                                        <i class="material-icons right">keyboard_arrow_down</i>
                                    <?php endif ?>
                                </span>
                            </a>
                            <?php if (countMenu($item->id)): ?>
                                <ul class="dropdown-content dropdown-horizontal-list" id="<?= str_replace(' ', '',$item->option) ?>">
                                    <?php foreach (submenu($item->id) as $key => $submenu): ?>
                                        <li <?= countMenuTercero($submenu->id) > 0 ? 'class="dropdown menu dropdown-submenu"':'' ?> data-menu="dropdown-submenu"><a <?= countMenuTercero($submenu->id) > 0 ? 'class="dropdownSub-menu"':''?> href="<?= countMenuTercero($submenu->id) ? urlOption() : urlOption($submenu->id) ?>" data-target="submenu_<?= $key ?>"><span data-i18n="submenu_<?= $key ?>_<?= $key_algo ?>"><?= $submenu->option ?><?= countMenuTercero($submenu->id) > 0 ? '<i class="material-icons right">chevron_right</i></span>':'' ?></a>
                                            <?php if (countMenuTercero($submenu->id)): ?>
                                                <ul class="dropdown-content dropdown-horizontal-list" id="submenu_<?= $key ?>">
                                                    <?php foreach(submenuTercero($submenu->id) as $tercero): ?>
                                                        <li data-menu=""><a href="<?= urlOption($tercero->id) ?>"><span data-i18n="Invoice List"><?= $tercero->option ?></span></a>
                                                        </li>
                                                    <?php endforeach ?>
                                                </ul>
                                            <?php endif ?>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            <?php endif ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- END: Horizontal nav start-->
        </nav>

    </div>
</header>
