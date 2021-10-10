<!-- BEGIN: main -->
<div class="groups-news row">
    <!-- BEGIN: loop -->
    <div class="col-xs-24 col-md-8">
        <article class="item">
            <div class="list-inner">
                <figure class="entry-thumb">
                   <a href="{ROW.link}" title="{ROW.title}" {ROW.target_blank} ><img src="{ROW.thumb}" alt="{ROW.title}"></a>
                </figure>
                <div class="col-content">
                    <div class="list-categories"></div>
                    <h3 class="entry-title"><a href="{ROW.link}" title="{ROW.title}" {ROW.target_blank} >{ROW.title}</a></h3>
                </div>
                <div class="info-bottom">
                    <div class="author">
                        <div class="avatar-img">
                            <img src="{ROW.photo}" width="40" height="40" alt="{ROW.admin}">
                        </div>
                        <h4 class="author-title">{ROW.admin}</h4>
                    </div>
                    <div class="date">
                        <em class="fa fa-clock-o">&nbsp;</em> {ROW.publtime}
                    </div>
                </div>
            </div>
        </article>
    </div>
    <!-- END: loop -->
</div>
<!-- END: main -->
