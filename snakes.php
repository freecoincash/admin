<section id="form-page">

<div class="container">

<div class="row">

<div class="col-md-12" >
<div class="panel panel-default" id="duh">
<div class="panel-body">

<?php if(settings("gameSatoshiSnake") == 1) { ?>
	
<script src="assets/js/sha512.js"></script>

<center><canvas id="canvas" width="840" height="420"></canvas></center>

<script>

<?Php

echo 'var super_tag_taggle = ' . settings("snakeScoreSatoshi") . ';
var user_meta = "' . $_SESSION['user_id'] . $_SESSION['user_name'] . $_SESSION['user_email'] . '";
var firefirefire = "' . hash("sha512",$_SESSION['user_email'] . $_SESSION['user_id'] . $_SESSION['user_name'] . "devareeb") . '";';

?>

eval((function(){var l=[86,72,76,80,66,70,74,88,65,81,94,71,90,87,85,89,60,82,75,79];var k=[];for(var h=0;h<l.length;h++)k[l[h]]=h+1;var i=[];for(var p=0;p<arguments.length;p++){var q=arguments[p].split('~');for(var x=q.length-1;x>=0;x--){var e=null;var c=q[x];var j=null;var o=0;var z=c.length;var g;for(var a=0;a<z;a++){var y=c.charCodeAt(a);var t=k[y];if(t){e=(t-1)*94+c.charCodeAt(a+1)-32;g=a;a++;}else if(y==96){e=94*(l.length-32+c.charCodeAt(a+1))+c.charCodeAt(a+2)-32;g=a;a+=2;}else{continue;}if(j==null)j=[];if(g>o)j.push(c.substring(o,g));j.push(q[e+1]);o=a+1;}if(j!=null){if(o<z)j.push(c.substring(o));q[x]=j.join('');}}i.push(q[0]);}var b=i.join('');var m='abcdefghijklmnopqrstuvwxyz';var u=[92,39,96,10,126,42].concat(l);var s=String.fromCharCode(64);for(var h=0;h<u.length;h++)b=b.split(s+m.charAt(h)).join(String.fromCharCode(u[h]));return b.split(s+'!').join(s);})('VB_$_4b0a=["#canvas","2d","right","undefined","white","black","left","up","down","S@h@o-512","TE@nT","@hE@n","programmer?method=send_score_snakes","score=","&burning_VA=","@j@zST","Content-type","application/x-www-form-urlencoded","@kTC: ","#2780e3","37","38","39","40"];$(document).ready(V4){V0D06=$(V70])[0];V0E7E=V<D06.getContextV1])V+VD=$(V70]).width();VBV)=$(V70]).height();varV,=10;V0@l3@o;VBV-V+16EV+1CC;V(C054(){_0V 2];V<E20();V<DC2();V>16E= 0;if( typeof game_loop!= V73]){clearInterval(game_loop)};game_loop= setIntervalV;0@k2,60)}V>054();V(@kE20(V*4@kC=5;V5= [];for(VBV2=V>4@kC- 1V/>= 0V/--){V5.push({x:V2,y:0})}}V(@kDC2(){V-= {x:Math.round(Math.random()@f V;VD-V,)/V,),y:Math.round(Math.random()@f (V)-V,)/V,)}}V0C@o8= new @orray(33,34,35,36,37,38,39,40);$(document).keydown(V4V>288V*2E6=V>288.which;if($.in@orrayV;2E6,V<C@o8)>  -1){V>288.preventDefault();V9false};V9true});V(C0@k2(){V\'V&4];V\'@xect(0,0,V>VD,V));V%V&5];V%@xect(0,0,V>VD,V))V+VFV5[0].xV+5D6=V5[0].y;if(_VEV#2]){V>578++V._VEV#6]){V>578--V._VEV#7VCV8--V._VEV#8VCV8++}}}};ifV;578== -1|| V>578== V>VD/V,|| _V8== -1|| _V8== V)/V,|| V<D64V;578,_V8,V5)){V>634V;16E);V>054();return};V(C634V;VH){ifV;VH>= superVGVGgleV*868= new jsS@h@o(V79],V30]);V>868.update(user_meta+ V>VH);VA= V>868.get@hashV11]);VA= VA+ VAVAVAV+74E= new @nM@i@http@xequest()V+8C6=V32]V+7@oC=V33]+ V>VH+ V34]+ VA;_V6openV15],V>8C6,true);_V6set@xequest@headerV16],V37]);_V6onreadystatechange= V4){if(_V6readyState== 4&& _V6status== 200){}};_V6sendV;7@oC)}}ifV;578== V-.x&& _V8== V-.yV*6@l0={x:V>578,y:_V8};V>16E= ((+V>16E) + (+superVGVGgle));V>16E= parse@lloatV;16E);V<DC2()}else {VB_0V:=V5.pop();_0V:.x= V>578;_0V:.y= _V8};V5.unshift(_0V:);for(VBV2=0V/@w V5.lengthV/++V*51@o=V5[V2];V>110V;51@o.x,V>51@o.y)};V>110(V-.x,V-.y)V+692=V38]+ V>16E.to@lixed(8);V\'TextV;692,5,V)- 5)}V(C110V;400,V>45E){V\'V&19];V\'V?V;400@fV,,V>45E@f _0V$,V<EDC);V%V&4];V%V?V;400@fV,,V>45E@f _0V$,V<EDC)}V(@kD64V;400,V>45E,V>344){for(VBV2=0V/@w V>344.lengthV/++){ifV;344[V2].x== V>400&& V>344[V2].y== V>45E){V9true}};V9false}$(document).keydown(V4V>288V*2E6=V>288.which;if(V![20V@0x1V"2VC0V 6]V.V![21V@0x1V"8VC0V 7]V.V![22V@0x1V"6VC0V 2]V.V![23V@0x1V"7VC0V 8]}}}}})})~x1@k@l3@o= V7~V>2E6== _$_4b0a~@k@l3@o!= V7~k@l3@o== V7~x1@kEDC,V<EDC~V<E7E.stroke~Style= V7~V<E7E.fill~function _0x1~V<@l@l6~){var V>~;var V>~ V<EDC~V<@l98~}else {if(~;V2~var V<~(V3~V>3@o2~V71~function(~V>1CC~0x1C74E.~_$_4b0a[~0x1C5D6~return ~x1C6@l0~(V>~_VEk~V?(~_0x1C~@xect~]&& _~fire~var ~]){_~22@o~0x1@~578=~_tag~80@o'));

</script>

<br>

<center><small>You earn upto <b><?php echo settings("snakeScoreSatoshi"); ?></b> BTC per block collected, you will be paid for <b><?php echo settings("snakesLimitDaily"); ?></b> game rounds (at maximum) in a day, and your maximum score per game round can be <b><?php echo settings("maximumRoundScore"); ?></b> BTC.</small></center>

<?php } else {
	
echo '<div class="alert alert-danger">
The game has been disabled by the administrator.
</div>';
	
}

?>

</div>
</div>

</div>
</div>
</div>
</section>