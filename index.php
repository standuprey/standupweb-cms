<?php
session_start();
require_once('swcms/lib/php/DOLib.php');
connect();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>New Web Project</title>
        <!--[if IE]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="swcms/css/standupwebcms.css" type="text/css" media="all" />
        <style type="text/css">
            #wraper {
                width: 850px;
                margin: 0 auto;
				background-color: #27305b;
            }
            #big-wraper {
                width: 920px;
                margin: 0 auto;
			    -webkit-border-radius: 15px;
			    -moz-border-radius: 15px;
			    border-radius: 15px;
                background-color: #83abaa;
            }
            
            nav, header, section, footer, article {
                display: block;
                font-family: Verdana, Lucida, sans-serif;
                margin: 0;
                padding: 8px;
            }
            
            #content li {
            	margin-bottom:10px;
            }
            
            header {
            	height: 120px;
            	padding:15px 0 15px 0;
                background-color: #83abaa;
            }
            
            nav {
                background-color: #27305b;
                float: left;
                width: 200px;
                height: 100%;
                color: #fff;
            }
            a, a:active, a:link, a:visited { color:#ddf }
            a:hover { color:#aad }
            
            section#content {
                background-color: #27305b;
                margin-left:
                200px;
                height:
                100%;
                color:#fff;
            }
            
            footer {
                background-color: #83abaa;
                clear: both
            }
            
            ul {
                margin-left: 0;
                padding-left: 0;
                list-style-type: none;
            }
            
            nav ul li a {
                display: block;
                padding: 3px;
                width: 160px;
                background-color: #e6cc41;
                border-bottom: 1px solid #eee;
            }
            
            nav ul li a:link, nav ul li a:visited {
                color: #111;
                text-decoration: none;
            }
            
            nav ul li a:hover {
                background-color: #fff4c8;
                color: #000;
            }
            
            footer ul li {
                display: inline
            }
             @font-face {
				font-family: bauhaus;
				src: url( css/BAUHS93.eot ); /* IE */  
				src: local("Bauhaus 93"), url( css/BAUHS93.TTF ) format("truetype"); /* non-IE */ 
			 }
            H1,H2 {
				font-family: bauhaus, Verdana, Lucida, sans-serif;
				text-shadow: 3px 3px 7px #111;
            	display: inline;
                color: #fff;
            }
            #logo {
            	float:right;
            	display: inline;
            }
        </style>
    </head>
    <body>
        <div id='big-wraper'>
	        <div id='wraper'>
	            <header>
	                <div id='logo'>
	                <?php StaticAsset::includePicture('logo')?>
	                </div>
	                <h1>
	                <?php StaticField::includeText('title')?>
	                </h1>
	            </header>
	            <nav>
	                <article>
						<?php StaticField::includeText('listOfLinks')?>
	                    <ul>
	                        <?php StructuredField::printField('listOfLinks', "<li>\n<a href='@@1'>@@2</a>\n</li>\n");?>
	                    </ul>
	                </article>
	            </nav>
	            <section id='content'>
	                <article>
	                    <h2><?php StaticField::includeText('content-title')?></h2>
	                    <ul>
	                        <?php StructuredField::printField('listOfContents', "<li>\n@@1\n</li>\n");?>
	                    </ul>
	                </article>
	            </section>
	            <footer>
	            	<?php StaticField::includeText('listOfPictures')?>
	                <ul>
						<?php StructuredField::printField('listOfPictures', "<li>\n<img src='swcms/assets/@@a1' alt='@@t1'></img>\n</li>\n");?>
	                </ul>
	            </footer>
	        </div>
        </div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-16061291-1");
pageTracker._trackPageview();
} catch(err) {}</script>

    </body>
</html>
