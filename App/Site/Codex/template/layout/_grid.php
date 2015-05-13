<div class="typography">
	<p>This grid was obtained from <a href="#">somewhere</a> and allows you to generate a grid using mixins.</p>
	<p>The grid can only be created using mixins to allow flexibility for rwd. When the layout needs to change this can be managed with media queries.</p>
</div>
<div class="example-code">
	<div class="cols">
		<div class="col-six">6 Columns</div>
		<div class="col-six">6 Columns</div>
	</div>
	<div class="cols">
		<div class="col-four">4 Columns</div>
		<div class="col-four">4 Columns</div>
		<div class="col-four">4 Columns</div>
	</div>
</div>
<pre class="rainbow-pre"><code data-language="css">@include row;
@include col(6);
@include last;</code></pre>
