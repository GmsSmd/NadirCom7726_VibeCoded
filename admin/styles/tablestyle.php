<style>
#cntnr{
	
}
.container{
			margin-top:50px;
			position: static;
		}
.SubDiv{
			width: 90%;
		}

.SubDiv1, .SubDiv2, .SubDiv3
{
	max-height: 400px;
	overflow: auto;
}

.SubDiv2
{
	width: 99%;
}


.SubDiv3
{
	max-height: 265px;
}

	
.left{
	float: left;
	width: 33%;
	clear: left;
}
.center, .scrollBottom{
	float: center;
	width: 33%;
	clear: none;
	
}
.right{
	float: right;
	width: 33%;
	clear: right;
}


#center{
	float: center;
	//width: 33%;
	clear: none;
	
}


body {
	background: linear-gradient(to bottom, #ADBEE4 10%, #ADBEE4 50%);
	}
	
table#dbResult tr:nth-child(odd) {
									background-color: #ADBEE0;
								}

table#dbResult th {
					color: Black;
					background-color: #E0E5F5;
					}

table		{
			border-radius: 10px;
			border-collapse: collapse;
			width: 100%;
			background-color: #E0E5F5;
			//max-height: 400px;
		}
//table thead
//{
	
	//position: fixed;
	//display: block;
	width: 100%;
	//overflow: auto;
	//color: #fff;
	//background: #000;
//}


//thead, tbody
//{
	//display: block;
//	width: 500px;
//	height: 200px;
//	background: pink;
	//overflow: auto;
//}



//th,td
//{
//	padding: .5em 1em;
//	text-align: left;
//	vertical-align: top;
//	border-left: 1px solid #fff;
//}
		
		
		
		
		
		
		

//th1	
//{
			//background-color: #4CAF50;
			//color: white;
			//text-align: center;
			//height: 15px;
			//padding: 0;
			//margin: 0;
		//}


tr:hover 
		{
			//background-color: #bbbbbb;
		}


td 	{
    text-align: left;
    padding: 4px;
	}

#iBox, #tBox, #sBox{
    height: 25px;
	width: 200px;
    box-sizing: border-box;
}
#iBox1, #tBox1, #sBox1{
    height: 25px;
	width: 100px;
    box-sizing: border-box;
}
#iBox2, #tBox2, #sBox2{
    height: 25px;
	width: 50px;
    box-sizing: border-box;
}
#iBox3, #tBox3, #sBox3{
    height: 25px;
	width: 25px;
    box-sizing: border-box;
}
#iBoxSpecial, #tBoxSpecial, #sBoxSpecial{
    height: 25px;
	width: 85px;
    box-sizing: border-box;
}
#Btn{
    height: 25px;
	width: 90px;
    box-sizing: border-box;
}
#BtnBig{
    height: 75px;
	width: 90px;
    box-sizing: border-box;
}
#BtnMed{
    height: 50px;
	width: 90px;
    box-sizing: border-box;
}

 h1,h2,h3,h4{
	padding:0px;
	margin: 0px;
 } 
 
 
 
div.doBar{
    width:90%;
    clear:both;
   }

   
   
#doLink:hover{
    border:1px solid yellow;
  	box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
	transition: ease 0.3s;
   }
 
#doLink
{
	font: bold 14px Arial;
	text-decoration: none;
	color: Black;
	//background: #eee;
	//background: #4E9CAF;
	
	display: inline-block;
	margin-right:10px;
	width: 120px;
    height: 15px;
	border: 1px solid green;
	border-radius: 5px;
	padding: 6px;
}

#doLinkSelected
{
	font: bold 14px Arial;
	text-decoration: none;
	color: Brown;
	background: #eee;
	//background: #FFF8DC;
	//background: #4E9CAF;
	
	
	display: inline-block;
	margin-right:10px;
	width: 120px;
    height: 15px;
	//border: 1px solid green;
	border-radius: 5px;
	padding: 7px;
}





#LinkBtnEdit {
	//display: block;
	font: bold 12px Arial;
	text-decoration: none;
	background-color: green;
	color: white;
	padding: 4px;
	border: 1px solid yellow;
}

#LinkBtnDel {
	//display: block;
	font: bold 12px Arial;
	text-decoration: none;
	background-color: red;
	color: white;
	padding: 4px;
	border: 1px solid yellow;

}

#subHead
{
	font: bold 24px calibary;
}

#myDIV {
	display: none;
	
		//width: 100%;
		//padding: 50px 0;
		//text-align: center;
		//background-color: lightblue;
		//margin-top:20px;
		}
		
		
		
#header-fixed{
    //position: fixed;
    //top: 0px; display:none;
    //background-color:white;
}

/* Style the tab */
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}


</style>