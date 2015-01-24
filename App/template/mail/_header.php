<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title></title>
	<style type="text/css">
		.ExternalClass {
			width:100%;
		} /* Force Hotmail to display emails at full width */

		.ExternalClass,
		.ExternalClass p,
		.ExternalClass span,
		.ExternalClass font,
		.ExternalClass td,
		.ExternalClass div {
			line-height: 100%;
		} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */

		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
			color: red !important;
		 }

		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
			color: purple !important;
		}

		table td {
			border-collapse: collapse;
		}

		@media screen and (max-device-width: 480px) {
			p {
				background: blue;
			}
			a[href^="tel"], a[href^="sms"] {
				text-decoration: none;
				color: black; /* or whatever your want */
				pointer-events: none;
				cursor: default;
			}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration: default;
				color: orange !important; /* or whatever your want */
				pointer-events: auto;
				cursor: default;
			}
		}

		/* ipad, smaller tablets */
		@media screen and (min-device-width: 768px) and (max-device-width: 1024px) {
			p {
				background: red;
			}
			a[href^="tel"], a[href^="sms"] {
				text-decoration: none;
				color: blue; /* or whatever your want */
				pointer-events: none;
				cursor: default;
			}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration: default;
				color: orange !important; /* or whatever your want */
				pointer-events: auto;
				cursor: default;
			}

			table[class="hide"]
			, img[class="hide"]
			, td[class="hide"] {
				display:none !important;
			}

			table[class="content"] {
			    width: 92% !important;
		    }

		    a[class="button"] {
				display: block;
				padding: 7px 8px 6px 8px;
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
				color: #fff !important;
				background: #f46f62;
				text-align: center;
				text-decoration: none !important;
		    }
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 2) {
			/* Put your iPhone 4g styles in here */
		}

		@media only screen and (-webkit-device-pixel-ratio:.75){
			/* Put CSS for low density (ldpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1){
			/* Put CSS for medium density (mdpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1.5){
			/* Put CSS for high density (hdpi) Android layouts in here */
		}
	</style>

	<!-- Targeting Windows Mobile -->
	<!--[if IEMobile 7]>
	<style type="text/css">

	</style>
	<![endif]-->

	<!--[if gte mso 9]>
	<style>
		/* Target Outlook 2007 and 2010 */
	</style>
	<![endif]-->
</head>
<body style="{body}">

	<!-- 
	exmapl html code

	<img class="image_fix" src="full path to image" alt="Your alt text" title="Your title text" width="x" height="x" />

	<span class="mobile_link">123-456-7890</span>

	-->

<!-- control width and background colour -->
<table style="{table} {background-table}" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" width="100%">
<tr>
	<td align="center" style="{padding} margin-left: auto; margin-right: auto;">

		<!-- core width container padding required for the  -->
		<table style="{table}" cellpadding="0" cellspacing="0" border="0" width="600">
		<tr>
			<td valign="top" align="left">

				<!-- logo -->
				<table width="100%" style="{table} {container_fullwidth} background: #ffffff; border-bottom: 1px solid; border-{color-gray-30} margin-bottom: 1em;" cellpadding="0" cellspacing="0" border="0" align="center" class="email-fade">
				<tr>
					<td width="300" valign="top">
						<a style="{a}" href="<?php echo $this->getUrl() ?>" title="Open homepage"><img src="<?php echo 'logo url' ?>" alt="website name" width="200" height="44"></a>
					</td>
				</table>

				<!--
					content
					content goes here
				-->
				<table width="100%" style="{table}" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td valign="top" align="left" style="padding-bottom: 3em; border-bottom: 1px solid; border-{color-gray-30} background-color: #ffffff;">
