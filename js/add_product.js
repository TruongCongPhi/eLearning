	document.querySelector('.bootstrap-touchspin-down').addEventListener('click', function() {
		    var input = document.querySelector('.input-qty');
		    var currentValue = Number(input.value);
		    if (currentValue > 0) {
		        input.value = currentValue - 1;
		    }
		});

		document.querySelector('.bootstrap-touchspin-up').addEventListener('click', function() {
		    var input = document.querySelector('.input-qty');
		    var currentValue = Number(input.value);
		    input.value = currentValue + 1;
		});
		document.querySelector('.btn.btn-primary').addEventListener('click', function() {
	    window.location.href = 'admin.html';
	});