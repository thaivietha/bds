<!-- BEGIN: tree -->
<li>
	<a title="{MENUTREE.note}" href="{MENUTREE.link}"{MENUTREE.target}>{MENUTREE.title}</a>
	<!-- BEGIN: tree_content -->
	<ul>
		{TREE_CONTENT}
	</ul>
	<!-- END: tree_content -->
</li>
<!-- END: tree -->
<!-- BEGIN: main -->
<ul class="treeview">
	<!-- BEGIN: loopcat1 -->
	<li {CAT1.class}>
		<a title="{CAT1.note}" href="{CAT1.link}"{CAT1.target}>{CAT1.title}</a>
		<!-- BEGIN: cat2 -->
		<ul>
			{HTML_CONTENT}
		</ul>
		<!-- END: cat2 -->
	</li>
	<!-- END: loopcat1 -->
</ul>
<div class="clear"></div>
<!-- END: main -->