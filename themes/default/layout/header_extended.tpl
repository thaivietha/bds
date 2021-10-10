    <noscript>
        <div class="alert alert-danger">{LANG.nojs}</div>
    </noscript>
    <div class="mobile-menu-bg"></div>
    <div class="mobile-menu-wrap">
        <div class="logo">
            <a title="{SITE_NAME}" href="{THEME_SITE_HREF}"><img src="{LOGO_SRC}" alt="{SITE_NAME}" /></a>
        </div>
        <div class="menu">
            [MENU_SITE_MOBILE]
        </div>
    </div>
    <header>
        <div class="section-header<!-- BEGIN: header_no_home --> header-no-home<!-- END: header_no_home -->">
            <div class="wraper">
                <div class="container">
                    <div id="header" class="row">
                        <div class="logo col-xs-24 col-sm-4 col-md-4">
                            <a title="{SITE_NAME}" href="{THEME_SITE_HREF}"><img src="{LOGO_SRC}" alt="{SITE_NAME}"></a>
                            <!-- BEGIN: site_name_h1 -->
                            <h1>{SITE_NAME}</h1>
                            <!-- END: site_name_h1 -->
                            <!-- BEGIN: site_name_span -->
                            <span class="site_name">{SITE_NAME}</span>
                            <!-- END: site_name_span -->
                            <div class="mobile-menu-toggle-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path stroke="#333" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"></path></svg>
                            </div>
                        </div>
                        <div class="col-xs-24 col-sm-16 col-md-20">
                            <nav class="second-nav hidden-xs" id="menusite">
                                [MENU_SITE]
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- BEGIN: breadcrumbs -->
    <nav class="third-nav">
        <div class="wraper">
            <div class="container">
                <div class="breadcrumbs-wrap">
                    <div class="display">
                        <a class="show-subs-breadcrumbs hidden" href="#" onclick="showSubBreadcrumbs(this, event);"><em class="fa fa-lg fa-angle-right"></em></a>
                        <ul class="breadcrumbs list-none"></ul>
                    </div>
                    <ul class="subs-breadcrumbs"></ul>
                    <ul class="temp-breadcrumbs hidden" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="{THEME_SITE_HREF}" itemprop="item" title="{LANG.Home}"><span itemprop="name">{LANG.Home}</span></a><i class="hidden" itemprop="position" content="1"></i></li>
                        <!-- BEGIN: loop --><li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="{BREADCRUMBS.link}" itemprop="item" title="{BREADCRUMBS.title}"><span class="txt" itemprop="name">{BREADCRUMBS.title}</span></a><i class="hidden" itemprop="position" content="{BREADCRUMBS.position}"></i></li><!-- END: loop -->
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: breadcrumbs -->
    [THEME_ERROR_INFO]