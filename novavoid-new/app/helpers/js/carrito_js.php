<script>
	$(document).ready(inicializarEventos);

	function inicializarEventos() {
		$(document).on('click', '#agregar', function() {	
			let id_producto = $(this).attr('data-producto');
			let cantidad = 1;

			console.log(id_producto)
			console.log(cantidad)
			$.ajax({
		        url: '#path#carrito/agregar_producto_lista',
		        type: 'POST',
		        dataType: 'json',
		        data: {id_producto:id_producto,cantidad:cantidad},
		    })
		    .done(function(response) {
		        console.log("success");
		        console.log(response.status);
		        if(response.status == true){
					alert('producto agregado')
					window.location.reload()
				}
		    })
		    .fail(function(response) {
		        console.log("error");
		        console.log("no paso bien por aca");
		    })
		    .always(function(response) {
		        console.log("complete");
		    });
		});
	}

	function eliminar_de_lista(id_producto) {
		$.ajax({
			url: '#path#carrito/eliminar_lista',
			type: 'POST',
			dataType: 'json',
			data: {id_producto: id_producto},
		})
		.done(function(response) {
			console.log("success");
			console.log(response);
			if(response.status == true){
				alert('producto eliminado')
				window.location.reload()
			}
			console.log("paso bien por aca eliminar producto");
		})
		.fail(function(response) {
			console.log("error");
			console.log("no paso bien por aca eliminar producto");
		})
		.always(function(response) {
			console.log("complete");
			console.log(response);
		});
	}
</script>