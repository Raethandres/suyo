
$(document).ready(function(){
let con=0;
let sw=Array();
let mt=false;
var onTd=true;
	$.ajax({
            type: 'delete',
            url: 'php/index.php',
            data:"delete",
            dataType:'JSON',
            success: function (result) {
              console.log(result);
              
            }
          });
$("#send").on('click',function(){
	console.log("22222ww")
	$.ajax({
            type: 'post',
            url: 'php/index.php',
            data:"www",
            dataType:'JSON',
            success: function (result) {
              console.log(result);
              
            }
          });
})

$("#enviar").on('click',function(){
	if ($('#punto').val()!=="" && $('#contenedor').val()!=="" && !mt) {
		mt=true
		$("#ins").before("<div class='header center'><h1 >Matris de distribucion</h1></div>")
		$("#ins").before("<div class='center'><h2>las filas son los componentes y las columnas los puntos </h2></div>")
		let r=""
		for (var i = 0; i < parseInt($('#punto').val()); i++) {
					r+="<p class='item'>"+i+"</p>"
				}
		$("#ins").before("<div class='center'>"+r+"</div>")

		for (var i = 0; i < parseInt($('#contenedor').val()); i++) {
		console.log(34)
		let pun=""
		for (var j = 0; j < parseInt($('#punto').val()); j++) {
					pun+="<input type='number' name='"+i+"/"+j+"'>"
				}
		$("#ins").before("<div class='center'> <p>"+i+"</p>"+pun+" </div>")
		$("#ins").before("<input type='hidden' name='crsf' value='matriz'/>")
	}
		// $.ajax({
  //           type: 'post',
  //           url: 'php/index.php',
  //           data:$('#form').serialize(),
  //           dataType:'JSON',
  //           success: function (result) {
  //             console.log(result);
              
  //           }
  //         });
	}else{
		if (!mt) {$('#form').append('<div class="center"> <p >NO INVENTE </p> </div>')}
		else{
			var matriz=$('#form').serializeArray()
			$.ajax({
            type: 'post',
            url: 'php/index.php',
            data:$('#form').serializeArray(),
            dataType:'JSON',
            success: function (result) {
              console.log(result);
              
            }
          });
			
			$("#c").html("<div><div class='header center'><h1 id='cabeza'>A jugar</h1></div><div class='center' id='juego'></div>")
			createT(matriz)
		}
		
	}

	

})


function createT(arg) {
	console.log(arg)

	Dicc()
	var tai="<table>"
	var tae="</table>"
	var tri="<tr>";
	var tdi="<td ";
	var tre="</tr>";
	var tde="</td>";
	var da="";
	var conn=-1
    for (var i = 2; i <arg.length; i+=parseInt(arg[1].value)+1) {
    	conn++
    	console.log(parseInt(arg[0].value),"contenedor")
    	let half=0
		var h=Array()
		var col=Array()

    	console.log(i,"i")
		for (var k = i; k < i+parseInt(arg[1].value); k++) {
			console.log(half,arg[k],"half")
			half+=parseInt(arg[k].value)
			col.push(parseInt(arg[k].value))
		}
		if((half/2)-parseInt(half/2)>0){
			h.push(parseInt(half/2))
			h.push(half-parseInt(half/2))
		}else{
			h.push(half/2)
			h.push(half/2)
		}
		console.log(h,"h",col)
		da+="<div class='item'>"
    	da+=tai;
	    for (var j = 0; j <parseInt(half/2); j++) {
	    	console.log(j,"j")
	    	da+=tri;
	    	for (var z = 0; z <h[j]; z++) {
	    		let re=Asignar(col)
	    	
	    		da+=tdi+"id='"+conn+"' style='background:"+ color[re]+";' >"+ re+tde
	    	}
	    	da+=tre;
	    }
	    da+=tae;
	     da+="</div>"
    }

    console.log(da)
    $('#juego').html(da)

    $("td").on('click',function(){
		if (onTd) {
			if (sw.length>0 && $(this).attr("id")!=sw[0].attr("id")) {
				console.log($(this).html(),$(this).attr("id"))
				con+=1
				sw.push($(this))
				swap()
			}else if (con<1){
				console.log($(this).html(),$(this).attr("id"))
				con+=1
				sw.push($(this))
			}
		}
	
	
})
}
var color=Array()
function Dicc(argument) {
	
	let hexa=Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F")
	let ch="#"
	for (var j = 0; j < 100; j++) {
		for (var i = 0; i < 6; i++) {
		ran=Math.floor(Math.random()*(6-0))
		ch+=hexa[ran]
		}
		if(ch!="#FFFFFF")
		color.push(ch)
		console.log(ch,color)
		ch="#"
	}
}	

function Asignar(arg) {
	for (var i = 0; i < arg.length; i++) {
		console.log(arg,"arg",i)
		if (arg[i]>=1) {
			arg[i]--
			return i
		}
	}
}
function swap() {
	if (con===2) {
		console.log(sw)
		dat={id1:sw[0].attr('id'),v1: sw[0].html(),v2: sw[1].html(),id2:sw[1].attr('id')}
		let r=""+sw[0].html()
		sw[0].html(""+sw[1].html())
		sw[1].html(r)
		sw[0].css("background",color[parseInt(sw[0].html())])
		sw[1].css("background",color[parseInt(sw[1].html())])
		con=0
		sw=Array()
		console.log(JSON.stringify(dat))
		$.ajax({
            type: 'put',
            url: 'php/index.php',
            data:dat,
            dataType:'JSON',
            success: function (result) {
              if (result) {
              	console.log(result)
              	if (result.Gano==="si") {
              		$('#cabeza').html("GANO")
              		onTd=false;
              		$('#juego').after("<div class='center' ><p class='boton' id='reload'>EMPEZAR</p></div>")
              		$("#reload").on('click',function(){
							location.reload()
						
					})
              	}
              }
              
            }
          });
	}
}


})

