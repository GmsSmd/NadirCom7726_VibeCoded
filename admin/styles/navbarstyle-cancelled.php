@import url(http://fonts.googleapis.com/css?family=Lato:300,400,700);
@charset "UTF-8";
/* Base Styles */
#cssmenu > ul,
#cssmenu > ul li,
#cssmenu > ul ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
#cssmenu > ul {
  position: relative;
  z-index: 597;
  float: left;
}
#cssmenu > ul li {
  float: left;
  min-height: 1px;
  line-height: 1.3em;
  vertical-align: middle;
  padding: 5px;
}
#cssmenu > ul li.hover,
#cssmenu > ul li:hover {
  z-index: 599;
  cursor: default;
}
#cssmenu > ul ul {
  visibility: hidden;
  position: absolute;
  top: 100%;
  z-index: 598;
}
#cssmenu > ul ul li {

  float: none;
}
#cssmenu > ul li:hover > ul {
  visibility: visible;
}
/* Align last drop down rtL */
/* Theme Styles */
#cssmenu > ul a:link {
  text-decoration: none;
}
#cssmenu > ul a:active {
  color: #ffa500;
}
#cssmenu li {
  padding: 0;
  color: #000;
}




/*main settings area*/
#cssmenu {
  font-family: 'Lato', sans-serif;
  border-radius: 3px;
  background: #658AC3;
  font-size: 13px;
  box-shadow: inset 0 2px 2px rgba(255, 255, 255, 0.3);
  position: fixed; 				/* Set the navbar to fixed position */
  right:0;
  top: 0; 						/* Position the navbar at the top of the page */
  width: 100%; 					/* Full width */
  }
  
  
  
  
  
  
#cssmenu > ul {
  padding: 0 5px;
  -moz-box-shadow: inset 0 -2px 2px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: inset 0 -2px 2px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0 -2px 2px rgba(0, 0, 0, 0.3);
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  -ms-border-radius: 3px;
  -o-border-radius: 3px;
  border-radius: 3px;
  display: block;
  float: none;
  zoom: 1;
}
#cssmenu > ul:before {
  content: '';
  display: block;
}
#cssmenu > ul:after {
  content: '';
  display: table;
  clear: both;
}
#cssmenu > ul > li {
  padding: 4px 4px;
}
#cssmenu > ul > li > a,
#cssmenu > ul > li > a:link,
#cssmenu > ul > li > a:visited {
  text-shadow: 0 -1px 1px #004881;
  color: #fff;
  padding: 10px 10px;
  display: block;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  -ms-border-radius: 3px;
  -o-border-radius: 3px;
  border-radius: 3px;
}
#cssmenu > ul > li > a:hover,
#cssmenu > ul > li:hover > a {
  //background-color: #E0E5F5;
  background-color: #0082e7;
}
#cssmenu li li a {
  
  color: Black;
  //color: #8b8b8b;
  font-size: 13px;
}
#cssmenu li li a:hover {
  color: #5c5c5c;
  border-color: #5c5c5c;
}
#cssmenu ul ul {
  //margin: 0 10px;
  padding: 0 3px;
  float: none;
  background: #E0E5F5;
  border: 2px solid #1b9bff;
  border-top: none;
  //right: 0;					// controls start position of sub ul from its parent li.
  //left: 0;					// controls start position of sub ul from its parent li
  -webkit-border-radius: 0 0 3px 3px;
  -moz-border-radius: 0 0 3px 3px;
  -ms-border-radius: 0 0 3px 3px;
  -o-border-radius: 0 0 3px 3px;
  border-radius: 0 0 3px 3px;
  -moz-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.2);
  -webkit-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.2);
  box-shadow: 0 2px 3px rgba(0, 0, 0, 0.2);
}
#cssmenu ul > li > ul > li {
  margin: 0 3px 0 0;
  position: relative;
  padding: 0;
  float: left;
}
#cssmenu ul > li > ul > li > a {
  padding: 10px 20px 10px 10px;
  display: block;
}
#cssmenu ul > li > ul > li.has-sub > a:before {
  content: '';
  position: absolute;
  top: 18px;
  right: 6px;
  border: 5px solid transparent;
  border-top: 5px solid #8b8b8b;
}
#cssmenu ul > li > ul > li.has-sub > a:hover:before {
  border-top: 5px solid #5c5c5c;
}
#cssmenu ul ul ul {
  width: 160%;
  top: 100%;
  border: 1px solid #1b9bff;
}
#cssmenu ul ul ul li {
  float: none;
}

#cssmenu ul li h3{
	padding: 7px 20px;
	color: #FFD700;
	text-shadow: -2px -3px 2px 	#C71585;
}
