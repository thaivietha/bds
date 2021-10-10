<!-- BEGIN: main -->
<div class="viewcat-grid">
	<!-- BEGIN: viewdescription -->
	<div class="viewcat-grid-heading">
		<div class="alert alert-info clearfix">
			<h3>{CONTENT.title}</h3>
			<!-- BEGIN: image -->
			<img alt="{CONTENT.title}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail pull-left imghome" />
			<!-- END: image -->
			<p class="text-justify">{CONTENT.description}</p>
		</div>
	</div>
	<!-- END: viewdescription -->
	<!-- BEGIN: featuredloop -->
	<div class="col-xs-24 col-md-12">
        <article class="item">
            <div class="list-inner">
                <figure class="entry-thumb">
                   <a href="{CONTENT.link}" title="{CONTENT.title}" {CONTENT.target_blank}><img src="{HOMEIMG1}" alt="{HOMEIMGALT1}"></a>
                </figure>
                <div class="col-content">
                    <div class="list-categories"></div>
                    <h3 class="entry-title"><a hhref="{CONTENT.link}" title="{CONTENT.title}" {CONTENT.target_blank}>{CONTENT.title}</a></h3>
                </div>
                <div class="info-bottom">
                	<div class="author">
                        <div class="avatar-img">
                            <img src="{CONTENT.photo}" width="40" height="40" alt="{CONTENT.admin}">
                        </div>
                        <h4 class="author-title">{CONTENT.admin}</h4>
                    </div>
                    <div class="date">
                    	<em class="fa fa-clock-o">&nbsp;</em> {CONTENT.publtime}
                    </div>
                </div>
            </div>
        </article>
    </div>
	<!-- END: featuredloop -->

	<!-- BEGIN: viewcatloop -->
	<div class="col-xs-24 col-md-12">
        <article class="item">
            <div class="list-inner">
                <figure class="entry-thumb">
                   <a href="{CONTENT.link}" title="{CONTENT.title}" {CONTENT.target_blank}><img src="{HOMEIMG1}" alt="{HOMEIMGALT1}"></a>
                </figure>
                <div class="col-content">
                    <div class="list-categories"></div>
                    <h3 class="entry-title"><a hhref="{CONTENT.link}" title="{CONTENT.title}" {CONTENT.target_blank}>{CONTENT.title}</a></h3>
                </div>
                <div class="info-bottom">
                	<div class="author">
                        <div class="avatar-img">
                            <img src="{CONTENT.photo}" width="40" height="40" alt="{CONTENT.admin}">
                        </div>
                        <h4 class="author-title">{CONTENT.admin}</h4>
                    </div>
                    <div class="date">
                    	<em class="fa fa-clock-o">&nbsp;</em> {CONTENT.publtime}
                    </div>
                </div>
            </div>
        </article>
    </div>
	<!-- END: viewcatloop -->
	<div class="clear">&nbsp;</div>

	<!-- BEGIN: generate_page -->
	<div class="text-center">
		{GENERATE_PAGE}
	</div>
	<!-- END: generate_page -->
</div>
<!-- END: main -->