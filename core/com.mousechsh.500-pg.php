<?php
	echo '<!--';
	echo 'Page 500 at ';
	echo date("Y-m-d H:i:s");
	echo '-->';
	echo "\r\n";
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>500</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div id="my500" style="position: fixed; font-size: 72px;"><span id="id1">5</span><span id="id2">0</span><span id="id3">5</span><span id="id4">@</span><span id="id5">MouseChsh.com</span></div>
	</body>
	<script>
		( function(){

			var m4 = document.getElementById( 'my500' );
			var i1 = document.getElementById( 'id1' );
			var i2 = document.getElementById( 'id2' );
			var i3 = document.getElementById( 'id3' );
			var i4 = document.getElementById( 'id4' );
			var i5 = document.getElementById( 'id5' );
			setInterval( function(){

				i1.style.color = '#' + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase();
				i2.style.color = '#' + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase();
				i3.style.color = '#' + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase();
				i4.style.color = '#' + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase();
				i5.style.color = '#' + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase() + parseInt( Math.random() * 256 ).toString( '16' ).toUpperCase();
				m4.style.fontSize = parseInt( 16 + Math.random() * 56 ) + 'px';
				m4.style.top = parseInt( Math.random() * ( document.body.offsetHeight - m4.offsetHeight ) ) + 'px';
				m4.style.left = parseInt( Math.random() * ( document.body.offsetWidth - m4.offsetWidth ) ) + 'px';

			}, 1000 );

		} )();
	</script>
</html>
