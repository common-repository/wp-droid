<?php

$defaultAppCSS = "

@import url('https://fonts.googleapis.com/css?family=Droid+Serif');

html{
  -ms-text-size-adjust:100%;
  -webkit-text-size-adjust:100%
}

abbr[title]{border-bottom:1px dotted}

body {
    	margin:0;
	color: #000;
	font-family: 'Droid Serif', serif;
	font-size: 17px;
    	line-height: 30px;
    	background: #fff;
}


p a {
   /* background-color: rgba(1,87,155,.05); */
	color: #2b6dad;
  text-decoration: none;
  padding:2px;

}

h3 a, h4 a, h5 a, h6 a{
	color: #2b6dad;
	background-color:none!important;
	padding: 0px;
}


embed,
iframe,
img,
object,
video,
.wp-caption,
.wp-caption-text,
figcaption,
figure{
	max-width: 100%;
}


.wp-caption-text,
figcaption,
figure {
  padding-left: 0;
  margin-left: 0;
}

h1, h2, h3, h4, h5, h6, p {
	margin-left: 16px;
        margin-right: 16px;
        font-family: 'Droid Serif', serif;
}

h2 {
	font-size: 24px;
}

h3, h4, h5, h6 {
	font-size: 20px;
}

img{
  border:0;
  margin: 0;
  height: auto;
}

p {
	font-size: 17px!important;
    	line-height: 30px;
}

.wp-caption-text {
  font-size: 13px!important;
  color: #424242;
  font-family: serif;
  text-align: center;
  margin-top: 0;
  margin-right: 10%;
  margin-left: 10%;
}


blockquote, blockquote p {
    font-family: serif;
    background-color: #f6f6f6;
    color: #666;
}


blockquote span {
  color: #666!important;
}

blockquote p a {
  text-decoration: none;
  background: none;
  color: #2b6dad;
}

/* ## Tables
--------------------------------------------- */

table {
	font-size: 17px;
	border-collapse: collapse;
	border-spacing: 0;
	line-height: 2;
	width: 100%;
}

tbody {
	border-bottom: 1px solid #ddd;
}

td,
th {
	text-align: left;
}

td {
	border-top: 1px solid #ddd;
	padding: 6px 0;
}

th {
	font-weight: 400;
}

table a:link {
	color: #2b6dad;
	text-decoration:none;
}
table a:visited {
	color: #2b6dad;
	text-decoration:none;
}
table a:active,
table a:hover {
	color: #2b6dad;
	text-decoration:underline;
}

table th {
	padding:11px 15px 12px 15px!important;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;

	background: #ededed;
	background: -webkit-gradient(linear, left top, left bottom,
from(#ededed), to(#ebebeb));
	background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
table th:first-child {
	text-align: left;
	padding-left:10px!important;
}
table tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
table tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
table tr {
	text-align: center;
	padding-left:10px!important;
}
table td:first-child {
	text-align: left;
	padding-left:10px!important;
	border-left: 0;
}
table td {
	padding:9px!important;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;

	background: #fafafa;
	background: -webkit-gradient(linear, left top, left bottom,
from(#fbfbfb), to(#fafafa));
	background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
}
table tr.even td {
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom,
from(#f8f8f8), to(#f6f6f6));
	background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
}
table tr:last-child td {
	border-bottom:0;
}
table tr:last-child td:first-child {
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
table tr:last-child td:last-child {
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
table tr:hover td {
	background: #f2f2f2;
	background: -webkit-gradient(linear, left top, left bottom,
from(#f2f2f2), to(#f0f0f0));
	background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);
}
";


define('wpdroid_DEFAULT_APP_CSS', $defaultAppCSS);


$defaultInviteFriends = "Download the official Android app of ". get_bloginfo('name') . " from Google Play Store - [ADD YOUR PLAYSTORE OR OTHER DOWNLOAD LINK]" ;
define('wpdroid_DEFAULT_INVITE_FRIENDS_TEXT', $defaultInviteFriends);

?>
