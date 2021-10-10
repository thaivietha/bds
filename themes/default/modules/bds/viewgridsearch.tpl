<!-- BEGIN: main -->
<div class="row">
<div class="viewgrid">
	<!-- BEGIN: loop -->
	<div class="col-xs-24 col-sm-12 col-md-8">
		<div class="property-item">
			<div class="property-thumb">
				<a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.thumb}" alt="{ROW.title}" ></a>
				<span class="thumb-item-label">
					<!-- BEGIN: price -->
					<span class="price">{PRICE.price}</span>
					<!-- END: price -->
					<!-- BEGIN: contact -->
					<span class="price">{LANG.contact}</span>
					<!-- END: contact -->
				</span>
			</div>
			<div class="property-information">
				<div class="property-type"><a href="{ROW.link_cat}" title="{ROW.catid}">{ROW.catid}</a></div>
				<h3 class="property-title"><a href="{ROW.link}" title="{ROW.title}">{ROW.title}</a></h3>
				<div class="property-location">
					<i class="flaticon-maps-and-flags"></i> {ROW.address}
				</div>
				<ul class="property-meta">
					<li><svg viewBox="0 0 90 50" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M16 18C16 13.6 19.6 10 24 10C28.4 10 32 13.6 32 18C32 22.4 28.4 26 24 26C19.6 26 16 22.4 16 18ZM88 30H12V2C12 0.9 11.1 0 10 0H2C0.9 0 0 0.9 0 2V50H12V42H78V50H80H82H86H88H90V32C90 30.9 89.1 30 88 30ZM74 12H38C36.9 12 36 12.9 36 14V26H88C88 18.3 81.7 12 74 12Z" fill="black"></path>
						</svg> Phòng ngủ: {ROW.bed_room}
					</li>
					<li>
						<svg viewBox="0 0 56 59" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2 37C2.00973 43.673 5.92011 49.724 12 52.4742V58C12.0016 58.5516 12.4484 58.9984 13 59H15C15.5516 58.9984 15.9984 58.5516 16 58V53.7186C16.9897 53.9011 17.9936 53.9953 19 54H37C38.0064 53.9953 39.0103 53.9011 40 53.7186V58C40.0016 58.5516 40.4484 58.9984 41 59H43C43.5516 58.9984 43.9984 58.5516 44 58V52.4742C50.0799 49.724 53.9903 43.673 54 37V31H2V37Z" fill="black"></path>
						<path d="M55 27H1C0.447715 27 0 27.4477 0 28C0 28.5523 0.447715 29 1 29H55C55.5523 29 56 28.5523 56 28C56 27.4477 55.5523 27 55 27Z" fill="black"></path>
						<path d="M5 21H7V22C7 22.5523 7.44772 23 8 23C8.55228 23 9 22.5523 9 22V18C9 17.4477 8.55228 17 8 17C7.44772 17 7 17.4477 7 18V19H5V7C5 4.23858 7.23858 2 10 2C12.7614 2 15 4.23858 15 7V7.09021C12.116 7.57866 10.004 10.0749 10 13C10.0016 13.5516 10.4484 13.9984 11 14H21C21.5516 13.9984 21.9984 13.5516 22 13C21.996 10.0749 19.884 7.57866 17 7.09021V7C17 3.13401 13.866 0 10 0C6.13401 0 3 3.13401 3 7V25.5H5V21Z" fill="black"></path>
						</svg> Nhà tắm: {ROW.bath_room}
					</li>
					<li>
						<svg viewBox="0 0 42 32" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M41 0H13C12.45 0 12 0.45 12 1V10H1C0.45 10 0 10.45 0 11V31C0 31.55 0.45 32 1 32H29C29.55 32 30 31.55 30 31V22H41C41.55 22 42 21.55 42 21V1C42 0.45 41.55 0 41 0ZM28 30H2V12H28V30ZM40 20H30V11C30 10.45 29.55 10 29 10H14V2H40V20Z" fill="black"></path>
						</svg> Diện tích: {ROW.area} <sup>m<sup>2</sup></sup>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- END: loop -->
</div>
</div>
<!-- END: main -->